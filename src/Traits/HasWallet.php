<?php


namespace Immeyti\VWallet\Traits;


use Immeyti\VWallet\Wallet;

trait HasWallet
{
    public function creatWallet($coin)
    {
        return Wallet::create($this->getKey(), $coin);
    }

    public function getWallets()
    {
        return Wallet::getWallets(['user_id' => $this->getkey()]);
    }

    public function balance($coin)
    {
        $walletModel = Wallet::getWallets([
            'user_id' => $this->getkey(),
            'coin' => $coin
        ]);

        if (! $walletModel->count())
            return 0;

        return $walletModel->first()->balance;
    }

    public function deposit($coin, $amount, $meta = [])
    {
        $walletModel = Wallet::getWallets([
            'user_id' => $this->getkey(),
            'coin' => $coin
        ])->first();

        if (! $walletModel)
            $walletModel = Wallet::create($this->getkey(), $coin);


        return Wallet::deposit($walletModel, $amount, $meta);

    }

    public function withdraw($coin, $amount, $meta = [])
    {
        $walletModel = Wallet::getWallets([
            'user_id' => $this->getkey(),
            'coin' => $coin
        ])->first();


        return Wallet::withdraw($walletModel, $amount, $meta);

    }
}
