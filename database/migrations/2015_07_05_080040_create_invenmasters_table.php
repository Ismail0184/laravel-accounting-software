<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvenmastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_invenmasters', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('vnumber');
			$table->date('idate');
			$table->string('person', 60);
			$table->integer('itype');
			$table->integer('req_id');
			$table->integer('amount');
			$table->integer('note',200);
			$table->integer('currency_id');
			$table->integer('check_id');
			$table->integer('check_action');
			$table->string('check_note', 200);
			$table->integer('audit_id');
			$table->integer('audit_action');
			$table->string('audit_note', 200);
			$table->integer('com_id');
			$table->integer('proj_id');
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
        Schema::drop('invenmasters');
    }
}