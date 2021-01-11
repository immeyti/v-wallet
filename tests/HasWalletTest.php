<?php

namespace Immeyti\VWallet\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Immeyti\VWallet\Tests\Models\User;

class HasWalletTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function it_should_create_a_wallet_for_user()
    {
        $user = User::factory()->create();

        $user->createWallet('USD');

        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'coin' => 'USD',
            'balance' => 0,
            'active' => true,
        ]);
    }

    /** @test */
    public function it_should_deposit_in_user_wallet()
    {
        $user = User::factory()->create();

        $user->createWallet('USD');

        $user->deposit('USD', 10);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'coin' => 'USD',
            'balance' => 10,
            'active' => true,
        ]);
    }

    /** @test */
    public function it_should_withdraw_of_user_wallet()
    {
        $user = User::factory()->create();

        $coin = 'USD';
        $user->createWallet($coin)->deposit(10);
        $user->withdraw($coin, 5);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'coin' => 'USD',
            'balance' => 5,
            'active' => true,
        ]);
    }

    /** @test */
    public function it_should_return_balance_of_the_wallet()
    {
        $user = User::factory()->create();

        $coin = 'USD';
        $user->createWallet($coin)->deposit(10);

        $this->assertEquals($user->balance($coin), 10);
    }
}
