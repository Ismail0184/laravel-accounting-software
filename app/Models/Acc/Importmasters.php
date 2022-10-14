<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Importmasters extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_importmasters';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice', 'idate', 'lcimport_id', 'com_id', 'user_id'];
		
		
		
	public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

	public function lcimport() {
        return $this->belongsTo('App\Models\Acc\Lcimports', 'lcimport_id');
    }
	
	public function details() {
        return $this->belongsTo('App\Models\Acc\Importdetails');
    }
}