<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('fletters', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');$table->integer('client_id');$table->date('qdate');$table->string('attention');$table->string('designtion');$table->string('address');$table->string('subject');$table->string('ref');$table->string('lbody');$table->string('conclusion');$table->integer('sign_id');
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
        Schema::drop('fletters');
    }
}