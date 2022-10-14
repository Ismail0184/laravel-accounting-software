<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Orderinfos extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_orderinfos';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['lcnumber','ordernumber', 'ordervalue', 'orderqty', 'unit_id',  'currency_id', 'productdetails','com_id','user_id'];

	public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function lc() {
        return $this->belongsTo('App\Models\Acc\Lcinfos', 'lcnumber');
    }
	public function unit() {
        return $this->belongsTo('App\Models\Acc\AccUnits', 'unit_id');
    }
}