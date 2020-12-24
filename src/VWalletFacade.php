<?php

namespace Immeyti\VWallet;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Immeyti\VWallet\VWallet
 */
class VWalletFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'v-wallet';
    }
}
