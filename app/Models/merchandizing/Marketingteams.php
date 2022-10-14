<?php namespace App\Models\merchandizing;

use Illuminate\Database\Eloquent\Model;

class Marketingteams extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'merch_marketingteams';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'designation', 'address', 'mobile', 'email', 'note','active','user_id'];

}