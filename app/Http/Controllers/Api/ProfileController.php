<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AvatarService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    use ApiResponse;

    public function __construct(private AvatarService $avatars) {}

    public function show(Request $request)
    {
        return $this->success($request->user()->toApiArray());
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'first_name' => ['sometimes', 'required', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'gender' => ['sometimes', Rule::in(['male', 'female', 'other'])],
            'notifications_enabled' => ['sometimes', 'boolean'],
        ]);

        if (isset($data['first_name']) || array_key_exists('last_name', $data)) {
            $first = $data['first_name'] ?? $user->first_name;
            $last = array_key_exists('last_name', $data) ? $data['last_name'] : $user->last_name;
            $data['name'] = trim($first.' '.$last);
        }

        $user->update($data);

        return $this->success($user->fresh()->toApiArray(), 'Profile updated.');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $this->avatars->store($request->user(), $request->file('avatar'));

        return $this->success($request->user()->fresh()->toApiArray(), 'Avatar uploaded.');
    }

    public function deleteAvatar(Request $request)
    {
        $this->avatars->remove($request->user());

        return $this->success($request->user()->fresh()->toApiArray(), 'Avatar removed.');
    }

    public function updateFcmToken(Request $request)
    {
        $data = $request->validate([
            'fcm_token' => ['required', 'string', 'max:255'],
        ]);

        $request->user()->update([
            'fcm_token' => $data['fcm_token'],
            'notifications_enabled' => true,
        ]);

        return $this->success(null, 'Push notifications enabled.');
    }

    public function updateNotifications(Request $request)
    {
        $data = $request->validate([
            'notifications_enabled' => ['required', 'boolean'],
        ]);

        $request->user()->update($data);

        return $this->success([
            'notifications_enabled' => (bool) $request->user()->notifications_enabled,
        ], 'Notification settings updated.');
    }
}
