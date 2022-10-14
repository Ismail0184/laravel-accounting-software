<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Prequisitions extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_prequisitions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'ramount', 'currency_id', 'acc_id', 'rtypes', 'check_id', 'check_action','check_note', 'appr_id', 'appr_action','paid','com_id','user_id'];

	public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function check() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function approve() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function coa() {
        return $this->belongsTo('App\Models\Acc\acccoas', 'acc_id');
    }
	public function currency() {
        return $this->belongsTo('App\Models\Acc\Currencies', 'currency_id');
    }

}