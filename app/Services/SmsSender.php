<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsSender
{
    public function sendOtp(string $phone, string $code): void
    {
        Log::info('Fendo OTP', ['phone' => $phone, 'code' => $code]);

        $message = "Your Fendo verification code is {$code}";

        if (app()->environment(['local', 'development', 'testing'])) {
            $this->sendToAndroidEmulator($message);
        }

        $this->sendViaHttpGateway($phone, $message);
    }

    private function sendToAndroidEmulator(string $message): void
    {
        $adb = $this->adbPath();
        if ($adb === null) {
            return;
        }

        $from = '1600';
        $cmd = '"'.$adb.'" emu sms send '.$from.' '.escapeshellarg($message);
        exec($cmd.' 2>&1', $output, $status);

        if ($status !== 0) {
            $cmd = '"'.$adb.'" -s emulator-5554 emu sms send '.$from.' '.escapeshellarg($message);
            exec($cmd.' 2>&1', $output, $status);
        }

        Log::debug('Emulator SMS', ['status' => $status, 'output' => $output]);
    }

    private function adbPath(): ?string
    {
        $configured = env('ANDROID_ADB');
        $candidates = array_filter([
            $configured,
            (getenv('LOCALAPPDATA') ?: 'C:\\Users\\User\\AppData\\Local').'\\Android\\Sdk\\platform-tools\\adb.exe',
            'C:\\Users\\User\\AppData\\Local\\Android\\Sdk\\platform-tools\\adb.exe',
        ]);

        foreach ($candidates as $path) {
            if (is_string($path) && is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    private function sendViaHttpGateway(string $phone, string $message): void
    {
        $url = config('services.sms.url');
        $token = config('services.sms.token');
        if (! is_string($url) || $url === '') {
            return;
        }

        try {
            Http::timeout(8)->asForm()->post($url, [
                'to' => $phone,
                'message' => $message,
                'token' => $token,
            ]);
        } catch (\Throwable $e) {
            Log::warning('SMS gateway failed: '.$e->getMessage());
        }
    }
}
