<?php namespace App\Models\merchandizing;

use Illuminate\Database\Eloquent\Model;

class Orderolds extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'merch_orders_old';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['jobno', 'orderno', 'style', 'buyer_id', 'mt_id', 'item', 'currency_id', 'price', 'bd_id', 'fabrication', 'm_id', 'years', 'incoterm_id', 'lc_mod_id','com_id','user_id'];

	public function currency() {
        return $this->belongsTo('App\Models\Acc\Currencies', 'currency_id');
    }
	public function team() {
        return $this->belongsTo('App\Models\merchandizing\Marketingteams', 'mt_id');
    }
	public function buyer() {
        return $this->belongsTo('App\Models\merchandizing\Buyers', 'buyer_id');
    }
	public function breakdown() {
        return $this->belongsTo('App\Models\merchandizing\Bdtypes', 'bd_id');
    }
	public function lcmode() {
        return $this->belongsTo('App\Models\merchandizing\Lcmodes', 'lc_mod_id');
    }
	public function incoterm() {
        return $this->belongsTo('App\Models\merchandizing\Incoterms', 'incoterm_id');
    }
	public function company() {
        return $this->belongsTo('App\Models\Acc\Companies', 'com_id');
    }


}