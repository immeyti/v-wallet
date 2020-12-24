<?php

namespace Immeyti\VWallet;

use Illuminate\Support\ServiceProvider;
use Immeyti\VWallet\Commands\VWalletCommand;

class VWalletServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/v-wallet.php' => config_path('v-wallet.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/v-wallet'),
            ], 'views');

            $migrationFileName = 'create_v_wallet_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                VWalletCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'v-wallet');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/v-wallet.php', 'v-wallet');
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
