<?php

namespace Immeyti\VWallet;

use Illuminate\Support\ServiceProvider;
use Immeyti\VWallet\Commands\WalletCommand;

class WalletServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/wallet.php' => config_path('wallet.php'),
            ], 'config');

            $migrationFileName = 'create_wallets_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                WalletCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/wallet.php', 'wallet');
        //$this->mergeConfigFrom(__DIR__ . '/../config/event-sourcing.php', 'event-sourcing');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
