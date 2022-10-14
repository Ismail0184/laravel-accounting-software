<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Pplannings extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_pplannings';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['pro_id', 'segment', 'stdate', 'cldate', 'bamount', 'group_id', 'gtype', 'com_id', 'user_id'];

}