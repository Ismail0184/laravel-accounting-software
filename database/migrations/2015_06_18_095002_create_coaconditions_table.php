<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoaconditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_coaconditions', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
			$table->integer('acc_id');
            $table->string('maxamount');
			$table->string('remainder1');
			$table->string('remainder2');
			$table->string('remainder3');
			$table->string('depreciatetion');
			$table->string('monthly');
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
        Schema::drop('acc_coaconditions');
    }
}