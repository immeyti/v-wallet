<?php

namespace Immeyti\VWallet\Tests\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Immeyti\VWallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasWallet, HasFactory;


}
