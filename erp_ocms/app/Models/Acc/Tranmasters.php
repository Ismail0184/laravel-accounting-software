<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Tranmasters extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_tranmasters';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['vnumber', 'tdate', 'note', 'tranwith_id', 'sh_id', 'tmamount', 'con_rate', 'req_id', 'currency_id', 'check_id', 'check_action', 'check_note', 'techeck_id', 'techeck_action', 'techeck_note', 'appr_id', 'appr_action', 'appr_note', 'audit_id', 'audit_action', 'audit_note', 'ttype', 'com_id', 'proj_id', 'person','user_id'];

	public function currency() {
        return $this->belongsTo('App\Models\Acc\Currencies', 'currency_id');
    }
	public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function check() {
        return $this->belongsTo('App\User', 'check_id');
    }
	public function appr() {
        return $this->belongsTo('App\User', 'appr_id');
    }
		public function subhead() {
        return $this->belongsTo('App\Models\Acc\Subheads', 'sh_id');
    }

}