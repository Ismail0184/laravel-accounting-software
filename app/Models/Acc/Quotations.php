<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Quotations extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_quotations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'cpage_id', 'fletter_id','user_id'];
	
	public function cpage() {
        return $this->belongsTo('App\Models\Acc\Coverpages', 'cpage_id');
    }
	public function fletter() {
        return $this->belongsTo('App\Models\Acc\Fletters', 'fletter_id');
    }

}