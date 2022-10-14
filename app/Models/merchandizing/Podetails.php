<?php namespace App\Models\merchandizing;

use Illuminate\Database\Eloquent\Model;

class Podetails extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'merch_podetails';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['pm_id','jobno','breakdown_id','pono', 'port_id', 'shipment_date', 'color_sl', 'color', 'size_sl','size', 'ratio', 'qty','com_id','user_id'];
	
	public function port() {
        return $this->belongsTo('App\Models\merchandizing\Ports', 'port_id');
    }

	public function company() {
        return $this->belongsTo('App\Models\Acc\Companies', 'com_id');
    }
}