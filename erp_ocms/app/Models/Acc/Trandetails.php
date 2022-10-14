<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Trandetails extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_trandetails';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tm_id', 'acc_id', 'tranwiths_id', 'amount', 'sh_id', 'dep_id','pro_id','seg_id','prod_id','sis_id','sis_accid','sis_action','m_id','year','ref', 'c_number','b_name','c_date','ilc_id','lc_id','b2b_id', 'ord_id', 'stl_id', 'stu_id','flag','rmndr_id','rmndr_note','rmndr_date','mdeduction','com_id','user_id'];

	public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function check() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function approve() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function currency() {
        return $this->belongsTo('App\Models\Acc\Currencies', 'currency_id');
    }
	public function master() {
        return $this->belongsTo('App\Models\Acc\Tranmasters', 'tm_id');
    }
	public function subhead() {
        return $this->belongsTo('App\Models\Acc\Subheads', 'sh_id');
    }
	public function coa() {
        return $this->belongsTo('App\Models\Acc\Acccoas', 'acc_id');
    }
	public function twith() {
        return $this->belongsTo('App\Models\Acc\Acccoas', 'tranwiths_id');
    }
	public function project() {
        return $this->belongsTo('App\Models\Acc\Projects', 'pro_id');
    }
	public function department() {
        return $this->belongsTo('App\Models\Acc\Departments', 'dep_id');
    }
	
}