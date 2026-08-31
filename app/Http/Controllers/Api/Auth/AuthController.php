<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use App\Services\AvatarService;
use App\Services\OtpService;
use App\Support\Phone;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(private OtpService $otp, private AvatarService $avatars) {}

    public function sendOtp(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'min:7', 'max:20'],
            'country_code' => ['nullable', 'string', 'max:8'],
        ]);

        $phone = Phone::normalize($data['phone'], $data['country_code'] ?? null);
        $otp = $this->otp->send($phone);

        $payload = [
            'phone' => $phone,
            'expires_in' => OtpService::EXPIRE_MINUTES * 60,
            'resend_in' => OtpService::RESEND_SECONDS,
        ];

        if (app()->environment(['local', 'development', 'testing'])) {
            $payload['otp'] = $otp->code;
        }

        return $this->success($payload, 'Verification code sent.');
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string'],
            'country_code' => ['nullable', 'string', 'max:8'],
            'otp' => ['required', 'digits:6'],
            'device_name' => ['nullable', 'string', 'max:80'],
        ]);

        $phone = Phone::normalize($data['phone'], $data['country_code'] ?? null);
        $this->otp->verify($phone, $data['otp']);

        $isNew = false;
        $user = User::where('phone', $phone)->first();

        if (! $user) {
            $isNew = true;
            $user = User::create([
                'phone' => $phone,
                'country_code' => $data['country_code'] ?? null,
                'phone_verified_at' => now(),
                'profile_completed' => false,
                'status' => 'active',
            ]);

            Contact::where('phone', $phone)
                ->whereNull('linked_user_id')
                ->update(['linked_user_id' => $user->id]);
        } else {
            $user->update(['phone_verified_at' => now(), 'last_login_at' => now()]);
        }

        $token = $user->createToken($data['device_name'] ?? 'flutter')->plainTextToken;

        return $this->success([
            'user' => $user->fresh()->toApiArray(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'is_new_user' => $isNew || ! $user->profile_completed,
        ], 'Phone verified successfully.');
    }

    public function completeProfile(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();
        $name = trim($data['first_name'].' '.($data['last_name'] ?? ''));

        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'name' => $name,
            'gender' => $data['gender'],
            'profile_completed' => true,
        ]);

        if ($request->hasFile('avatar')) {
            $this->avatars->store($user, $request->file('avatar'));
        }

        return $this->success($user->fresh()->toApiArray(), 'Profile saved.');
    }

    public function me(Request $request)
    {
        return $this->success($request->user()->toApiArray());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return $this->success(null, 'Logged out successfully.');
    }
}
