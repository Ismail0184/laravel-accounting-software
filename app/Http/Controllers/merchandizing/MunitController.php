<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Munits;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class MunitController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $munits = Munits::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $munits = $munits->where('user_id',Auth::id());
        }
        $munits = $munits->get();
		return view('merchandizing.munit.index', compact(['langs', 'munits']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.munit.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $munit = $request->all();
        $munit['user_id'] = Auth::id();
        Munits::create($munit);
		return redirect('munit');
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
		$munit = Munits::findOrFail($id);
		return view('merchandizing.munit.show', compact(['langs', 'munit']));
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
		$munit = Munits::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $munit->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.munit.edit', compact(['langs', 'munit']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$munit = Munits::findOrFail($id);
		$munit->update($request->all());
		return redirect('munit');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Munits::destroy($id);
		return redirect('munit');
	}

}