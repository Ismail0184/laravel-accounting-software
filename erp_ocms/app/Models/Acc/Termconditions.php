<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Termconditions extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_termconditions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['quotation_id', 'topic_id', 'condition_id','user_id'];


	public function condition() {
        return $this->belongsTo('App\Models\Acc\Conditions', 'condition_id');
    }

}