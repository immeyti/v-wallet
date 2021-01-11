<?php

namespace Immeyti\VWallet\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Immeyti\VWallet\WalletServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\EventSourcing\EventSourcingServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            function ($modelName) {
                return 'Immeyti\\VWallet\\Database\\Factories\\'.class_basename($modelName).'Factory';
            }
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            WalletServiceProvider::class,
            EventSourcingServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        /*$eventSourcingConfig = include_once __DIR__.'/../config/event-sourcing.php';

        $app['config']->set('event-sourcing', $eventSourcingConfig);*/

        include_once __DIR__ . '/../database/migrations/create_wallets_table.php.stub';
        (new \CreateWalletsTable())->up();

        include_once __DIR__ . '/../database/migrations/create_transactions_table.php.stub';
        (new \CreateTransactionsTable())->up();

        include_once __DIR__.'/migrations/create_snapshots_table.php';
        (new \CreateSnapshotsTable())->up();

        include_once __DIR__.'/migrations/create_stored_events_table.php';
        (new \CreateStoredEventsTable())->up();

        include_once __DIR__ . '/migrations/create_users_table.php';
        (new \CreateUsersTable())->up();
    }
}
