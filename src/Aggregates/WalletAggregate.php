<?php


namespace Immeyti\VWallet\Aggregates;


use Immeyti\VWallet\Events\Deposited;
use Immeyti\VWallet\Events\WalletCreated;
use Immeyti\VWallet\Exceptions\WalletExists;
use Immeyti\VWallet\Models\Wallet;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

final class WalletAggregate extends AggregateRoot
{
    public $wallet;
    private $balance = 0;
    private $blocked_balance;
    private $Limit = 0;
    private $walletIsBlocked = false;

    /**
     * @param integer $userId
     * @param string $coin
     * @return $this
     * @throws WalletExists
     */
    public function createWallet($userId, $coin)
    {
        if ($this->walletExists($userId, $coin))
            throw new WalletExists();

        $this->recordThat(new WalletCreated($userId, $coin));

        return $this;
    }

    public function deposit($wallet, $amount, $meta)
    {
        $this->recordThat(new Deposited($amount, $meta));

        return $this;
    }

    private function walletExists(int $userId, string $coin)
    {
        return Wallet::isExist($userId, $coin);
    }
}
