<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePbudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_pbudgets', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('pro_id');
			$table->integer('seg_id');
			$table->integer('prod_id');
			$table->integer('qty');
			$table->integer('unit_id');
			$table->integer('cur_id');
			$table->integer('rate');
			$table->integer('amount');
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
        Schema::drop('pbudgets');
    }
}