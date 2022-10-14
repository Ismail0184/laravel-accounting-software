<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Uoutlets;
use App\Models\Acc\Outlets;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use App\User;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class UoutletController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

       	$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = Languages::lists('value', 'code');
        $uoutlets = Uoutlets::where('com_id',$com_id)->latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $uoutlets = $uoutlets->where('user_id',Auth::id());
        }
        $uoutlets = $uoutlets->get();
		return view('acc.uoutlet.index', compact(['langs', 'uoutlets','users']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

       	$outlet = Outlets::where('com_id',$com_id)->latest()->get();
		$outlets['']="Select ...";
        foreach($outlet as $data) {
            $outlets[$data['id']] = $data['name'];
        }
       	$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
        $langs = Languages::lists('value', 'code');
		return view('acc.uoutlet.create', compact('langs','users','outlets'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		$find=DB::table('acc_uoutlets')->where('users_id',Auth::id())
		->where('olt_id',$request->get('olt_id'))->first();
		if(isset($find) && $find->id > 0):
		Flash::success('Duplicate Connection');
		else:

	    $uoutlet = $request->all();
        $uoutlet['user_id'] = Auth::id();
		$uoutlet['com_id'] = $com_id;
        Uoutlets::create($uoutlet);
		endif;
		return redirect('uoutlet');
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
		$uoutlet = Uoutlets::findOrFail($id);
		return view('acc.uoutlet.show', compact(['langs', 'uoutlet']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

       	$outlet = Outlets::where('com_id',$com_id)->latest()->get();
		$outlets['']="Select ...";
        foreach($outlet as $data) {
            $outlets[$data['id']] = $data['name'];
        }
       	$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
        $langs = Languages::lists('value', 'code');
		$uoutlet = Uoutlets::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $uoutlet->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.uoutlet.edit', compact(['langs', 'uoutlet','users','outlets']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$uoutlet = Uoutlets::findOrFail($id);
		$uoutlet->update($request->all());
		return redirect('uoutlet');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Uoutlets::destroy($id);
		return redirect('uoutlet');
	}
	

}