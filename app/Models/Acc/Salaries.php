<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Salaries extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_salaries';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['emp_id', 'gsalary','basic', 'hrent', 'conv', 'mexp','lunch','due','mobile','sallow', 'otime', 'hday', 'wday', 'asalary', 'loan', 'absence', 'other', 'm_id', 'year','department_id','esf','save','com_id','user_id'];

	public function employee() {
        return $this->belongsTo('App\Models\Acc\Empolyees', 'emp_id');
    }


}