<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoverpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('coverpages', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('header');$table->integer('footer');$table->string('mtitle');$table->string('subtitle');$table->string('estyear');$table->string('founder');$table->string('breif');
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
        Schema::drop('coverpages');
    }
}