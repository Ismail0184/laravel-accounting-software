<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class AccUnits extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_units';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'user_id'];

}