<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcccoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_coas', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 60);
			$table->integer('group_id');
			$table->integer('topGroup_id');
			$table->integer('sl');
			$table->string('atype', 30);
			$table->integer('detail_id')->unsigned();
			$table->integer('cond_id')->unsigned();
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
        Schema::drop('acccoas');
    }
}