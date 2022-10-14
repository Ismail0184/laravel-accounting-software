<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Reconciliations extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_reconciliations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['acc_id', 'tdate', 'amount', 'tranwith_id', 'note', 'ttype', 'com_id','user_id'];

}