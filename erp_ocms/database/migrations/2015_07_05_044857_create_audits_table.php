<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('acc_audits', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('title', 100);
			$table->integer('vnumber');
			$table->string('note', 200);
			$table->integer('sendto');
			$table->integer('audit_action');
			$table->integer('reply_id');
			$table->string('reply_note', 200);
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
        Schema::drop('audits');
    }
}