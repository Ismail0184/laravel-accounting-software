<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\Criteria\User\UsersWithRoles;
use App\Repositories\UserRepository as User;
use App\Repositories\RoleRepository as Role;
use Laracasts\Flash\Flash;

use App\Models\Lib\Languages;
use Auth;
use App\Models\Lib\Hrm\Depts;
use App\Models\Lib\Hrm\Companies;

class UsersController extends Controller {

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @param User $user
	 * @param Role $role
	 */
	public function __construct(User $user, Role $role)
	{
		$this->user = $user;
		$this->role = $role;
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$users = $this->user->pushCriteria(new UsersWithRoles())->paginate(9999);
        $langs = Languages::lists('value', 'code');
		return view('users.index', compact(['users', 'langs']));
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		$roles = $this->role->all();
        $langs = Languages::lists('value', 'code');
        if(Auth::user()->hasRole('super_admin')) {
            $skip_role = array();
        } else {
            $skip_role = array(1);
        }        
        $depts_data = Depts::orderBy('name', 'asc')->get();        
        $departments = $this->dropdown_array($depts_data);
        $companies = Companies::all();
		return view('users.create', compact(['roles', 'langs', 'skip_role', 'departments', 'companies']));
	}

	/**
	 * @param CreateUserRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(CreateUserRequest $request)
	{
		$user = $this->user->create($request->all());

		if($request->get('role'))
		{
			$user->roles()->sync($request->get('role'));
		}
		else
		{
			$user->roles()->sync([]);
		}
        
		if($request->get('company'))
		{
			$user->companies()->sync($request->get('company'));
		}
		else
		{
			$user->companies()->sync([]);
		}

		Flash::success('User successfully created');

		return redirect('/users');
	}

	/**
	 * @param $id
	 *
	 * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$user = $this->user->find($id);
		$roles = $this->role->all();
		$userRoles = $user->roles();
        $langs = Languages::lists('value', 'code');
        if($user->hasRole('super_admin') && !Auth::user()->hasRole('super_admin')) {
            abort(403);
        }
        if(Auth::user()->hasRole('super_admin')) {
            $skip_role = array();
        } else {
            $skip_role = array(1);
        }
        $depts_data = Depts::orderBy('name', 'asc')->get();        
        $departments = $this->dropdown_array($depts_data);
        $companies = Companies::all();
        $userCompanies = $user->companies(); 
		return view('users.edit', compact('user', 'roles', 'userRoles', 'userCompanies', 'langs', 'skip_role', 'departments', 'companies'));
	}

	/**
	 * @param $id
	 * @param UpdateUserRequest $request
	 */
	public function update(UpdateUserRequest $request, $id)
	{
		$user = $this->user->find($id);
        if($user->hasRole('super_admin') && !Auth::user()->hasRole('super_admin')) {
            abort(403);
        }
		$user->name = $request->get('name');
		$user->email = $request->get('email');
		$user->dept_id = $request->get('dept_id');
		$user->default_company = $request->get('default_company');
		if($request->get('password'))
		{
			$user->password = $request->get('password');
		}
		$user->save();

		if($request->get('role'))
		{
			$user->roles()->sync($request->get('role'));
		}
		else
		{
			$user->roles()->sync([]);
		}
        
		if($request->get('company'))
		{
			$user->companies()->sync($request->get('company'));
		}
		else
		{
			$user->companies()->sync([]);
		}

		Flash::success('User successfully updated');

		return redirect('/users');
	}

	/**
	 * @param $id
	 */
	public function destroy($id)
	{
	    $user = $this->user->find($id);
        if($user->hasRole('super_admin') && !Auth::user()->hasRole('super_admin')) {
            abort(403);
        }
		$this->user->delete($id);

		Flash::success('User successfully deleted');

		return redirect('/users');
	}

}