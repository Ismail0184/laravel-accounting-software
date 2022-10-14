<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Usercompanies extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_usercompanies';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'users_id', 'com_id', 'setting', 'techeck_id','department_id','pettycash_id', 'topsheet', 'com_id','user_id'];

}