<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateB2bsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_b2bs', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
			$table->integer('lc_id');
			$table->date('bdate');
			$table->date('sdate');
			$table->integer('bamount');
			$table->string('p_details');
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
        Schema::drop('acc_b2bs');
    }
}