<?php


namespace Immeyti\VWallet\Aggregates;

use Immeyti\VWallet\Events\Deposited;
use Immeyti\VWallet\Events\WalletCreated;
use Immeyti\VWallet\Events\Withdrew;
use Immeyti\VWallet\Exceptions\SufficientFundsToWithdrawAmountException;
use Immeyti\VWallet\Exceptions\WalletExists;
use Immeyti\VWallet\Wallet;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

final class WalletAggregate extends AggregateRoot
{
    private $balance = 0;
    private $blocked_balance;
    private $balanceLimit;
    private $walletIsBlocked = false;

    public function __construct()
    {
        $this->balanceLimit = config('wallet.balance_limit', 0);
    }

    /**
     * @param int $userId
     * @param string $coin
     * @return $this
     * @throws WalletExists
     */
    public function createWallet(int $userId, string $coin)
    {
        if ($this->walletExists($userId, $coin)) {
            throw new WalletExists();
        }

        $this->recordThat(new WalletCreated($userId, $coin));

        return $this;
    }

    /**
     * @param Wallet $wallet
     * @param float $amount
     * @param array $meta
     * @return $this
     */
    public function deposit(Wallet $wallet, float $amount, array $meta)
    {
        $this->recordThat(new Deposited($amount, $meta));

        return $this;
    }

    public function applyDeposited(Deposited $event)
    {
        $this->balance += $event->amount;
    }

    /**
     * @param Wallet $wallet
     * @param float $amount
     * @param array $meta
     * @return $this
     * @throws SufficientFundsToWithdrawAmountException
     */
    public function withdraw(Wallet $wallet, float $amount, array $meta)
    {
        if (! $this->hasSufficientFundsToWithdrawAmount($amount)) {
            throw new SufficientFundsToWithdrawAmountException();
        }

        $this->recordThat(new Withdrew($amount, $meta));

        return $this;
    }

    public function applyWithdrew(Withdrew $event)
    {
        $this->balance -= $event->amount;
    }

    private function walletExists(int $userId, string $coin)
    {
        return \Immeyti\VWallet\Models\Wallet::isExist($userId, $coin);
    }

    private function hasSufficientFundsToWithdrawAmount($amount)
    {
        return $this->balance - $amount >= $this->balanceLimit;
    }
}
