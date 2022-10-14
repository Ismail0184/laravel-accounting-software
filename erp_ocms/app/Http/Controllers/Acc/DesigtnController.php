<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Desigtns;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class DesigtnController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$langs = Languages::lists('value', 'code');
        $desigtns = Desigtns::where('com_id',$com_id)->latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $desigtns = $desigtns->where('user_id',Auth::id());
        }
        $desigtns = $desigtns->get();
		return view('acc.desigtn.index', compact(['langs', 'desigtns']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('acc.desigtn.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

	    $desigtn = $request->all();
        $desigtn['user_id'] = Auth::id();
		$desigtn['com_id'] = $com_id;
        Desigtns::create($desigtn);
		return redirect('desigtn');
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
		$desigtn = Desigtns::findOrFail($id);
		return view('acc.desigtn.show', compact(['langs', 'desigtn']));
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
		$desigtn = Desigtns::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $desigtn->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.desigtn.edit', compact(['langs', 'desigtn']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$desigtn = Desigtns::findOrFail($id);
		$desigtn->update($request->all());
		return redirect('desigtn');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Desigtns::destroy($id);
		return redirect('desigtn');
	}

}