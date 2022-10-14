<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_prequisitions', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
			$table->string('description');
			$table->integer('amount');
			$table->integer('currency_id');
			$table->integer('acc_id');
			$table->string('rtypes', 20);
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
        Schema::drop('acc_prequisitions');
    }
}