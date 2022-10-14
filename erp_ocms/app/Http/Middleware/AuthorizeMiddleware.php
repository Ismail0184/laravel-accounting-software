<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\PermissionRepository as Permission;

class AuthorizeMiddleware {

	public function __construct(Guard $auth, Permission $permission)
	{
		$this->auth = $auth;
		$this->permission = $permission;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = $this->auth->user();

		$permissions = $this->permission->all();
        
        $route_action = $request->route()->getActionName();
        
        $route_function = substr(strrchr($route_action, '\\'), 1);
        
		foreach($permissions as $permission)
		{
			if( ! $user->can($permission->name) && $permission->route == $route_function)
			{
				abort(403);
			}
		}

		return $next($request);
	}

}
