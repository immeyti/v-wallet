<?php

namespace Immeyti\VWallet\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Immeyti\VWallet\Traits\HasWallet;

class User extends Authenticatable
{
    use HasWallet;
    use HasFactory;
}
