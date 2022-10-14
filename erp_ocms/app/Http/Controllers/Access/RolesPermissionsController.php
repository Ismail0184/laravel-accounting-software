<?php namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use App\Repositories\Criteria\Role\RoleLowerOrEqualToCurrentUser;
use App\Repositories\RoleRepository as Role;
use App\Repositories\PermissionRepository as Permission;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

use App\Models\Lib\Languages;

class RolesPermissionsController extends Controller {

	/**
	 * @var Role
	 */
	private $role;
	/**
	 * @var Permission
	 */
	private $permission;

	/**
	 * @param Role $role
	 * @param Permission $permission
	 * @param Guard $auth
	 */
	public function __construct(Role $role, Permission $permission, Guard $auth)
	{
		$this->role = $role;
		$this->auth = $auth;
		$this->permission = $permission;
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$roles = $this->role->pushCriteria(new RoleLowerOrEqualToCurrentUser($this->auth->user()))->all();
		$permissions = $this->permission->all();
        $langs = $this->language();
		return view('access.roles_permissions.index', compact('roles', 'permissions', 'langs'));
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request)
	{
		$input = $request->all();

		$roles = $this->role->all();

		$levelMaxLoggedUser = $this->auth->user()->getLevelMax();

		foreach($roles as $role)
		{
			if( $role->level <= $levelMaxLoggedUser)
			{
				$permissions_sync = isset($input['roles'][$role->id]) ? $input['roles'][$role->id]['permissions'] : [];

				$role->perms()->sync($permissions_sync);
			}
		}

		Flash::success('Permissions successfully updated');

		return redirect('/role_permission');
	}
    
	/**
	 * Display a listing of the languages code.
	 *
	 * @return Response
	 */
    public function language()
    {        
        $languages = Languages::latest()->get();
        foreach($languages as $lang) {
            $langs[$lang->code] = $lang->value;
        }
        return $langs;
    }

}