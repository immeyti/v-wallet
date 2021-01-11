<?php


namespace Immeyti\VWallet\Traits;


use Immeyti\VWallet\Wallet;

trait HasWallet
{
    public function createWallet($coin)
    {
        return app('wallet', [$this->getKey(), $coin]);
    }

    public function balance($coin)
    {
        $wallet = app('wallet', [$this->getKey(), $coin]);

        return $wallet->balance();
    }

    public function deposit($coin, $amount, $meta = [])
    {
        $wallet = app('wallet', [$this->getKey(), $coin]);

        return $wallet->deposit($amount, $meta);

    }

    public function withdraw($coin, $amount, $meta = [])
    {
        $wallet = app('wallet', [$this->getKey(), $coin]);

        return $wallet->withdraw($amount, $meta);

    }
}
