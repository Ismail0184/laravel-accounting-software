<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stock_balance';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'emp_id', 'address', 'mobile', 'email','user_id'];


	
}