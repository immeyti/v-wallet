<?php

namespace Immeyti\VWallet;

use Illuminate\Support\Str;
use Immeyti\VWallet\Aggregates\WalletAggregate;
use Immeyti\VWallet\Exceptions\WalletExists;
use Immeyti\VWallet\Models\Wallet as WalletModel;

class Wallet
{
    public $walletModel = null;
    public string $uuid;

    public function __construct(int $userId = null, string $coin = null)
    {
        if (is_null($userId) or is_null($coin)) {
            return $this;
        }

        try {
            return $this->create($userId, $coin);
        } catch (WalletExists $e) {
            $this->uuid = self::firstWallet([
                'user_id' => $userId,
                'coin' => $coin,
            ])->uuid;

            return $this;
        }
    }

    /**
     * @param int $userId
     * @param string $coin
     * @return $this|null
     * @throws Exceptions\WalletExists
     */
    public function create(int $userId, string $coin): ?self
    {
        $newUuid = Str::uuid()->toString();
        WalletAggregate::retrieve($newUuid)
            ->createWallet($userId, $coin)
            ->persist();

        $this->uuid = $newUuid;

        return $this;
    }

    /**
     * @param float $amount
     * @param array $meta
     * @return WalletModel|null
     */
    public function deposit(float $amount, array $meta = []): self
    {
        WalletAggregate::retrieve($this->uuid)
            ->deposit($this, $amount, $meta)
            ->persist();

        return $this;
    }

    public static function getWallet($uuid)
    {
        return WalletModel::uuid($uuid);
    }

    /**
     * @param int $amount
     * @param array $meta
     * @return WalletModel|null
     * @throws Exceptions\SufficientFundsToWithdrawAmountException
     */
    public function withdraw(int $amount, array $meta = []): self
    {
        WalletAggregate::retrieve($this->uuid)
            ->withdraw($this, $amount, $meta)
            ->persist();

        return $this;
    }

    public function balance()
    {
        return self::firstWallet(['uuid' => $this->uuid])->refresh()->balance;
    }

    public static function getWallets(array $attr)
    {
        return WalletModel::getWithAttr($attr);
    }

    public static function firstWallet(array $attr)
    {
        return WalletModel::firstWithAttr($attr);
    }
}
