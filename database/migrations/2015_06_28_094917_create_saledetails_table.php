<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaledetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_saledetails', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('sm_id');
			$table->integer('item_id');
			$table->integer('qty');
			$table->integer('unit_id');
			$table->integer('rate');
			$table->string('amount');
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
        Schema::drop('saledetails');
    }
}