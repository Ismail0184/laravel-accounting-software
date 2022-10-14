<?php namespace App\Models\Lib;

use Illuminate\Database\Eloquent\Model;

class Languages extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lib_languages';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'value','model'];

}