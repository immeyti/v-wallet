<?php

namespace Immeyti\VWallet\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;


class WalletCreated extends ShouldBeStored
{
    public $userId;
    public $coin;

    /**
     * Create a new event instance.
     *
     * @param int $userId
     * @param string $coin
     */
    public function __construct(int $userId, string $coin)
    {
        $this->userId = $userId;
        $this->coin = $coin;
    }
}
