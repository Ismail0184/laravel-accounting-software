<?php namespace App\Models\merchandizing;

use Illuminate\Database\Eloquent\Model;

class Yconsumptions extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'merch_yconsumptions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','user_id'];

}