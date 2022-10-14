<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Coaconditions extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_coaconditions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['acc_id','interval', 'amount', 'osl', 'depreciation','dep_formula','dep_interval','com_id','user_id'];
	
	public function coa() {
        return $this->belongsTo('App\Models\Acc\Acccoas', 'acc_id');
    }
}