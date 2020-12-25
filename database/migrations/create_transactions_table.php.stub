<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
         Schema::create('transactions', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->uuid('uuid');
             $table->string('type')->nullable();
             $table->float('amount', 24, 12)->nullable();
             $table->string('meta')->nullable();
             $table->timestamps();

         });
    }
}
