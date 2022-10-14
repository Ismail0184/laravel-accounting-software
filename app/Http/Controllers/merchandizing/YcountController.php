<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Ycounts;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class YcountController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $ycounts = Ycounts::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $ycounts = $ycounts->where('user_id',Auth::id());
        }
        $ycounts = $ycounts->get();
		return view('merchandizing.ycount.index', compact(['langs', 'ycounts']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.ycount.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $ycount = $request->all();
        $ycount['user_id'] = Auth::id();
        Ycounts::create($ycount);
		return redirect('ycount');
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
		$ycount = Ycounts::findOrFail($id);
		return view('merchandizing.ycount.show', compact(['langs', 'ycount']));
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
		$ycount = Ycounts::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $ycount->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.ycount.edit', compact(['langs', 'ycount']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$ycount = Ycounts::findOrFail($id);
		$ycount->update($request->all());
		return redirect('ycount');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Ycounts::destroy($id);
		return redirect('ycount');
	}

}