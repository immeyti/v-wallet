<?php

namespace Immeyti\VWallet;

use Illuminate\Support\Str;
use Immeyti\VWallet\Aggregates\WalletAggregate;
use Immeyti\VWallet\Models\Wallet as WalletModel;

class Wallet
{
    public $walletModel = null;
    private int $userId;
    private string $coin;


    public function __construct(int $userId, string $coin)
    {
        $this->userId = $userId;
        $this->coin = $coin;

        return $this->create($userId, $coin);
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

    public static function getWallets(array $attr)
    {
        return WalletModel::getWithAttr($attr);
    }
}
