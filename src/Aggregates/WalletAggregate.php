<?php


namespace Immeyti\VWallet\Aggregates;


use Immeyti\VWallet\Events\WalletCreated;
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
     */
    public function createWallet($userId, $coin)
    {
//        if ($this->accountExist($userId, $coin))
//            throw AccountException::accountIsExsit($userId, $coin);

        $this->recordThat(new WalletCreated($userId, $coin));

        return $this;
    }
}
