<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use App\Services\LoanService;
use Illuminate\Database\Seeder;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['phone' => '+8801712345678'],
            [
                'name' => 'Demo User',
                'first_name' => 'Demo',
                'last_name' => 'User',
                'email' => 'demo@fendo.test',
                'country_code' => '+880',
                'password' => '12345678',
                'gender' => 'male',
                'is_admin' => false,
                'profile_completed' => true,
                'status' => 'active',
                'phone_verified_at' => now(),
            ]
        );

        $erlichUser = User::updateOrCreate(
            ['phone' => '+15551230001'],
            [
                'name' => 'Erlich',
                'first_name' => 'Erlich',
                'password' => '12345678',
                'profile_completed' => true,
                'status' => 'active',
                'phone_verified_at' => now(),
            ]
        );

        $erlich = Contact::updateOrCreate(
            ['user_id' => $user->id, 'name' => 'Erlich'],
            ['phone' => '+15551230001', 'linked_user_id' => $erlichUser->id, 'balance' => 0]
        );
        $sister = Contact::updateOrCreate(
            ['user_id' => $user->id, 'name' => 'Sister'],
            ['phone' => '+15551230002', 'linked_user_id' => null, 'balance' => 0]
        );
        Contact::updateOrCreate(
            ['user_id' => $user->id, 'name' => 'Manny'],
            ['phone' => '+15551230003', 'linked_user_id' => null, 'balance' => 0]
        );

        if ((float) $erlich->balance === 0.0 && (float) $sister->balance === 0.0
            && ! $user->transactions()->exists()) {
            $loans = app(LoanService::class);
            $loans->lend($user, $erlich, 300, 'fishing rod');
            $loans->borrow($user, $sister, 40, 'lunch');
        }
    }
}
