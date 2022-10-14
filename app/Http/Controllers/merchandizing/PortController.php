<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Ports;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class PortController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $ports = Ports::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $ports = $ports->where('user_id',Auth::id());
        }
        $ports = $ports->get();
		return view('merchandizing.port.index', compact(['langs', 'ports']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.port.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $port = $request->all();
        $port['user_id'] = Auth::id();
        Ports::create($port);
		return redirect('port');
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
		$port = Ports::findOrFail($id);
		return view('merchandizing.port.show', compact(['langs', 'port']));
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
		$port = Ports::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $port->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.port.edit', compact(['langs', 'port']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$port = Ports::findOrFail($id);
		$port->update($request->all());
		return redirect('port');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Ports::destroy($id);
		return redirect('port');
	}

}