<?php


namespace Immeyti\VWallet\Tests;


use \Immeyti\VWallet\Wallet;
use Immeyti\VWallet\Exceptions\WalletExists;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Immeyti\VWallet\Exceptions\SufficientFundsToWithdrawAmountException;


class WalletTest extends TestCase
{
    use RefreshDatabase, InteractsWithExceptionHandling;

    /** @test */
    public function it_should_create_a_wallet()
    {
        $userId = 1;
        $coin = 'BTC';

        new Wallet($userId, $coin);

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

        new Wallet($userId, $coin);
        new Wallet($userId, $coin);
    }

    /** @test */
    public function it_should_deposit_an_amount_to_the_wallet()
    {
        $userId = 1;
        $coin = 'BTC';

        $wallet = new Wallet($userId, $coin);
        $wallet->deposit(10, []);

        $this->assertDatabaseHas('wallets', [
            'uuid' => $wallet->uuid,
            'balance' => 10,
            'blocked_balance' => 0
        ]);
    }

    /** @test */
    public function it_should_withdraw_an_amount_to_the_wallet()
    {
        $userId = 1;
        $coin = 'BTC';

        $wallet = new Wallet($userId, $coin);
        $wallet->deposit(10, []);
        $wallet->withdraw(5, []);

        $this->assertDatabaseHas('wallets', [
            'uuid' => $wallet->uuid,
            'balance' => 5,
            'blocked_balance' => 0
        ]);
    }

    /** @test */
    public function it_should_return_an_exception_when_withdrawing_an_account_that_inventory_shortage()
    {
        $this->expectException(SufficientFundsToWithdrawAmountException::class);

        $userId = 1;
        $coin = 'BTC';

        $wallet = new Wallet($userId, $coin);
        $wallet->deposit(10, []);
        $wallet->withdraw(20, []);
    }

    /** @test */
    public function it_should_return_all_wallets_of_an_user_id()
    {
        $userId = 1;
        $firstCoin = 'BTC';
        $secondCoin = 'USD';

        new Wallet($userId, $firstCoin);
        new Wallet($userId, $secondCoin);

        $wallets = Wallet::getWallets(['user_id' => $userId]);

        $this->assertCount(2, $wallets);
    }

    /** @test */
    public function it_should_return_an_wallet_object() 
    {
        $wallet = new Wallet(1, 'string');

        $this->assertInstanceOf(Wallet::class, $wallet);
    }
}
