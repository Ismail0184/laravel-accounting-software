<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_outlets', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
			$table->integer('emp_id');
			$table->string('address');
			$table->string('mobile', 40);
			$table->string('email', 40);
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
        Schema::drop('outlets');
    }
}