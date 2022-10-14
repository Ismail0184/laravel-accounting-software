<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Lctransfers;
use App\Models\Acc\Clients;
use App\Models\Acc\Lcinfos;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Currencies;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Auth;
use DB;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class LctransferController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$langs = Languages::lists('value', 'code');
        $lctransfers = Lctransfers::where('com_id',$com_id)->latest()->get();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $lctransfers = $lctransfers->where('user_id',Auth::id());
        }
		return view('acc.lctransfer.index', compact(['langs', 'lctransfers']));
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
		return view('acc.lctransfer.create', compact('langs', 'clients', 'lcinfos'));
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
		
		$lctransfer = $request->all();
        $lctransfer['user_id'] = Auth::id();
		$lctransfer['crateto'] = $lc_crateto;
		$lctransfer['com_id'] = $com_id;
        Lctransfers::create($lctransfer);
		return redirect('lctransfer');
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
		
        $client=Clients::where('com_id',$com_id)->Latest()->get();
		$clients=array(''=>'Select');
		foreach($client as $data):
			$clients[$data['id']]=$data['name'];
		endforeach;
		$coa=Acccoas::where('com_id',$com_id)->where('atype','Account')->Latest()->get();
		$acccoa=array(''=>'Select');
		foreach($coa as $data):
			$acccoa[$data['id']]=$data['name'];
		endforeach;
        $lcinfo=Lcinfos::where('com_id',$com_id)->Latest()->get();
		$lcinfos=array(''=>'Select');
		foreach($lcinfo as $data):
			$lcinfos[$data['id']]=$data['lcnumber'];
		endforeach;
		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
		foreach($currencys as $data):
			$currency[$data['id']]=$data['name'];
		endforeach;
		$user = User::latest()->get();
		$users['']="Select ...";
		foreach($user as $data):
			$users[$data['id']]=$data['name'];
		endforeach;
		$langs = Languages::lists('value', 'code');
		$lctransfer = Lctransfers::findOrFail($id);
		return view('acc.lctransfer.show', compact(['langs', 'lctransfer','clients','lcinfos','acccoa','currency','users']));
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
		$lctransfer = Lctransfers::findOrFail($id);
		return view('acc.lctransfer.edit', compact(['langs', 'lctransfer','clients','lcinfos']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$lctransfer = Lctransfers::findOrFail($id);
		$lctransfer->update($request->all());
		return redirect('lctransfer');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Lctransfers::destroy($id);
		return redirect('lctransfer');
	}
	public function report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $client=Clients::where('com_id',$com_id)->Latest()->get();
		$clients=array(''=>'Select');
		foreach($client as $data):
			$clients[$data['id']]=$data['name'];
		endforeach;

		$lctransfers = Lctransfers::where('com_id',$com_id)->latest()->get();
        $langs = Languages::lists('value', 'code');
		return view('acc.lctransfer.report', compact(['lctransfers', 'langs','clients']));
	}
	public function tranfilter(Request $request)
	{
		
		Session::put('traclient_id', $request->get('client_id'));
		Session::put('tradfrom', $request->get('dfrom'));
		Session::put('tradto', $request->get('dto'));
		
		return redirect('lctransfer/report');

	}
	
}