<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('orders', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('jobno');$table->string('orderno');$table->string('style');$table->integer('buyer_id');$table->integer('mt_id');$table->string('item');$table->integer('uinit_id');$table->integer('price');$table->integer('bd_id');$table->string('fabrication');$table->integer('m_id');$table->integer('years');$table->integer('incoterm_id');$table->integer('lc_mod_id');
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
        Schema::drop('orders');
    }
}