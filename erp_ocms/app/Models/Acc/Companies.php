<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_companies';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'oaddress', 'faddress2', 'mobile', 'phone', 'fax', 'email', 'web', 'stablish', 'businessn', 'md', 'chair', 'd1', 'd2', 'd3', 'ctype','user_id'];

}