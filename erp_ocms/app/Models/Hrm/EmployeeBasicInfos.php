<?php namespace App\Models\Hrm;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeBasicInfos extends Model  {
    
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hrm_employee_basic_info';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['fullname', 'father_name', 'mother_name', 'husband_name', 'no_of_child', 'dob', 'nid', 'bcn', 'nationality', 'passport', 'sex', 'marital_status', 'religion', 'driving_license', 'tin_no', 'bank_name', 'bank_barnch', 'acc_no', 'email', 'mob_office', 'mob_personal', 'phone', 'employee_img', 'sameas', 'per_road', 'per_house', 'per_flat', 'per_vill', 'per_po', 'per_ps', 'per_city', 'per_dist', 'per_zip', 'per_division', 'per_country', 'pre_road', 'pre_house', 'pre_flat', 'pre_vill', 'pre_po', 'pre_ps', 'pre_city', 'pre_dist', 'pre_zip', 'pre_division', 'pre_country', 'employee_status', 'employee_code', 'employee_type', 'employee_nature', 'user_id'];

	/**
	 * The attributes use for soft delete.
	 *
	 * @var array
	 */
    protected $dates = ['deleted_at'];
    
    
    /**
     * EmployeeBasicInfos::religion()
     * 
     * @return
     */
    public function religion() {
        return $this->belongsTo('App\Models\Lib\Hrm\Religions');
    }

}