<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Subheads extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_subheads';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'com_id','user_id'];

}