<?php namespace App\Models\merchandizing;

use Illuminate\Database\Eloquent\Model;

class Gsms extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'merch_gsms';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','user_id'];

}