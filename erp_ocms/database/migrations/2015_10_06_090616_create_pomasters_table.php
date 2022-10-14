<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePomastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('pomasters', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('order_id');$table->date('po_rcvd_date');$table->date('factory_ship_date');$table->date('shipment_date');$table->integer('qty');$table->integer('unit_id');$table->integer('port_id');$table->integer('color_count');$table->integer('size_count');
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
        Schema::drop('pomasters');
    }
}