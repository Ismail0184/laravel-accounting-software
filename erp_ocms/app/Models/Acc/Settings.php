<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_settings';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['gname', 'ccount', 'onem', 'm1', 'm2', 'm3', 'm4', 'm5', 'm6', 'm7', 'm8','m9','m10', 'com_id', 'user_id'];

}