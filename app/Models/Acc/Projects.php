<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_projects';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'location', 'cost', 'pdate', 'sdate', 'fdate', 'com_id', 'user_id'];

}