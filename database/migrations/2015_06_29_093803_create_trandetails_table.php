<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrandetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_trandetails', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('tm_id');
			$table->integer('acc_id');
			$table->integer('tranwiths_id');
			$table->integer('amount');
			$table->integer('sh_id');
			$table->integer('m_id');
			$table->integer('year');
			$table->string('ref', 60);
			$table->string('c_number', 60);
			$table->string('b_name', 100);
			$table->date('c_date');
			$table->integer('lc_id');
			$table->integer('ord_id');
			$table->string('stl_id');
			$table->integer('stu_id');
			$table->integer('flag');
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
        Schema::drop('acc_trandetails');
    }
}