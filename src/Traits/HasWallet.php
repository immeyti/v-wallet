<?php


namespace Immeyti\VWallet\Traits;

trait HasWallet
{
    public function createWallet($coin)
    {
        return app('wallet', [$this->getKey(), $coin]);
    }

    public function balance($coin)
    {
        $wallet = $this->firstOrCreateWallet($coin);

        return $wallet->balance();
    }

    public function deposit($coin, $amount, $meta = [])
    {
        $wallet = $this->firstOrCreateWallet($coin);

        return $wallet->deposit($amount, $meta);
    }

    public function withdraw($coin, $amount, $meta = [])
    {
        $wallet = $this->firstOrCreateWallet($coin);

        return $wallet->withdraw($amount, $meta);
    }

    public function firstOrCreateWallet($coin)
    {
        return app('wallet', [$this->getKey(), $coin]);
    }
}
