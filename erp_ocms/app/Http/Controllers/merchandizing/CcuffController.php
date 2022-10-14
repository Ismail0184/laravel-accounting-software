<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Ccuffs;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class CcuffController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $ccuffs = Ccuffs::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $ccuffs = $ccuffs->where('user_id',Auth::id());
        }
        $ccuffs = $ccuffs->get();
		return view('merchandizing.ccuff.index', compact(['langs', 'ccuffs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.ccuff.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $ccuff = $request->all();
        $ccuff['user_id'] = Auth::id();
        Ccuffs::create($ccuff);
		return redirect('ccuff');
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
		$ccuff = Ccuffs::findOrFail($id);
		return view('merchandizing.ccuff.show', compact(['langs', 'ccuff']));
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
		$ccuff = Ccuffs::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $ccuff->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.ccuff.edit', compact(['langs', 'ccuff']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$ccuff = Ccuffs::findOrFail($id);
		$ccuff->update($request->all());
		return redirect('ccuff');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Ccuffs::destroy($id);
		return redirect('ccuff');
	}

}