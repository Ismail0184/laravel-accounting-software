<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Purchasemasters extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_purchasemasters';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice', 'pdate', 'client_id','client', 'client_address', 'amount','wh_id', 'discount', 'vat_tax', 'transport','other','note', 'paid', 'acc_id', 'previous_due', 'balance', 'currency_id','check_id','check_action','check_note', 'com_id', 'user_id'];

		public function client() {
        return $this->belongsTo('App\Models\Acc\Clients', 'client_id');
    }
		public function wh() {
        return $this->belongsTo('App\Models\Acc\Warehouses', 'wh_id');
    }

}