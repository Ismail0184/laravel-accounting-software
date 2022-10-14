<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePplanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_pplannings', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('pro_id');
			$table->string('segment');
			$table->date('stdate');
			$table->date('cldate');
			$table->integer('bamount');
			$table->integer('group_id');
			$table->string('gtype', 20);
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
        Schema::drop('pplannings');
    }
}