<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Signatures extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_signatures';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'designation', 'mobile', 'email', 'website','user_id'];

}