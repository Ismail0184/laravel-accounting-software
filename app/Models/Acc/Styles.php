<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Styles extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_styles';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'ordernumber', 'stylevalue', 'styleqty', 'unit_id', 'description', 'com_id','user_id'];

}