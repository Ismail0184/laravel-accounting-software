<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Uoutlets extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_uoutlets';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['designation', 'users_id', 'olt_id','setting','com_id','user_id'];

}