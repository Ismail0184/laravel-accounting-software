<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class B2bs extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_b2bs';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['blcnumber', 'lc_id', 'client_id','bdate', 'shipmentdate', 'bamount', 'crateto', 'bank', 'acc_id', 'p_details','com_id','user_id'];

}