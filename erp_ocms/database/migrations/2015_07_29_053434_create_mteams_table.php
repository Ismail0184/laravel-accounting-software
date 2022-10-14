<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMteamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_mteams', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
			$table->string('designation');
			$table->integer('salary');
			$table->integer('dtarget');
			$table->integer('mtarget');
			$table->integer('ytarget');
			$table->integer('iratio');
			$table->string('mobile');
			$table->string('email');
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
        Schema::drop('acc_mteams');
    }
}