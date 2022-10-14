<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Invendetails extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_invendetails';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['im_id', 'item_id', 'qty', 'unit_id', 'rate', 'amount','cos','war_id','accid','lc_id', 'ord_id', 'stl_id','ref', 'pro_id', 'seg_id','prod_id','batch', 'flag','for','war','com_id','user_id'];
	
		public function product() {
        return $this->belongsTo('App\Models\Acc\Products', 'item_id');
    }
	public function unit() {
        return $this->belongsTo('App\Models\Acc\AccUnits', 'unit_id');
    }

}