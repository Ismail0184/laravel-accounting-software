<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, EntrustUserTrait, SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
    
    protected $dates = ['deleted_at'];

	/**
	 * @param $value
	 */
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
	}

	/**
	 * @return mixed
	 */
	public function getLevelMax()
	{
		$roles = [];
		foreach($this->roles as $role)
		{
			$roles[] = $role->level;
		}

		return max($roles);
	}

    /**
     * Depts::department()
     * 
     * @return
     */
    public function department() {
        return $this->belongsTo('App\Models\Lib\Hrm\Depts', 'dept_id');
    }   
    
    /**
     * Companies::companies()
     * 
     * @return
     */
    public function companies() {
        return $this->belongsToMany('App\Models\Lib\Hrm\Companies');
    }   
    
    /**
     * Companies::company()
     * 
     * @return
     */
    public function company() {
        return $this->belongsTo('App\Models\Lib\Hrm\Companies', 'default_company');
    }  

}
