<?php


namespace Immeyti\VWallet\Tests;


use Immeyti\VWallet\Wallet;
use Immeyti\VWallet\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class TransactionProjectorTest extends TestCase
{
    use RefreshDatabase, InteractsWithExceptionHandling;

    /** @test */
    public function it_should_store_deposit_and_withdraw_transaction()
    {
        $this->withoutExceptionHandling();

        $userId = 1;
        $coin = 'BTC';

        $wallet = app('wallet', [$userId, $coin]);
        $wallet->deposit(10, [])
            ->withdraw(2, [])
            ->withdraw(2, [])
            ->deposit(2, []);

        $this->assertCount(4, Transaction::all());
    }
}
