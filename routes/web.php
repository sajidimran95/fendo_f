<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front;
use Illuminate\Support\Facades\Route;

Route::get('/', [Front\AuthController::class, 'welcome'])->name('front.welcome');

Route::middleware('guest')->group(function () {
    Route::get('phone', [Front\AuthController::class, 'showPhone'])->name('front.phone');
    Route::post('phone', [Front\AuthController::class, 'sendOtp'])->name('front.phone.send');
    Route::get('verify', [Front\AuthController::class, 'showOtp'])->name('front.otp');
    Route::post('verify', [Front\AuthController::class, 'verifyOtp'])->name('front.otp.verify');
});

Route::middleware('customer')->group(function () {
    Route::get('onboarding', [Front\AuthController::class, 'showOnboarding'])->name('front.onboarding');
    Route::post('onboarding', [Front\AuthController::class, 'completeOnboarding'])->name('front.onboarding.save');
    Route::post('logout', [Front\AuthController::class, 'logout'])->name('front.logout');

    Route::get('summary', [Front\AppController::class, 'summary'])->name('front.summary');
    Route::get('history', [Front\AppController::class, 'history'])->name('front.history');
    Route::get('settings', [Front\AppController::class, 'settings'])->name('front.settings');
    Route::post('settings/profile', [Front\AppController::class, 'updateProfile'])->name('front.settings.profile');
    Route::post('settings/feedback', [Front\AppController::class, 'feedback'])->name('front.settings.feedback');

    Route::get('loans/create', [Front\LoanController::class, 'create'])->name('front.loans.create');
    Route::post('contacts', [Front\LoanController::class, 'storeContact'])->name('front.contacts.store');
    Route::get('contacts/{contact}', [Front\LoanController::class, 'show'])->name('front.contacts.show');
    Route::get('contacts/{contact}/{type}', [Front\LoanController::class, 'form'])->name('front.loans.form');
    Route::post('contacts/{contact}/loans', [Front\LoanController::class, 'store'])->name('front.loans.store');
    Route::post('contacts/{contact}/close', [Front\LoanController::class, 'close'])->name('front.loans.close');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::post('users/{user}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
        Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions');
        Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback');
        Route::get('profile', [ProfileController::class, 'show'])->name('profile');
        Route::post('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
        Route::post('profile/avatar/delete', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
        Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });
});
