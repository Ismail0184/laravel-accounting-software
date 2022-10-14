<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_topics';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'page_id','user_id'];

}