<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use App\Services\AvatarService;
use App\Services\OtpService;
use App\Support\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        private OtpService $otp,
        private AvatarService $avatars,
    ) {}

    public function welcome()
    {
        if (Auth::check() && ! Auth::user()->is_admin) {
            return redirect()->route('front.summary');
        }

        return view('front.welcome');
    }

    public function showPhone()
    {
        return view('front.auth.phone');
    }

    public function sendOtp(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'min:7', 'max:20'],
            'country_code' => ['nullable', 'string', 'max:8'],
        ]);

        $phone = Phone::normalize($data['phone'], $data['country_code'] ?? '+1');
        $otp = $this->otp->send($phone);

        $request->session()->put('otp_phone', $phone);
        $request->session()->put('otp_country', $data['country_code'] ?? '+1');

        return redirect()->route('front.otp')->with('otp_hint', app()->environment(['local', 'development']) ? $otp->code : null);
    }

    public function showOtp(Request $request)
    {
        $phone = $request->session()->get('otp_phone');
        if (! $phone) {
            return redirect()->route('front.phone');
        }

        return view('front.auth.otp', ['phone' => $phone]);
    }

    public function verifyOtp(Request $request)
    {
        $phone = $request->session()->get('otp_phone');
        if (! $phone) {
            return redirect()->route('front.phone');
        }

        $data = $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        try {
            $this->otp->verify($phone, $data['otp']);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        $user = User::where('phone', $phone)->first();
        $isNew = false;

        if (! $user) {
            $isNew = true;
            $user = User::create([
                'phone' => $phone,
                'country_code' => $request->session()->get('otp_country'),
                'phone_verified_at' => now(),
                'profile_completed' => false,
                'status' => 'active',
            ]);

            Contact::where('phone', $phone)->whereNull('linked_user_id')->update(['linked_user_id' => $user->id]);
        } else {
            $user->update(['phone_verified_at' => now(), 'last_login_at' => now()]);
        }

        Auth::login($user);
        $request->session()->forget(['otp_phone', 'otp_country']);
        $request->session()->regenerate();

        if ($isNew || ! $user->profile_completed) {
            return redirect()->route('front.onboarding');
        }

        return redirect()->route('front.summary');
    }

    public function showOnboarding()
    {
        return view('front.auth.onboarding');
    }

    public function completeOnboarding(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();
        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'name' => trim($data['first_name'].' '.($data['last_name'] ?? '')),
            'gender' => $data['gender'],
            'profile_completed' => true,
        ]);

        if ($request->hasFile('avatar')) {
            $this->avatars->store($user, $request->file('avatar'));
        }

        return redirect()->route('front.summary');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('front.welcome');
    }
}
