<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Salemasters extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_salemasters';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice', 'sdate', 'client_id', 'client', 'client_address', 'samount','acc_id','wh_id', 'currency_id', 'discount', 'vat_tax', 'pre_due', 'paid', 'balance','check_id','check_note','check_action','mt_id','outlet_id','com_id','user_id'];
	
		public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

		public function check() {
        return $this->belongsTo('App\User', 'user_id');
		}
}