<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Fabricmasters;
use App\Models\merchandizing\Fabricdetails;
use App\Models\merchandizing\Orders;
use App\Models\merchandizing\Gtypes;
use App\Models\merchandizing\Pogarments;
use App\Models\merchandizing\Yconsumptions;
use App\Models\merchandizing\Dias;
use App\Models\merchandizing\Diatypes;
use App\Models\merchandizing\Gsms;
use App\Models\merchandizing\Ftypes;
use App\Models\merchandizing\Munits;
use App\Models\merchandizing\Ytypes;
use App\Models\merchandizing\Ycounts;
use App\Models\merchandizing\Ydstripes;
use App\Models\merchandizing\Washings;
use App\Models\merchandizing\Ccuffs;
use App\Models\merchandizing\Aops;
use App\Models\merchandizing\Lycraratios;
use App\Models\merchandizing\Cprocesses;
use App\Models\merchandizing\Structures;
use App\Models\Acc\Companies;
use App\Models\merchandizing\Pomasters;
use App\Models\merchandizing\Bookings;
use App\Models\merchandizing\Podetails;
use App\Models\merchandizing\Finishings;


use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class FabricdetailController extends Controller {

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

		$langs = Languages::lists('value', 'code');
        $fabricdetails = Fabricdetails::where('com_id',$com_id)->where('jobno',$jobno)->latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $fabricdetails = $fabricdetails->where('user_id',Auth::id());
        }
        $fabricdetails = $fabricdetails->get();
		return view('merchandizing.fabricdetail.index', compact(['langs', 'fabricdetails']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.fabricdetail.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
	    if($request->get('flag')=='modal'):
			$colors=$request->get('color');
			$diatype_id=$request->get('diatype_id');
			$dia_id=$request->get('dia_id');
			$dmu_id=$request->get('dmu_id');
			$gsm_id=$request->get('gsm_id');
			$ftype_id=$request->get('ftype_id');
			$ytype_id=$request->get('ytype_id');
			$ycount_id=$request->get('ycount_id');
			$yconsumption_id=$request->get('yconsumption_id');
			$structure_id=$request->get('structure_id');
			$elasten=$request->get('elasten');
			$lycraratio_id=$request->get('lycraratio_id');
			$ydstripe_id=$request->get('ydstripe_id');
			$ydrepeat=$request->get('ydrepeat');
			$washing_id=$request->get('washing_id');
			$finishing_id=$request->get('finishing_id');
			$ccuff_id=$request->get('ccuff_id');
			$aop_id=$request->get('aop_id');
			$cprocess_id=$request->get('cprocess_id');
			$pono=$request->get('pono');
			$breakdown_id=$request->get('breakdown_id');
			$gtype_id=$request->get('gtype_id');
			$consumption=$request->get('consumption');
			$wastage=$request->get('wastage');
			$loss=$request->get('loss');

			foreach($colors as $key => $val):
				
				
				
				$data=array(
				'color'=>$val,
				'diatype_id'=>$diatype_id[$key],
				'dia_id'=>$dia_id[$key],
				'dmu_id'=>$dmu_id[$key],
				'gsm_id'=>$gsm_id[$key],
				'ftype_id'=>$ftype_id[$key],
				'ytype_id'=>$ytype_id[$key],
				'ycount_id'=>$ycount_id[$key],
				'yconsumption_id'=>$yconsumption_id[$key],
				'structure_id'=>$structure_id[$key],
				'elasten'=>$elasten[$key],
				'lycraratio_id'=>$lycraratio_id[$key],
				'ydstripe_id'=>$ydstripe_id[$key],
				'ydrepeat'=>$ydrepeat[$key],
				'washing_id'=>$washing_id[$key],
				'finishing_id'=>$finishing_id[$key],
				'ccuff_id'=>$ccuff_id[$key],
				'aop_id'=>$aop_id[$key],
				'cprocess_id'=>$cprocess_id[$key],
				'com_id'=>$com_id,
				'pono'=>$pono[$key],
				'jobno'=>$request->get('jobno'),
				'booking_id'=>$request->get('booking'),
				'dia_sl'=>$request->get('dia_sl'),
				'breakdown_id'=>$breakdown_id[$key],
				'fm_id'=>$request->get('fm_id'),
				'consumption'=>$consumption[$key],
				'wastage'=>$wastage[$key],
				'loss'=>$loss[$key],
				'user_id'=> Auth::id()
				);
				Fabricdetails::create($data);
			endforeach;
		else:
			$fabricdetail = $request->all();
			$fabricdetail['user_id'] = Auth::id();
	        //Fabricdetails::create($fabricdetail);
		endif;
		return redirect('fabricmaster/'.$request->get('fm_id'));
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
		$fabricdetail = Fabricdetails::findOrFail($id);
		return view('merchandizing.fabricdetail.show', compact(['langs', 'fabricdetail']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
	$company = Companies::where('id', $com_id)->first();
	Session::has('jobno') ?  $jobno=Session::get('jobno') : $jobno='';
	Session::has('booking_id') ?  $booking_id=Session::get('booking_id') : $booking_id='';

	$order=Orders::Latest()->get();
	$orders=array(''=>'Select ...');
	foreach($order as $item):
		$orders[$item['id']]=$item['orderno'];
	endforeach;
	$order=Orders::Latest()->get();
	$jobnos=array(''=>'Select ...');
	foreach($order as $item):
		$jobnos[$item['id']]=$item['jobno'];
	endforeach;
	
	$gtype=Gtypes::Latest()->get();
	$gtypes=array(''=>'Select ...');
	foreach($gtype as $item):
		$gtypes[$item['id']]=$item['name'];
	endforeach;

	$pogarment=Pogarments::Latest()->get();
	$pogarments=array(''=>'Select ...');
	foreach($pogarment as $item):
		$pogarments[$item['id']]=$item['name'];
	endforeach;

	$dia=Dias::Latest()->get();
	$dias=array(''=>'Select ...');
	foreach($dia as $item):
		$dias[$item['id']]=$item['name'];
	endforeach;

	$diatype=Diatypes::Latest()->get();
	$diatypes=array(''=>'Select ...');
	foreach($diatype as $item):
		$diatypes[$item['id']]=$item['name'];
	endforeach;

	$gsm=Gsms::Latest()->get();
	$gsms=array(''=>'Select ...');
	foreach($gsm as $item):
		$gsms[$item['id']]=$item['name'];
	endforeach;

	$ftype=Ftypes::Latest()->get();
	$ftypes=array(''=>'Select ...');
	foreach($ftype as $item):
		$ftypes[$item['id']]=$item['name'];
	endforeach;

	$unit=Munits::Latest()->get();
	$units=array(''=>'Select ...');
	foreach($unit as $item):
		$units[$item['id']]=$item['name'];
	endforeach;

	$ytype=Ytypes::Latest()->get();
	$ytypes=array(''=>'Select ...');
	foreach($ytype as $item):
		$ytypes[$item['id']]=$item['name'];
	endforeach;

	$ycount=Ycounts::Latest()->get();
	$ycounts=array(''=>'Select ...');
	foreach($ycount as $item):
		$ycounts[$item['id']]=$item['name'];
	endforeach;

	$yconsumption=Yconsumptions::Latest()->get();
	$yconsumptions=array(''=>'Select ...');
	foreach($yconsumption as $item):
		$yconsumptions[$item['id']]=$item['name'];
	endforeach;

	$ydstripe=Ydstripes::Latest()->get();
	$ydstripes=array(''=>'Select ...');
	foreach($ydstripe as $item):
		$ydstripes[$item['id']]=$item['name'];
	endforeach;

	$washing=Washings::Latest()->get();
	$washings=array(''=>'Select ...');
	foreach($washing as $item):
		$washings[$item['id']]=$item['name'];
	endforeach;

	$ccuff=Ccuffs::Latest()->get();
	$ccuffs=array(''=>'Select ...');
	foreach($ccuff as $item):
		$ccuffs[$item['id']]=$item['name'];
	endforeach;

	$aop=Aops::Latest()->get();
	$aops=array(''=>'Select ...');
	foreach($aop as $item):
		$aops[$item['id']]=$item['name'];
	endforeach;

	$lycraratio=Lycraratios::Latest()->get();
	$lycraratios=array(''=>'Select ...');
	foreach($lycraratio as $item):
		$lycraratios[$item['id']]=$item['name'];
	endforeach;

	$cprocess=Cprocesses::Latest()->get();
	$cprocesses=array(''=>'Select ...');
	foreach($cprocess as $item):
		$cprocesses[$item['id']]=$item['name'];
	endforeach;

	$structure=Structures::Latest()->get();
	$structures=array(''=>'Select ...');
	foreach($structure as $item):
		$structures[$item['id']]=$item['name'];
	endforeach;

	$finishing=Finishings::Latest()->get();
	$finishings=array(''=>'Select ...');
	foreach($finishing as $item):
		$finishings[$item['id']]=$item['name'];
	endforeach;

        $langs = Languages::lists('value', 'code');
		$fabricdetail = Fabricdetails::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $fabricdetail->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.fabricdetail.edit', compact(['langs', 'fabricdetail','orders','jobnos','gtypes','pogarments','diatypes','dias','diatypes','gsms','ftypes','units','ytypes','ycounts','yconsumptions','ydstripes','washings','ccuffs','aops','lycraratios','cprocesses','structures','new_jobno','finishings','dia_sl','fm_id']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$fabricdetail = Fabricdetails::findOrFail($id);
		$fabricdetail->update($request->all());
		return redirect('fabricdetail');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Fabricdetails::destroy($id);
		return redirect('fabricdetail');
	}

}