<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Fendo Admin',
                'first_name' => 'Fendo',
                'last_name' => 'Admin',
                'password' => '12345678',
                'is_admin' => true,
                'profile_completed' => true,
                'status' => 'active',
            ]
        );
    }
}
