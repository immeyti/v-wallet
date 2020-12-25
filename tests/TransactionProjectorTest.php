<?php


namespace Immeyti\VWallet\Tests;


use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Immeyti\VWallet\Models\Transaction;
use Immeyti\VWallet\Wallet;

class TransactionProjectorTest extends TestCase
{
    use RefreshDatabase, InteractsWithExceptionHandling;

    /** @test */
    public function it_should_store_deposit_and_withdraw_transaction()
    {
        $this->withoutExceptionHandling();

        $userId = 1;
        $coin = 'BTC';

        $wallet = Wallet::create($userId, $coin);
        Wallet::deposit($wallet, 10, []);
        Wallet::withdraw($wallet, 2, []);
        Wallet::withdraw($wallet, 2, []);
        Wallet::deposit($wallet, 2, []);

        $this->assertCount(4, Transaction::all());
    }
}
