<?php namespace App\Models\merchandizing;

use Illuminate\Database\Eloquent\Model;

class Buyers extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'merch_buyers';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'agent', 'cperson', 'email', 'web', 'address', 'country_id', 'note','user_id'];

}