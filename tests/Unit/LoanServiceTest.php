<?php

namespace Tests\Unit;

use App\Models\Contact;
use App\Models\User;
use App\Services\LoanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_lend_borrow_pay_and_close_net_correctly(): void
    {
        $user = User::factory()->create(['phone' => '+8801711111111']);
        $contact = Contact::create([
            'user_id' => $user->id,
            'name' => 'Erlich',
            'phone' => '+15551230001',
            'balance' => 0,
        ]);

        $loans = app(LoanService::class);

        $loans->lend($user, $contact, 300);
        $this->assertEquals(300.0, (float) $contact->fresh()->balance);

        $loans->borrow($user, $contact, 40);
        $this->assertEquals(260.0, (float) $contact->fresh()->balance);

        $loans->payDebt($user, $contact, 60);
        $this->assertEquals(200.0, (float) $contact->fresh()->balance);

        $loans->closeDebt($user, $contact);
        $this->assertEquals(0.0, (float) $contact->fresh()->balance);

        $loans->borrow($user, $contact, 75);
        $this->assertEquals(-75.0, (float) $contact->fresh()->balance);

        $loans->payDebt($user, $contact, 25);
        $this->assertEquals(-50.0, (float) $contact->fresh()->balance);

        $iOwe = (float) $contact->fresh()->balance < 0 ? abs((float) $contact->fresh()->balance) : 0;
        $oweMe = (float) $contact->fresh()->balance > 0 ? (float) $contact->fresh()->balance : 0;
        $this->assertEquals(50.0, $iOwe);
        $this->assertEquals(0.0, $oweMe);
    }
}
