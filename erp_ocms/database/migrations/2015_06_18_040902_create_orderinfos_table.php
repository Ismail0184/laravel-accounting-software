<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_orderinfos', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('ordernumber',60);
			$table->string('lcnumber',60);
			$table->integer('ordervalue');
			$table->integer('orderqty');
			$table->integer('unit_id');
			$table->string('productdetails');
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
        Schema::drop('orderinfos');
    }
}