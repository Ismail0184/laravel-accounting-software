<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_settings', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('gname'. 60);
			$table->integer('ccount');
			$table->string('onem');
			$table->integer('m1');
			$table->integer('m2');
			$table->integer('m3');
			$table->integer('m4');
			$table->integer('m5');
			$table->integer('m6');
			$table->integer('m7');
			$table->integer('m8');
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
        Schema::drop('settings');
    }
}