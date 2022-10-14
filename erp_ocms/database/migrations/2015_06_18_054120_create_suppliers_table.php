<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_suppliers', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',100);
			$table->string('contact',60);
			$table->string('address');
			$table->integer('country_id');
			$table->string('email',60);
			$table->string('phone',60);
			$table->string('skype',40);
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
        Schema::drop('suppliers');
    }
}