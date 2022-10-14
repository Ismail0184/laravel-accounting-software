<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLctransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('lctransfers', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('client_id');$table->integer('lc_id');$table->date('tlcdate');$table->string('com_rate');$table->integer('camount');$table->string('note');
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
        Schema::drop('lctransfers');
    }
}