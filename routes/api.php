<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SummaryController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->middleware('throttle:auth')->group(function () {
        Route::post('send-otp', [AuthController::class, 'sendOtp']);
        Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/complete-profile', [AuthController::class, 'completeProfile']);
        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);

        Route::get('profile', [ProfileController::class, 'show']);
        Route::put('profile', [ProfileController::class, 'update']);
        Route::post('profile/avatar', [ProfileController::class, 'uploadAvatar']);
        Route::delete('profile/avatar', [ProfileController::class, 'deleteAvatar']);
        Route::put('profile/fcm-token', [ProfileController::class, 'updateFcmToken']);
        Route::put('profile/notifications', [ProfileController::class, 'updateNotifications']);

        Route::get('summary', [SummaryController::class, 'index']);
        Route::get('search', [SummaryController::class, 'search']);

        Route::get('contacts', [ContactController::class, 'index']);
        Route::post('contacts', [ContactController::class, 'store']);
        Route::post('contacts/sync', [ContactController::class, 'sync']);
        Route::get('contacts/{contact}', [ContactController::class, 'show']);

        Route::post('loans', [LoanController::class, 'store']);
        Route::post('contacts/{contact}/pay', [LoanController::class, 'pay']);
        Route::post('contacts/{contact}/close', [LoanController::class, 'close']);

        Route::get('history', [HistoryController::class, 'index']);

        Route::get('notifications', [NotificationController::class, 'index']);
        Route::get('notifications/unread-count', [NotificationController::class, 'unreadCount']);
        Route::put('notifications/{notification}/read', [NotificationController::class, 'markRead']);
        Route::post('notifications/read-all', [NotificationController::class, 'markAllRead']);

        Route::post('feedback', [FeedbackController::class, 'store']);
    });
});
