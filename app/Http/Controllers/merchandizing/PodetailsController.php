<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Podetails;
use App\Models\merchandizing\Pomasters;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use DB;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class PodetailsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $podetails = Podetails::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $podetails = $podetails->where('user_id',Auth::id());
        }
        $podetails = $podetails->get();
		return view('merchandizing.podetails.index', compact(['langs', 'podetails']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.podetails.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

	Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
	
	//  for calculating ration
 	function gcd($a, $b) {
        $_a = abs($a);
        $_b = abs($b);

        while ($_b != 0) {

            $remainder = $_a % $_b;
            $_a = $_b;
            $_b = $remainder;   
        }
        return $a;
    }
	function ratio($get_datas)
    {
        $inputs = explode( ',', $get_datas ); //func_get_args();
        $c = count($inputs);
        if($c < 1)
            return ''; //empty input
        if($c == 1)
            return $inputs[0]; //only 1 input
        $gcd = gcd($inputs[0], $inputs[1]); //find gcd of inputs
        for($i = 2; $i < $c; $i++) 
            $gcd = gcd($gcd, $inputs[$i]);
        $var = $inputs[0] / $gcd; //init output
        for($i = 1; $i < $c; $i++)
            $var .= ':' . ($inputs[$i] / $gcd); //calc ratio
        return $var; 
    }


		if($request->get('flag')=='modal'):
			$size=$request->get('size');
			$color=$request->get('color');
			$ratio=$request->get('ratio');
			$color_sl=$request->get('color_sl');
			
			$x=0; $get_datas='';$get_data=''; $r=0; 
			
			foreach($size as $key => $val):
			$r++; $q=0;
				foreach($color as $no => $val):
					$q++; 
					$get_datas=='' ? $get_datas .= $request->get('ratio'.$q.$r) : $get_datas .= ', ' .$request->get('ratio'.$q.$r);
				endforeach;
			endforeach;
				$gcd=ratio($get_datas);
			 	$ratio = explode( ':', $gcd ); //func_get_args();
				$n=-1;
			foreach($size as $key => $val):
				$size_name[$key]=$val;
				$x++; $y=0;
				$request->get('bd_id')==1 ? $fld_name='ratio' : $fld_name='qty';
				foreach($color as $no => $val):
					$y++; 
					$color_name[$no]=$val;
					//DB::table($request->get('ratio'.$y.$x))->first();
					$data=array(
					'size_sl'		=> 	$request->get('size'.$y.$x),
					'size'			=>	$size_name[$key],
					'color_sl'		=>	$color_sl[$no],
					'color'			=>	$color_name[$no],
					$fld_name		=> 	$request->get('ratio'.$y.$x),
					'pm_id'			=> 	$request->get('pm_id'),
					'port_id'		=> 	$request->get('port_id'),
					'shipment_date'	=> 	$request->get('shipment_date'),
					'com_id'		=> 	$com_id,
					'jobno'			=> 	$request->get('jobno'),
					'breakdown_id'	=> 	$request->get('breakdown_id'),
					'user_id'		=>  Auth::id()
					);
					$n++;
					$get_datas=='' ? $get_datas .= $request->get('ratio'.$y.$x) : $get_datas .= ', ' .$request->get('ratio'.$y.$x);
					
					$request->get('bd_id')==2 ? $data['ratio']=$ratio[$n] : '';
					Podetails::create($data);
				endforeach;

			endforeach;
			
			$request->get('bd_id')==1 ? $fld_n='qty' : $fld_n='ratio';
			$ttl_ration=Podetails::where('pm_id',$request->get('pm_id'))->where('breakdown_id',$request->get('breakdown_id'))->sum('ratio');
			$podetail=Podetails::where('pm_id',$request->get('pm_id'))->where('breakdown_id',$request->get('breakdown_id'))->Oldest()->get();
			$ttl_qty=Pomasters::where('id',$request->get('pm_id'))->first();
			$request->get('port_qty')!=null || $request->get('port_qty')!='' ? $ttl=$request->get('port_qty')  : $ttl=$ttl_qty->qty;			
			//DB::table($ttl)->first();
			foreach($podetail as $item):
				$qty=($ttl/$ttl_ration) * $item->ratio;
				//DB::table($qty)->first();
				DB::update('update merch_podetails set qty = '.$qty.' where  color = ? and size = ? and pm_id = ? and breakdown_id = ?', [$item->color, $item->size, $request->get('pm_id'),$request->get('breakdown_id')]);	
			endforeach;
			
		else:	
			$podetails = $request->all();
			$podetails['user_id'] = Auth::id();
			Podetails::create($podetails);
		endif;
		return redirect('pomaster/'.$request->get('pm_id'));
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
		$podetail = Podetails::findOrFail($id);
		return view('merchandizing.podetails.show', compact(['langs', 'podetail']));
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
		$podetail = Podetails::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $podetail->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.podetails.edit', compact(['langs', 'podetail']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$podetail = Podetails::findOrFail($id);
		$podetail->update($request->all());
		return redirect('podetails');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Podetails::destroy($id);
		return redirect('podetails');
	}

}