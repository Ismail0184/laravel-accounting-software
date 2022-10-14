<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeBasicInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('hrm_employee_basic_info', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('fullname');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('husband_name');
            $table->integer('no_of_child');
            $table->string('dob', 10);
            $table->string('nid', 20);
            $table->string('bcn', 20);
            $table->string('nationality', 50);
            $table->string('passport', 30);
            $table->string('sex', 20);
            $table->string('marital_status', 20);
            $table->integer('religion')->unsigned();
            $table->string('driving_license', 20);
            $table->string('tin_no', 30);
            $table->string('bank_name');
            $table->string('bank_barnch');
            $table->string('acc_no', 30);
            $table->string('email')->unique();
            $table->string('mob_office', 20);
            $table->string('mob_personal', 20);
            $table->string('phone', 20);
            $table->string('employee_img');
            $table->tinyInteger('sameas');
            $table->string('per_road');
            $table->string('per_house');
            $table->string('per_flat');
            $table->string('per_vill');
            $table->string('per_po');
            $table->string('per_ps');
            $table->string('per_city');
            $table->integer('per_dist')->unsigned();
            $table->string('per_zip');
            $table->integer('per_division')->unsigned();
            $table->string('per_country');
            
            $table->string('pre_road');
            $table->string('pre_house');
            $table->string('pre_flat');
            $table->string('pre_vill');
            $table->string('pre_po');
            $table->string('pre_ps');
            $table->string('pre_city');
            $table->integer('pre_dist')->unsigned();
            $table->string('pre_zip');
            $table->integer('pre_division')->unsigned();
            $table->string('pre_country');
            
            $table->string('employee_status', 50);
            $table->string('employee_code', 30)->unique();
            $table->string('employee_type', 50);
            $table->string('employee_nature', 50);
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('religion')->references('id')->on('lib_religions');
            $table->foreign('per_dist')->references('id')->on('lib_districts');
            $table->foreign('per_division')->references('id')->on('lib_divisions');
            $table->foreign('pre_dist')->references('id')->on('lib_districts');
            $table->foreign('pre_division')->references('id')->on('lib_divisions');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hrm_employee_basic_info');
    }
}