<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * After a successful login, allow only admins.
     * Non-admins are immediately logged out.
     */
    protected function authenticated(Request $request, $user)
    {
        if ((int) $user->is_admin !== 1) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Access denied. This panel is for administrators only.',
            ])->onlyInput('email');
        }

        return redirect()->intended($this->redirectTo);
    }
}
