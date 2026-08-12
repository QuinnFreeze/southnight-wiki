<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\SettingsController;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/research', [SiteController::class, 'research'])->name('research');
Route::get('/leadership', [SiteController::class, 'leadership'])->name('leadership');
Route::get('/principles', [SiteController::class, 'principles'])->name('principles');
Route::get('/privacy', [SiteController::class, 'privacy'])->name('privacy');
Route::get('/transparency', [SiteController::class, 'transparency'])->name('transparency');
Route::get('/disclaimer', fn () => redirect('/transparency#disclaimer', 302))->name('disclaimer');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');
Route::get('/api/auth/me', [ApiController::class, 'me']);
Route::post('/api/auth/login', [ApiController::class, 'login'])->middleware(['throttle:6,1', 'turnstile:login']);
Route::post('/api/auth/register', [ApiController::class, 'register'])->middleware(['throttle:5,10', 'turnstile:register']);
Route::post('/api/auth/logout', [ApiController::class, 'logout']);
Route::get('/api/announcements', [ApiController::class, 'announcements']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware(['throttle:6,1', 'turnstile:login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware(['throttle:5,10', 'turnstile:register'])->name('register.submit');
Route::get('/account/recovery', [AuthController::class, 'showRecovery'])->name('account.recovery');
Route::post('/account/recovery/code', [AuthController::class, 'sendRecoveryCode'])->middleware(['throttle:3,10', 'turnstile:recovery-send'])->name('account.recovery.send');
Route::post('/account/recovery/verify', [AuthController::class, 'verifyRecoveryCode'])->middleware(['throttle:10,10', 'turnstile:recovery-verify'])->name('account.recovery.verify');
Route::post('/account/recovery/password', [AuthController::class, 'resetRecoveredPassword'])->middleware(['throttle:5,10', 'turnstile:recovery-reset'])->name('account.recovery.reset');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::middleware('auth')->group(function () {
    Route::get('/account', [AuthController::class, 'account'])->name('account');
    Route::put('/account/profile', [AuthController::class, 'updateProfile'])->middleware('turnstile:account-profile')->name('account.profile');
    Route::post('/account/email/send', [AuthController::class, 'sendEmailVerification'])->middleware(['throttle:3,10', 'turnstile:email-verification-send'])->name('account.email.send');
    Route::post('/account/email/verify', [AuthController::class, 'verifyEmail'])->middleware(['throttle:10,10', 'turnstile:email-verification-verify'])->name('account.email.verify');
    Route::put('/account/password', [AuthController::class, 'updatePassword'])->middleware('turnstile:account-password')->name('account.password');
    Route::put('/account/password/email', [AuthController::class, 'updatePasswordByEmail'])->middleware('turnstile:account-password-email')->name('account.password.email');
});
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->middleware('turnstile:admin-user')->name('users.update');

    Route::resource('announcements', AnnouncementController::class)->except(['show'])->middleware('turnstile:admin-announcement');
    Route::get('/content/{type}', [AdminContentController::class, 'index'])->name('content.index');
    Route::post('/content/{type}', [AdminContentController::class, 'store'])->middleware('turnstile:admin-content')->name('content.store');
    Route::put('/content/{type}/{id}', [AdminContentController::class, 'update'])->middleware('turnstile:admin-content')->name('content.update');
    Route::delete('/content/{type}/{id}', [AdminContentController::class, 'destroy'])->middleware('turnstile:admin-content')->name('content.destroy');
});
foreach (['about','research','leadership','principles','privacy','transparency'] as $legacy) {
    Route::get('/'.$legacy.'.html', fn () => redirect('/'.$legacy, 301));
}
Route::get('/index.html', fn () => redirect('/', 301));
