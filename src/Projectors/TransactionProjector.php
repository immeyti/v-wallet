<?php


namespace Immeyti\VWallet\Projectors;

use Immeyti\VWallet\Events\Deposited;
use Immeyti\VWallet\Events\Withdrew;
use Immeyti\VWallet\Models\Transaction;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class TransactionProjector extends Projector
{
    /**
     * @param Deposited $event
     * @param string $aggregateUuid
     */
    public function onDeposit(Deposited $event, $aggregateUuid)
    {
        Transaction::createWithAttr([
            'amount' => $event->amount,
            'meta' => $event->meta,
            'type' => Transaction::TYPE_DEPOSIT,
            'uuid' => $aggregateUuid,
        ]);
    }

    /**
     * @param Withdrew $event
     * @param string $aggregateUuid
     */
    public function onWithdrew(Withdrew $event, $aggregateUuid)
    {
        Transaction::createWithAttr([
            'amount' => $event->amount,
            'meta' => $event->meta,
            'type' => Transaction::TYPE_WITHDRAW,
            'uuid' => $aggregateUuid,
        ]);
    }

    public function onStartingEventReplay()
    {
        Transaction::truncate();
    }
}
