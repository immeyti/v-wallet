<?php

namespace Immeyti\VWallet;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Immeyti\VWallet\VWallet
 */
class WalletFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wallet';
    }
}
