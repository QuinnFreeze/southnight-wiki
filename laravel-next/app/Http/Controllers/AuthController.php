<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Audit;
use App\Support\EmailVerification;
use Illuminate\Http\Request;
use RuntimeException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showRecovery(Request $request)
    {
        $recoveryUser = $this->recoveryVerifiedUser($request);

        return view('auth.recovery', [
            'recoveryEmail' => (string) $request->session()->get('recovery_email', ''),
            'recoveryUser' => $recoveryUser,
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'identity' => 'required|string',
            'password' => 'required|string',
        ]);
        $user = User::where('username', $data['identity'])
            ->orWhere('email', EmailVerification::normalizeEmail($data['identity']))
            ->first();

        if (!$user || $user->status !== 'active' || !$user->verifyPassword($data['password'])) {
            return back()->withErrors(['identity' => '用户名、邮箱或密码不正确。'])->onlyInput('identity');
        }

        auth()->login($user, true);
        $request->session()->regenerate();
        $user->forceFill(['last_login_at' => now()])->save();
        Audit::record('user.login', 'user', (string) $user->id);

        return redirect()->intended(route('account'));
    }

    public function register(Request $request)
    {
        $request->merge(['email' => EmailVerification::normalizeEmail((string) $request->input('email'))]);
        $data = $request->validate([
            'username' => 'required|string|min:3|max:24|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:10|confirmed',
        ]);
        $data['name'] = $data['username'];
        $data['email'] = EmailVerification::normalizeEmail($data['email']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        unset($data['password_confirmation']);
        $data['role'] = User::count() === 0 ? 'admin' : 'user';
        $data['status'] = 'active';
        $data['email_verified_at'] = null;
        $user = User::createWithUniqueUid($data);
        Audit::record('user.register', 'user', (string) $user->id);
        auth()->login($user);
        $request->session()->regenerate();

        return redirect()->route('account')->with('status', '注册成功，请完成邮箱认证以启用邮箱账户功能。');
    }

    public function account()
    {
        $user = auth()->user();

        return view('auth.account', [
            'user' => $user,
            'emailPasswordAvailable' => (bool) $user->email_verified_at,
        ]);
    }

    public function sendEmailVerification(Request $request, EmailVerification $verification)
    {
        $user = $request->user();

        try {
            $result = $verification->issue($user->email, EmailVerification::PURPOSE_EMAIL);
        } catch (RuntimeException $exception) {
            return back()->withErrors(['email' => $exception->getMessage()]);
        }

        if (!($result['sent'] ?? false)) {
            return back()->with('status', '验证码已经发送过，请稍后再试。');
        }

        return back()->with('status', '验证码已发送，请检查邮箱。验证码 10 分钟内有效。');
    }

    public function verifyEmail(Request $request, EmailVerification $verification)
    {
        $data = $request->validate(['email_code' => ['required', 'digits:6']]);
        $user = $request->user();

        if (!$verification->verify($user->email, EmailVerification::PURPOSE_EMAIL, $data['email_code'])) {
            return back()->withErrors(['email_code' => '验证码不正确、已过期或已达到尝试次数上限。']);
        }

        $user->forceFill(['email_verified_at' => now()])->save();
        Audit::record('user.email.verify', 'user', (string) $user->id);

        return back()->with('status', '邮箱认证成功，现在可以使用邮箱认证修改密码。');
    }

    public function updateProfile(Request $request)
    {
        $request->merge(['email' => EmailVerification::normalizeEmail((string) $request->input('email'))]);
        $data = $request->validate([
            'email' => 'required|email|max:255|unique:users,email,'.auth()->id(),
            'current_password' => 'nullable|string',
        ]);
        $user = $request->user();
        $email = EmailVerification::normalizeEmail($data['email']);

        if ($email === EmailVerification::normalizeEmail($user->email)) {
            return back()->with('status', '资料没有变化。');
        }

        if (empty($data['current_password']) || !$user->verifyPassword($data['current_password'])) {
            return back()->withErrors(['current_password' => '修改邮箱需要先验证当前密码。']);
        }

        $user->forceFill([
            'email' => $email,
            'email_verified_at' => null,
        ])->save();
        Audit::record('user.profile.update', 'user', (string) $user->id);

        return back()->with('status', '邮箱已更新，请重新发送验证码完成认证。');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:10|confirmed',
        ]);
        $user = $request->user();

        if (!$user->verifyPassword($data['current_password'])) {
            return back()->withErrors(['current_password' => '当前密码不正确。']);
        }

        $this->setPassword($user, $data['password']);
        Audit::record('user.password.update', 'user', (string) $user->id);
        $request->session()->regenerate();

        return back()->with('status', '密码已更新，请重新登录其他设备。');
    }

    public function updatePasswordByEmail(Request $request)
    {
        $data = $request->validate(['password' => 'required|string|min:10|confirmed']);
        $user = $request->user();

        if (!$user->email_verified_at) {
            return back()->withErrors(['email_code' => '请先完成邮箱认证，再使用邮箱修改密码。']);
        }

        $this->setPassword($user, $data['password']);
        $request->session()->regenerate();

        return back()->with('status', '密码已更新，请重新登录其他设备。');
    }

    public function sendRecoveryCode(Request $request, EmailVerification $verification)
    {
        $data = $request->validate(['email' => 'required|email|max:255']);
        $email = EmailVerification::normalizeEmail($data['email']);
        $request->session()->put('recovery_email', $email);
        $user = User::where('email', $email)->where('status', 'active')->first();

        $message = '如果该邮箱对应有效账户，验证码已发送，请检查收件箱。';
        if (!$user) {
            return redirect()->route('account.recovery')->with('status', $message);
        }

        try {
            $result = $verification->issue($email, EmailVerification::PURPOSE_RECOVERY);
        } catch (RuntimeException $exception) {
            return back()->withErrors(['email' => $exception->getMessage()]);
        }

        return redirect()->route('account.recovery')->with('status', $message);
    }

    public function verifyRecoveryCode(Request $request, EmailVerification $verification)
    {
        $data = $request->validate([
            'email' => 'required|email|max:255',
            'email_code' => ['required', 'digits:6'],
        ]);
        $email = EmailVerification::normalizeEmail($data['email']);
        $user = User::where('email', $email)->where('status', 'active')->first();

        if (!$user || !$verification->verify($email, EmailVerification::PURPOSE_RECOVERY, $data['email_code'])) {
            return back()->withErrors(['email_code' => '邮箱或验证码不正确、已过期，或已达到尝试次数上限。'])->withInput();
        }

        if (!$user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }
        $request->session()->put('recovery_verified', [
            'user_id' => $user->id,
            'email' => $email,
            'expires_at' => now()->addMinutes(10)->timestamp,
        ]);
        Audit::record('user.recovery.email.verify', 'user', (string) $user->id);

        return redirect()->route('account.recovery')->with('status', '邮箱认证成功，请设置新密码。');
    }

    public function resetRecoveredPassword(Request $request)
    {
        $data = $request->validate(['password' => 'required|string|min:10|confirmed']);
        $user = $this->recoveryVerifiedUser($request);

        if (!$user) {
            $request->session()->forget('recovery_verified');
            return back()->withErrors(['email_code' => '找回验证已过期，请重新获取验证码。']);
        }

        $this->setPassword($user, $data['password']);
        $request->session()->forget(['recovery_verified', 'recovery_email']);
        auth()->login($user);
        $request->session()->regenerate();
        Audit::record('user.password.recovery', 'user', (string) $user->id);

        return redirect()->route('account')->with('status', '密码已重置，已为你登录账户。');
    }

    public function logout(Request $request)
    {
        $id = auth()->id();
        if ($id) {
            Audit::record('user.logout', 'user', (string) $id);
        }
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function setPassword(User $user, string $password): void
    {
        $user->forceFill([
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'password_hash' => null,
            'password_salt' => null,
        ])->save();
    }

    private function recoveryVerifiedUser(Request $request): ?User
    {
        $grant = $request->session()->get('recovery_verified');
        if (!is_array($grant) || (int) ($grant['expires_at'] ?? 0) < now()->timestamp) {
            if ($grant) {
                $request->session()->forget('recovery_verified');
            }
            return null;
        }

        return User::whereKey((int) ($grant['user_id'] ?? 0))
            ->where('email', $grant['email'] ?? '')
            ->where('status', 'active')
            ->first();
    }
}
