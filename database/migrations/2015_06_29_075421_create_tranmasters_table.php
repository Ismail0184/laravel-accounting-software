<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranmastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_tranmasters', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('vnumber');
			$table->date('tdate');
			$table->string('note');
			$table->integer('tranwith_id');
			$table->integer('tmamount');
			$table->integer('req_id');
			$table->integer('currency_id');
			$table->integer('check_id');
			$table->integer('check_action');
			$table->string('check_note', 200);
			$table->integer('appr_id');
			$table->integer('appr_action');
			$table->string('appr_note', 200);
			$table->string('ttype', 20);
			$table->integer('com_id');
			$table->integer('proj_id');
			$table->string('person', 100);
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
        Schema::drop('acc_tranmasters');
    }
}