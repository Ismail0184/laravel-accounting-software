<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Fletters extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_fletters';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'client', 'qdate', 'attention', 'designtion', 'address', 'subject', 'ref', 'lbody', 'conclusion', 'sign_id','user_id'];


	public function sign() {
        return $this->belongsTo('App\Models\Acc\Signatures', 'sign_id');
    }

}