<?php

namespace Immeyti\VWallet\Commands;

use Illuminate\Console\Command;

class VWalletCommand extends Command
{
    public $signature = 'v-wallet';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
