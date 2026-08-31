<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AvatarService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function __construct(private AvatarService $avatars) {}

    public function show()
    {
        return view('admin.profile.show', [
            'admin' => auth()->user(),
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $this->avatars->store($request->user(), $request->file('avatar'));

        return back()->with('success', 'Profile photo updated.');
    }

    public function deleteAvatar(Request $request)
    {
        $this->avatars->remove($request->user());

        return back()->with('success', 'Profile photo removed.');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $request->user()->update([
            'password' => $data['password'],
        ]);

        return back()->with('success', 'Password updated.');
    }
}
