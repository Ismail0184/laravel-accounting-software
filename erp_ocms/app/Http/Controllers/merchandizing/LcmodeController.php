<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Lcmodes;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class LcmodeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $lcmodes = Lcmodes::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $lcmodes = $lcmodes->where('user_id',Auth::id());
        }
        $lcmodes = $lcmodes->get();
		return view('merchandizing.lcmode.index', compact(['langs', 'lcmodes']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.lcmode.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $lcmode = $request->all();
        $lcmode['user_id'] = Auth::id();
        Lcmodes::create($lcmode);
		return redirect('lcmode');
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
		$lcmode = Lcmodes::findOrFail($id);
		return view('merchandizing.lcmode.show', compact(['langs', 'lcmode']));
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
		$lcmode = Lcmodes::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $lcmode->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.lcmode.edit', compact(['langs', 'lcmode']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$lcmode = Lcmodes::findOrFail($id);
		$lcmode->update($request->all());
		return redirect('lcmode');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Lcmodes::destroy($id);
		return redirect('lcmode');
	}

}