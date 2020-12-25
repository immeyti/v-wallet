<?php


namespace Immeyti\VWallet\Exceptions;


class SufficientFundsToWithdrawAmountException extends \Exception
{
    protected $message = 'Amount is more than balance';
}
