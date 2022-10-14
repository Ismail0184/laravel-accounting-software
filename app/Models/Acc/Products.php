<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Products extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_products';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'note', 'group_id', 'topGroup_id', 'ptype','unit_id', 'price','cos', 'sl', 'detail_id', 'cond_id','com_id','user_id'];

	
	public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
	public function unit() {
        return $this->belongsTo('App\Models\Acc\AccUnits', 'unit_id');
    }
	public function group() {
        return $this->belongsTo('App\Models\Acc\Products', 'group_id');
    }

}