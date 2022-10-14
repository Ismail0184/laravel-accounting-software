<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Warehouses extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_warehouses';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'incharge', 'mobile', 'com_id', 'user_id'];

}