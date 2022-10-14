<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Coverpages;
use App\Models\Acc\Companies;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class CoverpageController extends Controller {

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
        $coverpages = Coverpages::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $coverpages = $coverpages->where('user_id',Auth::id());
        }
        $coverpages = $coverpages->get();
		return view('acc.coverpage.index', compact(['langs', 'coverpages','company']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('acc.coverpage.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $coverpage = $request->all();
        $coverpage['user_id'] = Auth::id();
        Coverpages::create($coverpage);
		return redirect('coverpage');
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
		$coverpage = Coverpages::findOrFail($id);
		return view('acc.coverpage.show', compact(['langs', 'coverpage']));
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
		$coverpage = Coverpages::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $coverpage->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.coverpage.edit', compact(['langs', 'coverpage']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$coverpage = Coverpages::findOrFail($id);
		$coverpage->update($request->all());
		return redirect('coverpage');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Coverpages::destroy($id);
		return redirect('coverpage');
	}

}