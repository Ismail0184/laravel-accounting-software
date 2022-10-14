<?php namespace App\Models\Lib\Hrm;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class GovtSalaries extends Model  {
    
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lib_govt_salaries';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'amount', 'user_id'];

	/**
	 * The attributes use for soft delete.
	 *
	 * @var timestamp
	 */
    protected $dates = ['deleted_at'];

}