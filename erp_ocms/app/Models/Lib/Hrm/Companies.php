<?php namespace App\Models\Lib\Hrm;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Companies extends Model  {
    
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lib_companies';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'abbreviation', 'user_id'];

	/**
	 * The attributes use for soft delete.
	 *
	 * @var timestamp
	 */
    protected $dates = ['deleted_at'];   
    
    /**
     * User::users()
     * 
     * @return
     */
    public function users() {
        return $this->belongsToMany('App\User', 'companies_user');
    }           

}