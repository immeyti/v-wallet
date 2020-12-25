<?php


namespace Immeyti\VWallet\Models;


use Illuminate\Database\Eloquent\Model;
use Immeyti\VWallet\Events\WalletCreated;
use Ramsey\Uuid\Uuid;

/**
 * @property int id
 * @property string uuid
 * @property int user_id
 * @property float balance
 * @property float blocked_balance
 */

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

    public static function isExist(int $userId, string $coin)
    {
        return self::whereUserId($userId)->whereCoin($coin)->exists();
    }

}
