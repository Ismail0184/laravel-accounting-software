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
use Session;
use DB;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class FabricmasterController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		isset($_GET['booking_id']) && $_GET['booking_id']>0 ? Session::put('booking_id',$_GET['booking_id']) : '';

		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$company = Companies::where('id', $com_id)->first();
		
		Session::has('jobno') ?  $jobno=Session::get('jobno') : $jobno='';
		Session::has('booking_id') ?  $booking_id=Session::get('booking_id') : $booking_id='';
		
		$langs = Languages::lists('value', 'code');
		
		$booking_id !='' ? $booking=array('booking_id'=>$booking_id) : $booking=array();
		
        $fabricmasters = Fabricmasters::where('com_id',$com_id)->where('jobno',$jobno)->orderBy('booking_id')->where($booking)->Oldest('dia_sl');
		$find = Fabricmasters::select('jobno')->where('com_id',$com_id)->groupBy('jobno')->get();
		$find_jobno=array(''=>'Select a Job No');
		foreach($find as $item):
			$find_jobno[$item['jobno']]=$item['jobno'];
		endforeach;

		$diatype=Diatypes::Latest()->get();
		$diatypes=array(''=>'Select ...');
		foreach($diatype as $item):
			$diatypes[$item['id']]=$item['name'];
		endforeach;
		
		$po_list=Pomasters::select('merch_pomasters.pono','merch_bookings.booking')
				->leftjoin('merch_bookings','merch_pomasters.pono','=','merch_bookings.pono')
				->where('merch_pomasters.com_id',$com_id)
				->where('merch_pomasters.jobno',$jobno)
				->where('merch_bookings.booking',null)
				->groupBy('merch_pomasters.pono')->get();
				
		$booking_id=Pomasters::select('merch_pomasters.pono','merch_bookings.booking')
				->leftjoin('merch_bookings','merch_pomasters.pono','=','merch_bookings.pono')
				->where('merch_pomasters.com_id',$com_id)
				->where('merch_pomasters.jobno',$jobno)
				->where('merch_bookings.booking', '>', '0')
				->groupBy('merch_bookings.booking')->get();
		
		$booking_count=Bookings::where('com_id',$com_id)->where('jobno',$jobno)->max('booking')+1;	
			
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $fabricmasters = $fabricmasters->where('user_id',Auth::id());
        }
        $fabricmasters = $fabricmasters->get();
		return view('merchandizing.fabricmaster.index', compact(['langs', 'fabricmasters','company','diatypes','find_jobno','po_list','booking_id','booking_count']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
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
	
	$fm_id=Fabricmasters::where('com_id',$com_id)->max('id')+1;
	
	$dia_sl=Fabricmasters::where('com_id',$com_id)->where('jobno',$jobno)->where('booking_id',$booking_id)->max('dia_sl')+1;
	
	$new_jobno=Fabricmasters::where('com_id',$com_id)->max('jobno')+1;
    $langs = Languages::lists('value', 'code');
		return view('merchandizing.fabricmaster.create', compact('langs','orders','jobnos','gtypes','pogarments','diatypes','dias','diatypes','gsms','ftypes','units','ytypes','ycounts','yconsumptions','ydstripes','washings','ccuffs','aops','lycraratios','cprocesses','structures','new_jobno','finishings','dia_sl','fm_id'));
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
		Session::has('booking_id') ?  $booking_id=Session::get('booking_id') : $booking_id='';
	    
		$fabricmaster = $request->all();
        $fabricmaster['user_id'] = Auth::id();
		$fabricmaster['com_id'] = $com_id;
        Fabricmasters::create($fabricmaster);
		Session::put('jobno',$request->get('jobno'));
		$fm=Fabricmasters::where('com_id',$com_id)->where('jobno',$jobno)->where('booking_id',$booking_id)->where('dia_sl',$request->get('dia_sl'))->first();
		return redirect('fabricmaster/'.$fm->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
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

		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$company = Companies::where('id', $com_id)->first();
		Session::has('jobno') ?  $jobno=Session::get('jobno') : $jobno='';
		
		Session::has('booking_id') ?  $booking_id=Session::get('booking_id') : $booking_id='';
		$bookins=Bookings::select('pono')->where('jobno',$jobno)->where('booking',$booking_id)->where('com_id',$com_id)->get()->toArray();
        
		$langs = Languages::lists('value', 'code');
		$fabricmaster = Fabricmasters::findOrFail($id);
		
		$ponos=Pomasters::where('com_id',$com_id)->where('jobno',$jobno)->whereIn('pono',$bookins)->groupBy('port_id')->get();
		
		$fabricdetails=Fabricdetails::select('pono','jobno','dia_id','dia_sl','breakdown_id')
		->where('jobno',$fabricmaster->jobno)
		->where('dia_sl',$fabricmaster->dia_sl)
		->where('booking_id',$fabricmaster->booking_id)
		->where('com_id',$com_id)->groupBy('pono')->get();
		
		// update fm_id for previos data 		
		$edit=Fabricmasters::where('id', $id)->get();
		foreach($edit as $item):
			DB::update('update merch_fabricdetails set fm_id = '.$item->id.' where com_id = ? and jobno = ? and dia_sl = ? and  booking_id =? and fm_id = ? ', [$item->com_id,$item->jobno,$item->dia_sl,$item->booking_id, 0]);
		endforeach;
	
		
		return view('merchandizing.fabricmaster.show', compact(['langs', 'fabricmaster','fabricdetails','ponos','orders','jobnos','gtypes','pogarments','diatypes','dias','gsms','ftypes','units','ytypes','ycounts','yconsumptions','ydstripes','washings','ccuffs','aops','lycraratios','cprocesses','structures','finishings']));
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
		$fabricmaster = Fabricmasters::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $fabricmaster->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.fabricmaster.edit', compact(['langs', 'fabricmaster','orders','jobnos','gtypes','pogarments','diatypes','dias','gsms','ftypes','units','ytypes','ycounts','yconsumptions','ydstripes','washings','ccuffs','aops','lycraratios','cprocesses','structures','finishings']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$fabricmaster = Fabricmasters::findOrFail($id);
		$fabricmaster->update($request->all());
		return redirect('fabricmaster');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Fabricmasters::destroy($id);
		return redirect('fabricmaster');
	}
	
	public function find(Request $request)
	{
		Session::put('jobno',$request->get('jobno'));
		return redirect('fabricmaster');
	}
	
	public function booking(Request $request)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$pono=$request->get('pono');
		if(count($pono)>0): 
			foreach($pono as $key => $val):
				$data=array(
					'jobno'		=> $request->get('jobno'),
					'pono'		=> $val,
					'booking'	=> $request->get('booking'),
					'com_id'	=> $com_id,
					'user_id'	=> Auth::id()
				);
				Bookings::create($data);
			endforeach;
		endif;
		
//		$sample=Fabricdetails::groupBy('jobno', 'pono','booking_id','com_id')->get();
//		foreach($sample as $item):
//			$data=array(
//			'jobno'	=> $item->jobno,
//			'pono'	=> $item->pono,
//			'booking'	=> $item->booking_id,
//			'com_id'	=> $item->com_id,
//			'user_id'	=> Auth::id()			
//			);
//			Bookings::create($data);
//		endforeach;
		
		return redirect('fabricmaster');
	}


}