<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Incoterms;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class IncotermController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $incoterms = Incoterms::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $incoterms = $incoterms->where('user_id',Auth::id());
        }
        $incoterms = $incoterms->get();
		return view('merchandizing.incoterm.index', compact(['langs', 'incoterms']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.incoterm.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $incoterm = $request->all();
        $incoterm['user_id'] = Auth::id();
        Incoterms::create($incoterm);
		return redirect('incoterm');
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
		$incoterm = Incoterms::findOrFail($id);
		return view('merchandizing.incoterm.show', compact(['langs', 'incoterm']));
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
		$incoterm = Incoterms::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $incoterm->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.incoterm.edit', compact(['langs', 'incoterm']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$incoterm = Incoterms::findOrFail($id);
		$incoterm->update($request->all());
		return redirect('incoterm');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Incoterms::destroy($id);
		return redirect('incoterm');
	}

}