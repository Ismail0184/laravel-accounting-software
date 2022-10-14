<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLcinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_lcinfos', function(Blueprint $table)
        {
            
			$table->increments('id')->unsigned();
            $table->string('lcnumber', 60);
			$table->date('lcdate');
			$table->date('shipmentdate');
			$table->date('expdate');
			$table->integer('buyer_id');
			$table->integer('country_id');
			$table->integer('lcamount');
			$table->integer('currency_id');
			$table->integer('qty');
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
        Schema::drop('lcinfos');
    }
}