<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Cprocesses;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class CprocessController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $cprocesses = Cprocesses::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $cprocesses = $cprocesses->where('user_id',Auth::id());
        }
        $cprocesses = $cprocesses->get();
		return view('merchandizing.cprocess.index', compact(['langs', 'cprocesses']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.cprocess.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $cprocess = $request->all();
        $cprocess['user_id'] = Auth::id();
        Cprocesses::create($cprocess);
		return redirect('cprocess');
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
		$cprocess = Cprocesses::findOrFail($id);
		return view('merchandizing.cprocess.show', compact(['langs', 'cprocess']));
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
		$cprocess = Cprocesses::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $cprocess->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.cprocess.edit', compact(['langs', 'cprocess']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$cprocess = Cprocesses::findOrFail($id);
		$cprocess->update($request->all());
		return redirect('cprocess');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Cprocesses::destroy($id);
		return redirect('cprocess');
	}

}