<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Lcinfos extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_lcinfos';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['lcnumber', 'lcdate','shipmentdate','expdate', 'buyer_id', 'country_id', 'lcamount', 'currency_id', 'crateto', 'unit_id', 'productdetails','com_id','user_id'];



	public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
	
	 public function buyer() {
        return $this->belongsTo('App\Models\Acc\Buyerinfos', 'buyer_id');
    }
	 
	 public function country() {
        return $this->belongsTo('App\Models\Acc\Countries', 'country_id');
    }

	public function currency() {
        return $this->belongsTo('App\Models\Acc\Currencies', 'currency_id');
    }
	
	public function unit() {
        return $this->belongsTo('App\Models\Acc\AccUnits', 'unit_id');
    }
}