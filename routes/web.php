<?php

use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('home');
Route::get('media/{path}', [MediaController::class, 'show'])->where('path', '.*')->name('media');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::post('users/{user}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
        Route::post('users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::get('audit-log', [AuditLogController::class, 'index'])->name('audit');
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions');
        Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback');
        Route::get('profile', [ProfileController::class, 'show'])->name('profile');
        Route::post('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
        Route::post('profile/avatar/delete', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
        Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });
});
