<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Audit;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }
    public function login(Request $request) { $data=$request->validate(['identity'=>'required|string','password'=>'required|string']); $user=User::where('username',$data['identity'])->orWhere('email',$data['identity'])->first(); if(!$user || $user->status !== 'active' || !$user->verifyPassword($data['password'])) return back()->withErrors(['identity'=>'用户名、邮箱或密码不正确。'])->onlyInput('identity'); auth()->login($user, true); $request->session()->regenerate(); $user->forceFill(['last_login_at'=>now()])->save(); Audit::record('user.login','user',(string)$user->id); return redirect()->intended(route('account')); }
    public function register(Request $request) { $data=$request->validate(['username'=>'required|string|min:3|max:24|unique:users,username','email'=>'required|email|max:255|unique:users,email','password'=>'required|string|min:10|confirmed']); $data['name']=$data['username']; $data['password']=password_hash($data['password'], PASSWORD_DEFAULT); unset($data['password_confirmation']); $data['role']=User::count()===0?'admin':'user'; $data['status']='active'; $user=User::create($data); Audit::record('user.register','user',(string)$user->id); auth()->login($user); $request->session()->regenerate(); return redirect()->route('account')->with('status','注册成功。'); }
    public function account() { return view('auth.account'); }
    public function updateProfile(Request $request) { $data=$request->validate(['email'=>'required|email|max:255|unique:users,email,'.auth()->id()]); auth()->user()->update(['email'=>$data['email']]); Audit::record('user.profile.update','user',(string)auth()->id()); return back()->with('status','资料已更新。'); }
    public function updatePassword(Request $request) { $data=$request->validate(['current_password'=>'required|string','password'=>'required|string|min:10|confirmed']); $user=auth()->user(); if(!$user->verifyPassword($data['current_password'])) return back()->withErrors(['current_password'=>'当前密码不正确。']); $user->forceFill(['password'=>password_hash($data['password'],PASSWORD_DEFAULT),'password_hash'=>null,'password_salt'=>null])->save(); Audit::record('user.password.update','user',(string)$user->id); $request->session()->regenerate(); return back()->with('status','密码已更新，请重新登录其他设备。'); }
    public function logout(Request $request) { $id=auth()->id(); if($id) Audit::record('user.logout','user',(string)$id); auth()->logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('home'); }
}
