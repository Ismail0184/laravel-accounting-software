<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_purchasedetails', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('pm_id');
			$table->integer('item_id');
			$table->integer('qty');
			$table->integer('unit_id');
			$table->integer('rate');
			$table->integer('amount');
			$table->integer('currency_id');
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
        Schema::drop('purchasedetails');
    }
}