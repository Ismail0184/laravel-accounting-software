<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Mteams extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_mteams';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'designation', 'salary', 'dtarget', 'mtarget', 'ytarget', 'iratio', 'mobile', 'email', 'users_id', 'com_id', 'user_id'];

}