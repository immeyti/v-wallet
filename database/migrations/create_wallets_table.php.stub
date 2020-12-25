<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    public function up()
    {
         Schema::create('wallets', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->string('uuid');
                $table->string('coin');
                $table->float('balance', 24, 12)->default(0);
                $table->float('blocked_balance', 24, 12)->default(0);
                $table->boolean('active')->default(true);
                $table->timestamps();
          });
    }
}
