<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Importdetails extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_importdetails';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['im_id', 'item_id', 'qty', 'unit_id', 'rate', 'amount', 'com_id', 'user_id'];

}