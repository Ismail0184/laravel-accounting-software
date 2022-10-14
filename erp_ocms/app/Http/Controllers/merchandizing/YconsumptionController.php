<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Yconsumptions;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class YconsumptionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $yconsumptions = Yconsumptions::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $yconsumptions = $yconsumptions->where('user_id',Auth::id());
        }
        $yconsumptions = $yconsumptions->get();
		return view('merchandizing.yconsumption.index', compact(['langs', 'yconsumptions']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.yconsumption.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $yconsumption = $request->all();
        $yconsumption['user_id'] = Auth::id();
        Yconsumptions::create($yconsumption);
		return redirect('yconsumption');
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
		$yconsumption = Yconsumptions::findOrFail($id);
		return view('merchandizing.yconsumption.show', compact(['langs', 'yconsumption']));
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
		$yconsumption = Yconsumptions::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $yconsumption->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.yconsumption.edit', compact(['langs', 'yconsumption']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$yconsumption = Yconsumptions::findOrFail($id);
		$yconsumption->update($request->all());
		return redirect('yconsumption');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Yconsumptions::destroy($id);
		return redirect('yconsumption');
	}

}