<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Pomasters;
use App\Models\merchandizing\Podetails;
use App\Models\merchandizing\Orders;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Companies;
use App\Models\merchandizing\Ports;
use App\Models\merchandizing\Bdtypes;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use Session; 
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class PomasterController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$company = Companies::where('id', $com_id)->first();
		Session::has('jobno') ?  $jobno=Session::get('jobno') : $jobno='';
		Session::has('pono') ?  $pono=Session::get('pono') : $pono='';

		$langs = Languages::lists('value', 'code');
        $pomasters = Pomasters::where('com_id',$com_id)->where('jobno',$jobno)->latest();
		$pono!='' ? Pomasters::where('com_id',$com_id)->where('pono',$pono)->latest() : '';
		
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $pomasters = $pomasters->where('user_id',Auth::id());
        }
        $pomasters = $pomasters->get();
		return view('merchandizing.pomaster.index', compact(['langs', 'pomasters','company']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
 		$order=Orders::Latest()->get();
		$orders=array(''=>'Select ...');
		foreach($order as $data):
			$orders[$data['id']]=$data['orderno'];
		endforeach;
 		$port=Ports::Latest()->get();
		$ports=array(''=>'Select ...');
		foreach($port as $data):
			$ports[$data['id']]=$data['name'];
		endforeach;

		$unit=AccUnits::Latest()->get();
		$units=array(''=>'Select ...');
		foreach($unit as $data):
			$units[$data['id']]=$data['name'];
		endforeach;

       $langs = Languages::lists('value', 'code');
		return view('merchandizing.pomaster.create', compact('langs','orders','units','ports'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		Session::has('jobno') ?  $jobno=Session::get('jobno') : $jobno='';

	    $pomaster = $request->all();
        $pomaster['user_id'] = Auth::id();
		$pomaster['com_id'] = $com_id;
		$pomaster['jobno'] = $jobno;
        Pomasters::create($pomaster);
		$pom=DB::table('merch_pomasters')->where('com_id',$com_id)->where('jobno',$jobno)->where('pono',$request->get('pono'))->first();
		return redirect('pomaster/'.$pom->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$company = Companies::where('id', $com_id)->first();

 		$port=Ports::Latest()->get();
		$ports=array(''=>'Select ...');
		foreach($port as $data):
			$ports[$data['id']]=$data['name'];
		endforeach;
		$breakdown_id=Podetails::where('pm_id',$id)->max('breakdown_id')+1;
        $langs = Languages::lists('value', 'code');
		$pomaster = Pomasters::findOrFail($id);
		$bdtype=Bdtypes::lists('name', 'id'); //Bdtypes::Latest();
		$podetail_port = Podetails::select('pm_id', 'port_id')->where('jobno',$pomaster->jobno)->groupBy('port_id')->Oldest()->get();
		return view('merchandizing.pomaster.show', compact(['langs', 'pomaster','ports','podetail_port','company','bdtype','breakdown_id']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
 		$order=Orders::Latest()->get();
		$orders=array(''=>'Select ...');
		foreach($order as $data):
			$orders[$data['id']]=$data['orderno'];
		endforeach;
 		$port=Ports::Latest()->get();
		$ports=array(''=>'Select ...');
		foreach($port as $data):
			$ports[$data['id']]=$data['name'];
		endforeach;

		$unit=AccUnits::Latest()->get();
		$units=array(''=>'Select ...');
		foreach($unit as $data):
			$units[$data['id']]=$data['name'];
		endforeach;

        $langs = Languages::lists('value', 'code');
		$pomaster = Pomasters::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $pomaster->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.pomaster.edit', compact(['langs', 'pomaster','orders','ports','units']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$pomaster = Pomasters::findOrFail($id);
		$pomaster->update($request->all());
		return redirect('pomaster');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Pomasters::destroy($id);
		return redirect('pomaster');
	}
	public function find(Request $request)
	{
		$request->get('jobno')!='' ? Session::put('jobno',$request->get('jobno')) :'';
		Session::put('pono',$request->get('pono'));
		return redirect('pomaster');
	}

}