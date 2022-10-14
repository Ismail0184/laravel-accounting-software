<?php namespace App\Models\merchandizing;

use Illuminate\Database\Eloquent\Model;

class Ports extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'merch_ports';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','user_id'];
	


}