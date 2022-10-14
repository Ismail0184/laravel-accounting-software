<?php namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use App\Repositories\Criteria\Role\RolesWithPermissions;
use App\Repositories\RoleRepository as Role;
use App\Repositories\PermissionRepository as Permission;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

use App\Models\Lib\Languages;
use Auth;

class RolesController extends Controller {

	private $role;
	private $permission;

	public function __construct(Role $role, Permission $permission)
	{
		$this->role = $role;
		$this->permission = $permission;
	}

	public function index()
	{
		$roles = $this->role->pushCriteria(new RolesWithPermissions())->paginate(9999);
        $langs = $this->language();
		return view('access.roles.index', compact(['roles','langs']));
	}

	public function create()
	{
		$permissions = $this->permission->all();
        $langs = $this->language();
        if(Auth::user()->hasRole('super_admin')) {
            $skip_permissions = array();
        } else {
            $skip_permissions = array(4, 9, 10, 11, 12, 13, 16, 17, 18, 19);
        }        
		return view('access.roles.create', compact(['permissions','langs', 'skip_permissions']));
	}

	public function store(Request $request)
	{

		$this->validate($request, array('name' => 'required', 'display_name' => 'required', 'level' => 'required|unique:roles'));


		$role = $this->role->create($request->all());

		$role->savePermissions($request->get('perms'));

		Flash::success('Role successfully created');

		return redirect('/roles');
	}

	public function edit($id)
	{
		$role = $this->role->find($id);
        $langs = $this->language();
		if($role->id == 1)
		{
			abort(403);
		}
		$permissions = $this->permission->all();
		$rolePerms = $role->perms();
        if(Auth::user()->hasRole('super_admin')) {
            $skip_permissions = array();
        } else {
            $skip_permissions = array(4, 9, 10, 11, 12, 13, 16, 17, 18, 19);
        }        
		return view('access.roles.edit', compact('role', 'permissions', 'rolePerms', 'langs', 'skip_permissions'));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, array('name' => 'required', 'display_name' => 'required', 'level' => 'required'));

		$role = $this->role->find($id);
		$role->update($request->all());

		$role->savePermissions($request->get('perms'));

		Flash::success('Role successfully updated');

		return redirect('/roles');
	}

	public function destroy($id)
	{
		if($id == 1)
		{
			abort(403);
		}

		$this->role->delete($id);

		Flash::success('Role successfully deleted');

		return redirect('/roles');
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