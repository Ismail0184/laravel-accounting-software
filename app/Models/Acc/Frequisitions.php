<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Frequisitions extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_frequisitions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['pr_id', 'ramount', 'aamount', 'currency_id', 'check_id', 'check_action', 'check_note', 'appr_id', 'appr_action', 'com_id','user_id'];

public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function check() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function approve() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function preq() {
        return $this->belongsTo('App\Models\Acc\Prequisitions', 'pr_id');
    }
	public function currency() {
        return $this->belongsTo('App\Models\Acc\Currencies', 'currency_id');
    }
}