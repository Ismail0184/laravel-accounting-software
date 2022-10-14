<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Lctransfers extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_lctransfers';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['client_id', 'lc_id', 'tlcdate', 'com_rate', 'camount','crateto', 'bank','note','com_id','user_id'];

}