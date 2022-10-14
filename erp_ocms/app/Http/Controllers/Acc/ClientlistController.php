<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Clientlists;
use App\Models\Acc\Companies;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class ClientlistController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$company=Companies::where('id',$com_id)->first();	

		$langs = Languages::lists('value', 'code');
        $clientlists = Clientlists::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $clientlists = $clientlists->where('user_id',Auth::id());
        }
        $clientlists = $clientlists->get();
		return view('acc.clientlist.index', compact(['langs', 'clientlists','company']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('acc.clientlist.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $clientlist = $request->all();
        $clientlist['user_id'] = Auth::id();
        Clientlists::create($clientlist);
		return redirect('clientlist');
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
		$clientlist = Clientlists::findOrFail($id);
		return view('acc.clientlist.show', compact(['langs', 'clientlist']));
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
		$clientlist = Clientlists::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $clientlist->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.clientlist.edit', compact(['langs', 'clientlist']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$clientlist = Clientlists::findOrFail($id);
		$clientlist->update($request->all());
		return redirect('clientlist');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Clientlists::destroy($id);
		return redirect('clientlist');
	}

}