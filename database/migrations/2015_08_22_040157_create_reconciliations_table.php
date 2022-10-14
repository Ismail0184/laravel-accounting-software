<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReconciliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('reconciliations', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('acc_id');$table->date('tdate');$table->integer('amount');$table->integer('tranwith_id');$table->string('note');$table->integer('com_id');
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
        Schema::drop('reconciliations');
    }
}