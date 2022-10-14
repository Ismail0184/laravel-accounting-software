<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_countries';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'continent', 'short', 'code','user_id'];

}