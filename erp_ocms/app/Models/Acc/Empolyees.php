<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Empolyees extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_empolyees';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'designation_id', 'jdate', 'gsalary','bsalary','conv','hrent','tran','enter','sallow','mobile','mexp', 'department_id', 'sh_id', 'sl','esf' ,'active','com_id','user_id'];
	
	public function subhead() {
        return $this->belongsTo('App\Models\Acc\Subheads', 'sh_id');
    }
public function designation() {
        return $this->belongsTo('App\Models\Acc\Desigtns', 'designation_id');
    }
public function department() {
        return $this->belongsTo('App\Models\Acc\Departments', 'department_id');
    }


}