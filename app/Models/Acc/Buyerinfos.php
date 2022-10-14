<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Buyerinfos extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_buyerinfos';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'contact', 'address', 'country_id', 'email', 'phone', 'skype','com_id','user_id'];
    
    
    /**
     * EmployeeBasicInfos::religion()
     * 
     * @return
     */
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
	
	 public function country() {
        return $this->belongsTo('App\Models\Acc\Countries', 'country_id');
    }

}