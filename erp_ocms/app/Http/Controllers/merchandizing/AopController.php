<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Aops;
use App\Models\Permission;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class AopController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $aops = Aops::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $aops = $aops->where('user_id',Auth::id());
        }
        $aops = $aops->get();
		return view('merchandizing.aop.index', compact(['langs', 'aops']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.aop.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $aop = $request->all();
        $aop['user_id'] = Auth::id();
        Aops::create($aop);
		return redirect('aop');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $langs = Languages::lists('value', 'code');
		$aop = Aops::findOrFail($id);
		return view('merchandizing.aop.show', compact(['langs', 'aop']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $langs = Languages::lists('value', 'code');
		$aop = Aops::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $aop->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.aop.edit', compact(['langs', 'aop']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$aop = Aops::findOrFail($id);
		$aop->update($request->all());
		return redirect('aop');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Aops::destroy($id);
		return redirect('aop');
	}

	public function menu($id)
	{
        $data=array(
		'name'	=> 'create_'.$id,
		'display_name'	=> 'Create '.$id,
		'route'	=> $id.'/create'
		);
		Permission::create($data);
		        $data=array(
		'name'	=> 'update_'.$id,
		'display_name'	=> 'Update '.$id,
		'route'	=> $id.'/{'.$id.'}/edit'
		);
		Permission::create($data);
        $data=array(
		'name'	=> 'delete_'.$id,
		'display_name'	=> 'Delete '.$id,
		'route'	=> $id.'/{'.$id.'}'
		);
		Permission::create($data);
        $data=array(
		'name'	=> 'manage_'.$id,
		'display_name'	=> 'Manage '.$id,
		'route'	=> $id
		);
		Permission::create($data);

		$langs = Languages::lists('value', 'code');
		return view('merchandizing.aop.menu', compact(['langs', 'aop']));
	}

}