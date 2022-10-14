<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalemastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_salemasters', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('invoice', 10);
			$table->date('sdate');
			$table->integer('client_id');
			$table->string('client_address');
			$table->integer('amount');
			$table->integer('discount');
			$table->integer('vat_tax');
			$table->integer('pre_due');
			$table->integer('paid');
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
        Schema::drop('salemasters');
    }
}