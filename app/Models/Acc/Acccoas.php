<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Acccoas extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_coas';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'group_id', 'topGroup_id','atype', 'sl', 'user_id', 'detail_id', 'cond_id', 'com_id', 'user_id'];

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

}