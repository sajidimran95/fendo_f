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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(private OtpService $otp, private AvatarService $avatars) {}

    public function sendOtp(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'min:7', 'max:20'],
            'country_code' => ['nullable', 'string', 'max:8'],
            'purpose' => ['required', Rule::in(['register', 'reset'])],
        ]);

        $phone = Phone::normalize($data['phone'], $data['country_code'] ?? null);
        $exists = User::where('phone', $phone)->exists();

        if ($data['purpose'] === 'register' && $exists) {
            return $this->error('This mobile number is already registered. Please sign in.', null, 422);
        }

        if ($data['purpose'] === 'reset' && ! $exists) {
            return $this->error('No account found with this mobile number.', null, 422);
        }

        $otp = $this->otp->send($phone, $data['purpose']);

        $payload = [
            'phone' => $phone,
            'expires_in' => OtpService::EXPIRE_MINUTES * 60,
            'resend_in' => 8,
        ];

        if (config('app.debug') || app()->environment(['local', 'development', 'testing'])) {
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

        return $this->issuePhoneSession($phone, $data['country_code'] ?? null, $data['device_name'] ?? 'flutter');
    }

    public function firebase(Request $request)
    {
        $data = $request->validate([
            'id_token' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'country_code' => ['nullable', 'string', 'max:8'],
            'device_name' => ['nullable', 'string', 'max:80'],
        ]);

        $key = config('services.firebase.web_api_key');
        if (! $key) {
            return $this->error('Firebase is not configured on the server.', null, 500);
        }

        $response = Http::asJson()->post(
            'https://identitytoolkit.googleapis.com/v1/accounts:lookup?key='.$key,
            ['idToken' => $data['id_token']]
        );

        if (! $response->successful()) {
            return $this->error('Could not verify the Firebase session.', null, 422);
        }

        $firebasePhone = $response->json('users.0.phoneNumber');
        if (! is_string($firebasePhone) || $firebasePhone === '') {
            return $this->error('Firebase did not return a verified phone number.', null, 422);
        }

        $verified = Phone::normalize($firebasePhone);
        $requested = Phone::normalize($data['phone'], $data['country_code'] ?? null);

        if ($verified !== $requested) {
            return $this->error('Phone number does not match the verified Firebase session.', null, 422);
        }

        return $this->issuePhoneSession($verified, $data['country_code'] ?? null, $data['device_name'] ?? 'flutter');
    }

    private function issuePhoneSession(string $phone, ?string $countryCode, string $deviceName)
    {
        $isNew = false;
        $user = User::where('phone', $phone)->first();

        if (! $user) {
            $isNew = true;
            $user = User::create([
                'phone' => $phone,
                'country_code' => $countryCode,
                'phone_verified_at' => now(),
                'profile_completed' => false,
                'status' => 'active',
            ]);

            Contact::where('phone', $phone)
                ->whereNull('linked_user_id')
                ->update(['linked_user_id' => $user->id]);
        } else {
            if ($user->isSuspended()) {
                return $this->error('This account is suspended.', null, 403);
            }
            $user->update(['phone_verified_at' => now(), 'last_login_at' => now()]);
        }

        $token = $user->createToken($deviceName)->plainTextToken;

        return $this->success([
            'user' => $user->fresh()->toApiArray(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'is_new_user' => $isNew || ! $user->profile_completed,
        ], 'Phone verified successfully.');
    }

    public function register(Request $request)
    {
        if ($request->input('email') === '') {
            $request->merge(['email' => null]);
        }
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'email' => ['nullable', 'email', 'max:120', 'unique:users,email'],
            'phone' => ['required', 'string', 'min:7', 'max:20'],
            'country_code' => ['nullable', 'string', 'max:8'],
            'password' => ['required', 'string', Password::min(6)],
            'id_token' => ['nullable', 'string'],
            'otp' => ['nullable', 'digits:6'],
            'device_name' => ['nullable', 'string', 'max:80'],
        ]);

        $phone = Phone::normalize($data['phone'], $data['country_code'] ?? null);
        $this->assertPhoneVerified($phone, $data['country_code'] ?? null, $data['id_token'] ?? null, $data['otp'] ?? null, 'register');

        if (User::where('phone', $phone)->exists()) {
            return $this->error('This mobile number is already registered.', null, 422);
        }

        $parts = preg_split('/\s+/', trim($data['name']), 2) ?: [];
        $first = $parts[0] ?? trim($data['name']);
        $last = $parts[1] ?? null;

        $user = User::create([
            'name' => trim($data['name']),
            'first_name' => $first,
            'last_name' => $last,
            'email' => $data['email'] ?: null,
            'phone' => $phone,
            'country_code' => $data['country_code'] ?? null,
            'password' => $data['password'],
            'phone_verified_at' => now(),
            'profile_completed' => true,
            'status' => 'active',
        ]);

        Contact::where('phone', $phone)
            ->whereNull('linked_user_id')
            ->update(['linked_user_id' => $user->id]);

        $this->prepareUserContacts($user);
        $token = $user->createToken($data['device_name'] ?? 'flutter')->plainTextToken;

        return $this->created([
            'user' => $user->fresh()->toApiArray(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'is_new_user' => true,
            'needs_contact_permission' => true,
        ], 'Account created.');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string'],
            'country_code' => ['nullable', 'string', 'max:8'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:80'],
        ]);

        $phone = Phone::normalize($data['phone'], $data['country_code'] ?? null);
        $digits = preg_replace('/\D+/', '', (string) $data['phone']) ?? '';

        $user = User::query()
            ->where('phone', $phone)
            ->when(strlen($digits) >= 10, fn ($q) => $q->orWhere('phone', '+'.$digits))
            ->first();

        if (! $user || ! $user->password || ! Hash::check($data['password'], $user->password)) {
            return $this->error('Mobile number or password is incorrect.', null, 422);
        }

        if ($user->isSuspended()) {
            return $this->error('This account is suspended.', null, 403);
        }

        $user->update(['last_login_at' => now()]);
        $this->prepareUserContacts($user);
        $token = $user->createToken($data['device_name'] ?? 'flutter')->plainTextToken;

        return $this->success([
            'user' => $user->fresh()->toApiArray(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'is_new_user' => ! $user->profile_completed,
            'needs_contact_permission' => ! $user->isDemo() && $user->contacts()->count() === 0,
        ], 'Logged in successfully.');
    }

    public function demo(Request $request)
    {
        if (! config('app.demo_enabled')) {
            return $this->error('Demo login is disabled.', null, 404);
        }
        if (! User::where('phone', '+8801712345678')->exists()) {
            (new \Database\Seeders\DemoUserSeeder)->run();
        }

        $user = User::where('phone', '+8801712345678')->first();
        if (! $user) {
            return $this->error('Demo account is not available.', null, 500);
        }

        $user->update([
            'password' => '12345678',
            'status' => 'active',
            'profile_completed' => true,
            'last_login_at' => now(),
        ]);

        $token = $user->createToken($request->input('device_name') ?: 'flutter')->plainTextToken;

        return $this->success([
            'user' => $user->fresh()->toApiArray(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'is_new_user' => false,
            'needs_contact_permission' => false,
        ], 'Logged in successfully.');
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string'],
            'country_code' => ['nullable', 'string', 'max:8'],
            'password' => ['required', 'string', Password::min(6)],
            'id_token' => ['nullable', 'string'],
            'otp' => ['nullable', 'digits:6'],
        ]);

        $phone = Phone::normalize($data['phone'], $data['country_code'] ?? null);
        $this->assertPhoneVerified($phone, $data['country_code'] ?? null, $data['id_token'] ?? null, $data['otp'] ?? null, 'reset');

        $user = User::where('phone', $phone)->first();
        if (! $user) {
            return $this->error('No account found with this mobile number.', null, 422);
        }

        if ($user->isSuspended()) {
            return $this->error('This account is suspended.', null, 403);
        }

        $user->update([
            'password' => $data['password'],
            'phone_verified_at' => now(),
        ]);

        return $this->success(null, 'Password updated. You can sign in now.');
    }

    private function assertPhoneVerified(string $phone, ?string $countryCode, ?string $idToken, ?string $otp, string $purpose): void
    {
        $hasToken = is_string($idToken) && $idToken !== '';
        $hasOtp = is_string($otp) && $otp !== '';

        if (! $hasToken && ! $hasOtp) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'otp' => ['Enter the verification code sent to your phone.'],
            ]);
        }

        if ($hasToken) {
            try {
                $this->assertFirebasePhone($idToken, $phone, $countryCode);

                return;
            } catch (\Throwable $e) {
                if (! $hasOtp) {
                    throw $e;
                }
            }
        }

        $this->otp->verify($phone, $otp, $purpose);
    }

    private function assertFirebasePhone(string $idToken, ?string $requestedPhone, ?string $countryCode): string
    {
        $key = config('services.firebase.web_api_key');
        if (! $key) {
            abort(response()->json([
                'success' => false,
                'message' => 'Firebase is not configured on the server.',
            ], 500));
        }

        $response = Http::asJson()->post(
            'https://identitytoolkit.googleapis.com/v1/accounts:lookup?key='.$key,
            ['idToken' => $idToken]
        );

        if (! $response->successful()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'id_token' => ['Could not verify the SMS session. Request a new code.'],
            ]);
        }

        $firebasePhone = $response->json('users.0.phoneNumber');
        if (! is_string($firebasePhone) || $firebasePhone === '') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'id_token' => ['Firebase did not return a verified phone number.'],
            ]);
        }

        $verified = Phone::normalize($firebasePhone);
        $requested = Phone::normalize($requestedPhone, $countryCode);

        if ($verified !== $requested) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'phone' => ['Phone number does not match the verified SMS session.'],
            ]);
        }

        return $verified;
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
        $user = $request->user();
        $this->prepareUserContacts($user);

        return $this->success($user->fresh()->toApiArray());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return $this->success(null, 'Logged out successfully.');
    }

    private function prepareUserContacts(User $user): void
    {
        if ($user->isDemo()) {
            return;
        }

        $demoPhones = ['+15551230001', '+15551230002', '+15551230003'];
        $ids = $user->contacts()->whereIn('phone', $demoPhones)->pluck('id');
        if ($ids->isEmpty()) {
            return;
        }
        \App\Models\Transaction::whereIn('contact_id', $ids)->delete();
        $user->contacts()->whereIn('id', $ids)->delete();
    }
}
