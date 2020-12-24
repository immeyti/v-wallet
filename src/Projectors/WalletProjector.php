<?php


namespace Immeyti\VWallet\Projectors;


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
}
