<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasemastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_purchasemasters', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('invoice', 10);
			$table->date('pdate');
			$table->integer('client_id');
			$table->string('client_address');
			$table->integer('amount');
			$table->integer('discount');
			$table->integer('vat_tax');
			$table->integer('transport');
			$table->integer('paid');
			$table->integer('previous_due');
			$table->integer('balance');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('purchasemasters');
    }
}