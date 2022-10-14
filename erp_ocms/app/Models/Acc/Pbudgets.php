<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Pbudgets extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_pbudgets';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['pro_id', 'seg_id', 'prod_id', 'qty', 'unit_id', 'cur_id', 'rate', 'amount', 'com_id', 'user_id'];

}