<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Marketingteams;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class MarketingteamController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $marketingteams = Marketingteams::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $marketingteams = $marketingteams->where('user_id',Auth::id());
        }
        $marketingteams = $marketingteams->get();
		return view('merchandizing.marketingteam.index', compact(['langs', 'marketingteams']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.marketingteam.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $marketingteam = $request->all();
        $marketingteam['user_id'] = Auth::id();
        Marketingteams::create($marketingteam);
		return redirect('marketingteam');
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
		$marketingteam = Marketingteams::findOrFail($id);
		return view('merchandizing.marketingteam.show', compact(['langs', 'marketingteam']));
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
		$marketingteam = Marketingteams::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $marketingteam->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.marketingteam.edit', compact(['langs', 'marketingteam']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$marketingteam = Marketingteams::findOrFail($id);
		$marketingteam->update($request->all());
		return redirect('marketingteam');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Marketingteams::destroy($id);
		return redirect('marketingteam');
	}

}