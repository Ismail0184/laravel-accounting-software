<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('fabricdetails', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('order_id');$table->string('gtype_id');$table->string('pogarment_id');$table->string('diatype_id');$table->string('dia_id');$table->string('structure_id');$table->string('gsm_id');$table->string('ftype_id');$table->string('unit_id');$table->string('ytype_id');$table->string('ycount_id');$table->string('yconsumption_id');$table->string('ydstripe_id');$table->string('ydrepeat');$table->string('washing_id');$table->string('ccuff_id');$table->string('aop_id');$table->string('tycraratio_id');$table->string('cprocess_id');
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
        Schema::drop('fabricdetails');
    }
}