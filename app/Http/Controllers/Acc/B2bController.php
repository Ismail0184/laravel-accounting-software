<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\B2bs;
use App\Models\Acc\Clients;
use App\Models\Acc\Lcinfos;
use App\Models\Acc\Countries;
use App\Models\Acc\Currencies;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Acccoas;
use App\User;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class B2bController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

		$langs = Languages::lists('value', 'code');
        $b2bs = B2bs::where('com_id',$com_id)->latest()->get();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $b2bs = $b2bs->where('user_id',Auth::id());
        }
		return view('acc.b2b.index', compact(['langs', 'b2bs']));
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
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
        $client=Clients::where('com_id',$com_id)->Latest()->get();
		$clients=array(''=>'Select');
		foreach($client as $data):
			$clients[$data['id']]=$data['name'];
		endforeach;
        $lcinfo=Lcinfos::where('com_id',$com_id)->Latest()->get();
		$lcinfos=array(''=>'Select');
		foreach($lcinfo as $data):
			$lcinfos[$data['id']]=$data['lcnumber'];
		endforeach;
		$langs = Languages::lists('value', 'code');
		return view('acc.b2b.create', compact('langs','clients','lcinfos','acccoa'));
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
		$lc=DB::table('acc_lcinfos')->where('id',$request->get('lc_id'))->first();
		$lc_crateto=''; isset($lc) && $lc->id >0 ? $lc_crateto=$lc->crateto : $lc_crateto='';

	    $b2b = $request->all();
        $b2b['user_id'] = Auth::id();
		$lctransfer['crateto'] = $lc_crateto;
		$b2b['com_id'] = $com_id;
        B2bs::create($b2b);
		return redirect('b2b');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$countrys = Countries::latest()->get();
		$country['']="Select ...";
		foreach($countrys as $data):
			$country[$data['id']]=$data['name'];
		endforeach;
		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
		foreach($currencys as $data):
			$currency[$data['id']]=$data['name'];
		endforeach;
		
		$unit = AccUnits::latest()->get();
		$units['']="Select ...";
		foreach($unit as $data):
			$units[$data['id']]=$data['name'];
		endforeach;
		
		$user = User::latest()->get();
		$users['']="Select ...";
		foreach($user as $data):
			$users[$data['id']]=$data['name'];
		endforeach;
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$langs = Languages::lists('value', 'code');
		$b2b = B2bs::findOrFail($id);
		return view('acc.b2b.show', compact(['langs', 'b2b','buyers', 'country', 'currency', 'units','acccoa','users']));
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

		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 

        $client=Clients::where('com_id',$com_id)->Latest()->get();
		$clients=array(''=>'Select');
		foreach($client as $data):
			$clients[$data['id']]=$data['name'];
		endforeach;
        $lcinfo=Lcinfos::where('com_id',$com_id)->Latest()->get();
		$lcinfos=array(''=>'Select');
		foreach($lcinfo as $data):
			$lcinfos[$data['id']]=$data['lcnumber'];
		endforeach;
        $langs = Languages::lists('value', 'code');
		$b2b = B2bs::findOrFail($id);
		return view('acc.b2b.edit', compact(['langs', 'b2b','clients','lcinfos','acccoa']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$b2b = B2bs::findOrFail($id);
		$b2b->update($request->all());
		return redirect('b2b');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		B2bs::destroy($id);
		return redirect('b2b');
	}
	public function report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $lcinfo=Lcinfos::where('com_id',$com_id)->Latest()->get();
		$lcinfos=array(''=>'Select');
		foreach($lcinfo as $data):
			$lcinfos[$data['id']]=$data['lcnumber'];
		endforeach;

        $client=Clients::where('com_id',$com_id)->Latest()->get();
		$clients=array(''=>'Select');
		foreach($client as $data):
			$clients[$data['id']]=$data['name'];
		endforeach;

		$b2bs = B2bs::where('com_id',$com_id)->latest()->get();
        $langs = Languages::lists('value', 'code');
		return view('acc.b2b.report', compact(['b2bs', 'langs','clients','lcinfos']));
	}
	public function b2bfilter(Request $request)
	{
		
		Session::put('b2blc_id', $request->get('lc_id'));
		Session::put('b2bclient_id', $request->get('client_id'));
		
		return redirect('b2b/report');

	}
	
}