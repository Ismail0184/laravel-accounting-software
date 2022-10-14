<?php namespace App\Models\merchandizing;

use Illuminate\Database\Eloquent\Model;

class Pomasters extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'merch_pomasters';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id','jobno','pono', 'po_rcvd_date', 'factory_ship_date', 'shipment_date', 'qty', 'unit_id', 'port_id', 'color_count', 'size_count','com_id','user_id'];
	
	public function order() {
        return $this->belongsTo('App\Models\merchandizing\Orders', 'order_id');
    }

	public function unit() {
        return $this->belongsTo('App\Models\Acc\AccUnits', 'unit_id');
    }
	public function company() {
        return $this->belongsTo('App\Models\Acc\Companies', 'com_id');
    }
	public function port() {
        return $this->belongsTo('App\Models\merchandizing\Ports', 'port_id');
    }

}