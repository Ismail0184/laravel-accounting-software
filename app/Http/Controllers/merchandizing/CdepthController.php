<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Cdepths;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class CdepthController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $cdepths = Cdepths::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $cdepths = $cdepths->where('user_id',Auth::id());
        }
        $cdepths = $cdepths->get();
		return view('merchandizing.cdepth.index', compact(['langs', 'cdepths']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.cdepth.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $cdepth = $request->all();
        $cdepth['user_id'] = Auth::id();
        Cdepths::create($cdepth);
		return redirect('cdepth');
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
		$cdepth = Cdepths::findOrFail($id);
		return view('merchandizing.cdepth.show', compact(['langs', 'cdepth']));
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
		$cdepth = Cdepths::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $cdepth->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.cdepth.edit', compact(['langs', 'cdepth']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$cdepth = Cdepths::findOrFail($id);
		$cdepth->update($request->all());
		return redirect('cdepth');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Cdepths::destroy($id);
		return redirect('cdepth');
	}

}