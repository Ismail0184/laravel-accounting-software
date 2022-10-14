<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Outlets extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_outlets';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'emp_id', 'address', 'mobile', 'email', 'com_id','user_id'];


	public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}