<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Coadetails extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_coadetails';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'acc_id','contact', 'address1', 'address2', 'email', 'phone', 'accountGroup_id', 'businessN', 'com_id', 'user_id'];

}