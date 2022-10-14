<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Clientlists extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_clientlists';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'group_name', 'product','user_id'];

}