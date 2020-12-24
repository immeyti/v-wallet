<?php


namespace Immeyti\VWallet\Tests;


use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\EventSourcing\EventSerializers\EventSerializer;
use Spatie\EventSourcing\EventSerializers\JsonEventSerializer;
use Spatie\EventSourcing\Projectionist;

class Wallet extends TestCase
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
}
