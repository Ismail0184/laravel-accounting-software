<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_styles', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',60);
			$table->integer('ordernumber');
			$table->integer('stylevalue');
			$table->integer('styleqty');
			$table->string('unit',10);
			$table->string('description');
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
        Schema::drop('styles');
    }
}