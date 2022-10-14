<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvendetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_invendetails', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('im_id');
			$table->integer('item_id');
			$table->integer('qty');
			$table->integer('unit_id');
			$table->integer('rate');
			$table->integer('amount');
			$table->integer('com_id');
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
        Schema::drop('invendetails');
    }
}