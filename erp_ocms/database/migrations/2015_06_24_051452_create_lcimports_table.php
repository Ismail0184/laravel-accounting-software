<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLcimportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_lcimports', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('lcnumber', 60);
			$table->date('lcdate');
			$table->date('shipmentdate');
			$table->date('expdate');
			$table->integer('supplier_id');
			$table->integer('country_id');
			$table->integer('lcvalue');
			$table->integer('currency_id');
			$table->integer('lcqty');
			$table->string('unit',10);
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
        Schema::drop('lcimports');
    }
}