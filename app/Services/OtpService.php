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

        if ($latest && $latest->created_at->diffInSeconds(now()) < self::RESEND_SECONDS) {
            $wait = self::RESEND_SECONDS - (int) $latest->created_at->diffInSeconds(now());
            throw ValidationException::withMessages([
                'phone' => ["Please wait {$wait} seconds before requesting another code."],
            ]);
        }

        $otp = Otp::create([
            'phone' => $phone,
            'code' => (string) random_int(100000, 999999),
            'purpose' => $purpose,
            'expires_at' => Carbon::now()->addMinutes(self::EXPIRE_MINUTES),
        ]);

        // SMS gateway can be wired here later. In local/dev the code is returned in the API.

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
