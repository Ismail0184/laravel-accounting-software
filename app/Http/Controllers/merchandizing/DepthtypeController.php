<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Depthtypes;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class DepthtypeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $depthtypes = Depthtypes::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $depthtypes = $depthtypes->where('user_id',Auth::id());
        }
        $depthtypes = $depthtypes->get();
		return view('merchandizing.depthtype.index', compact(['langs', 'depthtypes']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.depthtype.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $depthtype = $request->all();
        $depthtype['user_id'] = Auth::id();
        Depthtypes::create($depthtype);
		return redirect('depthtype');
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
		$depthtype = Depthtypes::findOrFail($id);
		return view('merchandizing.depthtype.show', compact(['langs', 'depthtype']));
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
		$depthtype = Depthtypes::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $depthtype->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.depthtype.edit', compact(['langs', 'depthtype']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$depthtype = Depthtypes::findOrFail($id);
		$depthtype->update($request->all());
		return redirect('depthtype');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Depthtypes::destroy($id);
		return redirect('depthtype');
	}

}