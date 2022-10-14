<?php namespace App\Models\merchandizing;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'merch_bookings';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['jobno','pono','booking','com_id','user_id'];

}