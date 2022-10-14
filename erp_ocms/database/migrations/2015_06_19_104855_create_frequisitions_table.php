<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_frequisitions', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
			$table->integer('ramount');
			$table->integer('aamount');
			$table->integer('currency_id');
			$table->integer('check_id');
			$table->integer('check_action');
			$table->string('check_note', 200);
			$table->integer('appr_id');
			$table->integer('appr_action');
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
        Schema::drop('acc_frequisitions');
    }
}