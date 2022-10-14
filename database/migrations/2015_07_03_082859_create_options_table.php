<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_options', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('bstype', 60);
			$table->integer('export');
			$table->integer('import');
			$table->integer('scenter');
			$table->integer('budget');
			$table->integer('project');
			$table->integer('audit');
			$table->integer('inventory');
			$table->integer('tcheck_id');
			$table->integer('tappr_id');
			$table->integer('rcheck_id');
			$table->integer('rappr_id');
			$table->integer('frcheck_id');
			$table->integer('frappr_id');
			$table->integer('max_pay');
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
        Schema::drop('options');
    }
}