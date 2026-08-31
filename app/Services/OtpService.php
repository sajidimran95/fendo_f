<?php

namespace App\Services;

use App\Models\Otp;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class OtpService
{
    public const EXPIRE_MINUTES = 10;
    public const RESEND_SECONDS = 60;
    public const MAX_ATTEMPTS = 5;

    public function send(string $phone, string $purpose = 'login'): Otp
    {
        $latest = Otp::query()
            ->where('phone', $phone)
            ->where('purpose', $purpose)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if ($latest && $latest->updated_at && $latest->updated_at->diffInSeconds(now()) < 8) {
            $wait = 8 - (int) $latest->updated_at->diffInSeconds(now());
            throw ValidationException::withMessages([
                'phone' => ["Please wait {$wait} seconds before requesting another code."],
            ]);
        }

        $code = (string) random_int(100000, 999999);
        $expires = Carbon::now()->addMinutes(self::EXPIRE_MINUTES);

        if ($latest) {
            $latest->update([
                'code' => $code,
                'expires_at' => $expires,
                'attempts' => 0,
            ]);

            $otp = $latest->fresh();
        } else {
            $otp = Otp::create([
                'phone' => $phone,
                'code' => $code,
                'purpose' => $purpose,
                'expires_at' => $expires,
            ]);
        }

        app(SmsSender::class)->sendOtp($phone, $code);

        return $otp;
    }

    public function verify(string $phone, string $code, string $purpose = 'login'): Otp
    {
        $otp = Otp::query()
            ->where('phone', $phone)
            ->where('purpose', $purpose)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (! $otp) {
            throw ValidationException::withMessages([
                'otp' => ['No verification code found. Please request a new one.'],
            ]);
        }

        if ($otp->isExpired()) {
            throw ValidationException::withMessages([
                'otp' => ['This code has expired. Please request a new one.'],
            ]);
        }

        if ($otp->attempts >= self::MAX_ATTEMPTS) {
            throw ValidationException::withMessages([
                'otp' => ['Too many attempts. Please request a new code.'],
            ]);
        }

        if ($otp->code !== $code) {
            $otp->increment('attempts');
            throw ValidationException::withMessages([
                'otp' => ['Invalid code. Please try again.'],
            ]);
        }

        $otp->update(['verified_at' => now()]);

        return $otp;
    }
}
