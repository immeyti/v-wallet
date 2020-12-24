<?php


namespace Immeyti\VWallet\Models;


use Illuminate\Database\Eloquent\Model;
use Immeyti\VWallet\Events\WalletCreated;
use Ramsey\Uuid\Uuid;

class Wallet extends Model
{
    protected $guarded = ['id'];


    public static function createWithAttr(array $attr): self
    {
        self::create($attr);

        return self::uuid($attr['uuid']);
    }

    public static function uuid(string $uuid): ?self
    {
        return self::whereUuid($uuid)->first();
    }
}
