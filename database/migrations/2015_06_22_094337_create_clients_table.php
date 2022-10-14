<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_clients', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',100);
			$table->string('contact',60);
			$table->string('address1');
			$table->string('address2');
			$table->string('email',60);
			$table->string('phone',60);
			$table->string('skype',20);
			$table->string('businessn');
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
        Schema::drop('clients');
    }
}