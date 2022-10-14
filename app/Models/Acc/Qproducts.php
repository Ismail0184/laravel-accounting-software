<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Qproducts extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_qproducts';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['quotation_id', 'prod_id', 'qty', 'rate','com_id','user_id'];

	public function product() {
        return $this->belongsTo('App\Models\Acc\Products', 'prod_id');
    }
	public function quotation() {
        return $this->belongsTo('App\Models\Acc\Quotations', 'quotation_id');
    }

}