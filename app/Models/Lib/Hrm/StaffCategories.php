<?php namespace App\Models\Lib\Hrm;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class StaffCategories extends Model  {
    
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lib_staff_categories';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'user_id'];

	/**
	 * The attributes use for soft delete.
	 *
	 * @var timestamp
	 */
    protected $dates = ['deleted_at'];

}