<?php

namespace App\Support;

class Phone
{
    public static function normalize(?string $phone, ?string $countryCode = null): ?string
    {
        if ($phone === null || trim($phone) === '') {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        if ($digits === '') {
            return null;
        }

        if (str_starts_with(trim($phone), '+')) {
            return '+'.$digits;
        }

        $code = $countryCode ? preg_replace('/\D+/', '', $countryCode) : '';
        if ($code !== '') {
            $local = $digits;
            if (str_starts_with($local, '0')) {
                $local = substr($local, 1);
            }
            if ($code !== '' && ! str_starts_with($local, $code)) {
                $digits = $code.$local;
            } else {
                $digits = $local;
            }
        }

        return '+'.$digits;
    }
}
