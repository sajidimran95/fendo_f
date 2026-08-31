<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvatarService
{
    public function store(User $user, UploadedFile $file): string
    {
        $this->deleteFile($user);

        $path = $file->store('avatars/'.$user->id, 'public');
        $user->update(['avatar' => $path]);

        return $path;
    }

    public function remove(User $user): void
    {
        $this->deleteFile($user);
        $user->update(['avatar' => null]);
    }

    private function deleteFile(User $user): void
    {
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
    }
}
