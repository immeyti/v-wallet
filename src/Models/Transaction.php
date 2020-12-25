<?php


namespace Immeyti\VWallet\Models;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'meta' => 'array'
    ];

    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAW = 'withdraw';

    public static function createWithAttr(array $attr)
    {
        return self::create($attr);
    }
}
