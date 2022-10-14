<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Budgets extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_budgets';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'btype','byear', 'acc_id', 'amount','com_id', 'user_id'];
	
		public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
	
	public function coa() {
        return $this->belongsTo('App\Models\Acc\acccoas', 'account_id');
    }


}