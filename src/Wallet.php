<?php

namespace Immeyti\VWallet;

use Illuminate\Support\Str;
use Immeyti\VWallet\Aggregates\WalletAggregate;
use Immeyti\VWallet\Models\Wallet as WalletModel;

class Wallet
{
    /**
     * @param int $userId
     * @param string $coin
     * @return WalletModel|null
     * @throws Exceptions\WalletExists
     */
    public static function create(int $userId, string $coin): ?WalletModel
    {
        $newUuid = Str::uuid()->toString();
        WalletAggregate::retrieve($newUuid)
            ->createWallet($userId, $coin)
            ->persist();

        return self::getWallet($newUuid);
    }

    /**
     * @param WalletModel $wallet
     * @param float $amount
     * @param array $meta
     * @return WalletModel|null
     */
    public static function deposit(WalletModel $wallet, float $amount, array $meta = []): WalletModel
    {
        WalletAggregate::retrieve($wallet->uuid)
            ->deposit($wallet, $amount, $meta)
            ->persist();

        return self::getWallet($wallet->uuid);
    }

    public static function getWallet($uuid)
    {
        return WalletModel::uuid($uuid);
    }

    /**
     * @param WalletModel $wallet
     * @param int $amount
     * @param array $meta
     * @return WalletModel|null
     * @throws Exceptions\SufficientFundsToWithdrawAmountException
     */
    public static function withdraw(WalletModel $wallet, int $amount, array $meta = []): WalletModel
    {
        WalletAggregate::retrieve($wallet->uuid)
            ->withdraw($wallet, $amount, $meta)
            ->persist();

        return self::getWallet($wallet->uuid);
    }

    public static function getWallets(array $attr)
    {
        return WalletModel::getWithAttr($attr);
    }
}
