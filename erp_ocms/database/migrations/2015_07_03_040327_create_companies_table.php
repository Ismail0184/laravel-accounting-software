<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_companies', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
			$table->string('oaddress', 255);
			$table->string('faddress2', 255);
			$table->string('mobile', 60);
			$table->string('phone', 60);
			$table->string('fax', 60);
			$table->string('email', 60);
			$table->string('web', 60);
			$table->date('stablish');
			$table->string('businessn', 255);
			$table->string('md', 60);
			$table->string('chair', 60);
			$table->string('d1', 60);
			$table->string('d2', 60);
			$table->string('d3', 60);
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
        Schema::drop('companies');
    }
}