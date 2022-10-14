<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Lycraratios;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class LycraratioController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $lycraratios = Lycraratios::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $lycraratios = $lycraratios->where('user_id',Auth::id());
        }
        $lycraratios = $lycraratios->get();
		return view('merchandizing.lycraratio.index', compact(['langs', 'lycraratios']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.lycraratio.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $lycraratio = $request->all();
        $lycraratio['user_id'] = Auth::id();
        Lycraratios::create($lycraratio);
		return redirect('lycraratio');
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
		$lycraratio = Lycraratios::findOrFail($id);
		return view('merchandizing.lycraratio.show', compact(['langs', 'lycraratio']));
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
		$lycraratio = Lycraratios::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $lycraratio->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.lycraratio.edit', compact(['langs', 'lycraratio']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$lycraratio = Lycraratios::findOrFail($id);
		$lycraratio->update($request->all());
		return redirect('lycraratio');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Lycraratios::destroy($id);
		return redirect('lycraratio');
	}

}