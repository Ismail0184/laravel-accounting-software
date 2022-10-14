<?php namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository as Permission;
use App\Repositories\RoleRepository as Role;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

use App\Models\Lib\Languages;

class PermissionsController extends Controller {

	private $role;
	private $permission;

	public function __construct(Permission $permission, Role $role)
	{
		$this->permission = $permission;
		$this->role = $role;
	}

	public function index()
	{
		$permissions = $this->permission->paginate(9999);
        $langs = $this->language();
		return view('access.permissions.index', compact(['permissions','langs']));
	}

	public function create()
	{
	    $langs = $this->language();
		return view('access.permissions.create', compact('langs'));
	}

	public function store(Request $request)
	{
		$this->validate($request, array('name' => 'required', 'display_name' => 'required', 'route' => 'required'));

		$permission = $this->permission->create($request->all());

		$role = $this->role->findBy('name', 'super_admin');

		$role->perms()->sync([$permission->id], false);

		Flash::success('Permission successfully created');

		return redirect('/permissions');
	}

	public function edit($id)
	{
		$permission = $this->permission->find($id);
        $langs = $this->language();
		return view('access.permissions.edit', compact(['permission', 'langs']));
	}


	public function update(Request $request, $id)
	{
		$this->validate($request, array('name' => 'required', 'display_name' => 'required', 'route' => 'required'));

		$permission = $this->permission->find($id);
		$permission->update($request->all());

		Flash::success('Permission successfully updated');

		return redirect('/permissions');
	}

	public function destroy($id)
	{
		$this->permission->delete($id);

		Flash::success('Permission successfully deleted');

		return redirect('/permissions');
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