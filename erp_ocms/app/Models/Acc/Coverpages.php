<?php namespace App\Models\Acc;

use Illuminate\Database\Eloquent\Model;

class Coverpages extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'acc_coverpages';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','header','header_details', 'footer', 'mtitle', 'subtitle', 'estyear', 'founder', 'breif','user_id'];

}