<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_products', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',60);
			$table->integer('group_id');
			$table->integer('topGroup_id');
			$table->string('ptype', 10);
			$table->integer('sl');
			$table->integer('detail_id');
			$table->integer('cond_id');
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
        Schema::drop('products');
    }
}