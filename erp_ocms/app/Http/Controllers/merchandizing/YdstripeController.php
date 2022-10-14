<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Ydstripes;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class YdstripeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $ydstripes = Ydstripes::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $ydstripes = $ydstripes->where('user_id',Auth::id());
        }
        $ydstripes = $ydstripes->get();
		return view('merchandizing.ydstripe.index', compact(['langs', 'ydstripes']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.ydstripe.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $ydstripe = $request->all();
        $ydstripe['user_id'] = Auth::id();
        Ydstripes::create($ydstripe);
		return redirect('ydstripe');
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
		$ydstripe = Ydstripes::findOrFail($id);
		return view('merchandizing.ydstripe.show', compact(['langs', 'ydstripe']));
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
		$ydstripe = Ydstripes::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $ydstripe->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.ydstripe.edit', compact(['langs', 'ydstripe']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$ydstripe = Ydstripes::findOrFail($id);
		$ydstripe->update($request->all());
		return redirect('ydstripe');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Ydstripes::destroy($id);
		return redirect('ydstripe');
	}

}