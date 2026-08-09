<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\ApiController;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/research', [SiteController::class, 'research'])->name('research');
Route::get('/leadership', [SiteController::class, 'leadership'])->name('leadership');
Route::get('/principles', [SiteController::class, 'principles'])->name('principles');
Route::get('/privacy', [SiteController::class, 'privacy'])->name('privacy');
Route::get('/transparency', [SiteController::class, 'transparency'])->name('transparency');
Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');
Route::get('/api/auth/me', [ApiController::class, 'me']);
Route::post('/api/auth/login', [ApiController::class, 'login'])->middleware('throttle:6,1');
Route::post('/api/auth/register', [ApiController::class, 'register'])->middleware('throttle:5,10');
Route::post('/api/auth/logout', [ApiController::class, 'logout']);
Route::get('/api/announcements', [ApiController::class, 'announcements']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,10')->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::middleware('auth')->group(function () {
    Route::get('/account', [AuthController::class, 'account'])->name('account');
    Route::put('/account/profile', [AuthController::class, 'updateProfile'])->name('account.profile');
    Route::put('/account/password', [AuthController::class, 'updatePassword'])->name('account.password');
});
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');

    Route::resource('announcements', AnnouncementController::class)->except(['show']);
    Route::get('/content/{type}', [AdminContentController::class, 'index'])->name('content.index');
    Route::post('/content/{type}', [AdminContentController::class, 'store'])->name('content.store');
    Route::put('/content/{type}/{id}', [AdminContentController::class, 'update'])->name('content.update');
    Route::delete('/content/{type}/{id}', [AdminContentController::class, 'destroy'])->name('content.destroy');
});
foreach (['about','research','leadership','principles','privacy','transparency'] as $legacy) {
    Route::get('/'.$legacy.'.html', fn () => redirect('/'.$legacy, 301));
}
Route::get('/index.html', fn () => redirect('/', 301));
