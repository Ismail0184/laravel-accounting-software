<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Conditions extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_conditions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'topic_id','user_id'];
	
	public function topic() {
        return $this->belongsTo('App\Models\Acc\Topics', 'topic_id'); //tycraratio_id
    }


}