<?php


namespace Immeyti\VWallet\Projectors;


use Immeyti\VWallet\Events\Deposited;
use Immeyti\VWallet\Events\WalletCreated;
use Immeyti\VWallet\Models\Wallet;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

final class WalletProjector extends Projector
{
    public function onWalletCreated(WalletCreated $event, string $aggregateUuid)
    {
       return Wallet::createWithAttr([
            'user_id' => $event->userId,
            'coin' => $event->coin,
            'uuid' => $aggregateUuid
        ]);

    }

    /**
     * @param Deposited $event
     * @param string $aggregateUuid
     */
    public function onDeposited(Deposited $event, string $aggregateUuid)
    {
        $wallet = Wallet::uuid($aggregateUuid);

        $wallet->balance += $event->amount;

        $wallet->save();
    }
}
