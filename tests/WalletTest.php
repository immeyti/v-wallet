<?php


namespace Immeyti\VWallet\Tests;


use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Immeyti\VWallet\Exceptions\WalletExists;
use \Immeyti\VWallet\Wallet;


class WalletTest extends TestCase
{
    use RefreshDatabase, InteractsWithExceptionHandling;

    /** @test */
    public function it_should_create_a_wallet()
    {
        //$this->withoutExceptionHandling();

        $userId = 1;
        $coin = 'BTC';

        \Immeyti\VWallet\Wallet::create($userId, $coin);

        $this->assertDatabaseHas('wallets', [
           'user_id' => $userId,
           'coin' => $coin,
           'balance' => 0,
           'blocked_balance' => 0,
           'active' => true
        ]);
    }

    /** @test */
    public function it_should_returns_an_exception_when_wallet_duplicated()
    {
        $this->expectException(WalletExists::class);
        $userId = 1;
        $coin = 'BTC';

        \Immeyti\VWallet\Wallet::create($userId, $coin);
        \Immeyti\VWallet\Wallet::create($userId, $coin);
    }

    /** @test */
    public function it_should_deposit_an_amount_to_the_wallet()
    {
        $userId = 1;
        $coin = 'BTC';

        $wallet = Wallet::create($userId, $coin);
        Wallet::deposit($wallet, 10, []);

        $this->assertDatabaseHas('wallets', [
            'uuid' => $wallet->uuid,
            'balance' => 10,
            'blocked_balance' => 0
        ]);
    }
}
