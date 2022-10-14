<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_clients';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'contact', 'address1', 'address2', 'email', 'phone', 'skype', 'businessn', 'acc_id', 'com_id','user_id'];


	public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}