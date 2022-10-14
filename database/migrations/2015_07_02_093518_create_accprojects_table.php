<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateaccProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_projects', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
			$table->string('description');
			$table->string('location', 150);
			$table->integer('cost');
			$table->date('pdate');
			$table->date('sdate');
			$table->date('fdate');
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
        Schema::drop('acc_projects');
    }
}