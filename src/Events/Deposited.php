<?php


namespace Immeyti\VWallet\Events;


use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class Deposited extends ShouldBeStored
{
    public $amount;
    public $meta;

    /**
     * Create a new event instance.
     * @param float $amount
     * @param array $meta
     */
    public function __construct(float $amount, array $meta)
    {
        $this->amount = $amount;
        $this->meta = $meta;
    }
}
