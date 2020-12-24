<?php

namespace Immeyti\VWallet;

use Illuminate\Support\Str;
use Immeyti\VWallet\Aggregates\WalletAggregate;

class Wallet
{
    public static function create($userId, $coin)
    {
        $newUuid = Str::uuid()->toString();

        WalletAggregate::retrieve($newUuid)
            ->createWallet($userId, $coin)
            ->persist();

        //return Wallet::first($uuid);
    }
}
