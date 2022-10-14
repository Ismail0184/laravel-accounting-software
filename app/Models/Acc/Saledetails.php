<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Saledetails extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_saledetails';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['sm_id', 'item_id', 'qty', 'unit_id', 'rate', 'amount','group_id','com_id', 'user_id'];

}