<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Lcimports extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_lcimports';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['lcnumber', 'lcdate', 'shipmentdate', 'expdate', 'supplier_id', 'country_id', 'lcvalue', 'currency_id', 'lcqty', 'unit', 'com_id','user_id'];


	public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
	
	 public function supplier() {
        return $this->belongsTo('App\Models\Acc\Suppliers', 'supplier_id');
    }
	 
	 public function country() {
        return $this->belongsTo('App\Models\Acc\Countries', 'country_id');
    }

	public function currency() {
        return $this->belongsTo('App\Models\Acc\Currencies', 'currency_id');
    }
	
	public function unit() {
        return $this->belongsTo('App\Models\Acc\Units', 'unit_id');
    }
}