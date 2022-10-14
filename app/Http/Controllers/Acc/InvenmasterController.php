<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Invenmasters;
use App\Models\Acc\Invendetails;
use App\Models\Acc\Prequisitions;
use App\Models\Acc\Products;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Lcinfos;
use App\Models\Acc\Orderinfos;
use App\Models\Acc\Styles;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Currencies;
use App\Models\Acc\Tranmasters;
use App\Models\Acc\Trandetails;
use App\Models\Acc\Companies;
use App\Models\Acc\Stock;
use App\Models\Acc\Projects;
use App\Models\Acc\Warehouses;
use App\Models\Acc\Salemasters;
use App\Models\Acc\Options;
use App\Models\Acc\Clients;
use App\Models\Acc\Ittypes;

use Session;


use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use DB;

use Auth;
use Response;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class InvenmasterController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$invenmasters = Invenmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $invenmasters = $invenmasters->where('user_id',Auth::id());
        }
		return view('acc.invenmaster.index', compact(['invenmasters', 'langs']));
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

        $user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
        $prequisition = Prequisitions::where('com_id', $com_id)->latest()->get();
		$prequisitions['']="Select ...";
        foreach($prequisition as $data) {
            $prequisitions[$data['id']] = $data['name'];
        }
		$warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }
		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
		foreach($clients as $clients_data):
			$client[$clients_data['id']]=$clients_data['name'];
		endforeach;

		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($currencys as $currencys_data) {
            $currency[$currencys_data['id']] = $currencys_data['name'];
        }
		$langs = $this->language();
		return view('acc.invenmaster.create', compact('langs','users', 'currency','prequisitions','warehouses','client'));
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

		$option=DB::table('acc_options')->where('com_id', $com_id)->first();
		$option_cwh_id=''; isset($option) && $option->id >0 ? $option_cwh_id=$option->cwh_id : $option_cwh_id='';
		$option_cur_id=''; isset($option) && $option->id >0 ? $option_cur_id=$option->currency_id : $option_cur_id='';
//		$inven_auto_id=''; isset($option) && $option->id >0 ? $inven_auto_id=$option->inven_auto_id : $inven_auto_id='';

		if($request->get('flag')!='addstore'):
			$invenmaster = $request->all();
			$invenmaster['user_id'] = Auth::id();
			$invenmaster['com_id'] = $com_id;
			Invenmasters::create($invenmaster);
			$tm_id=DB::table('acc_invenmasters')->where('com_id', $com_id)->where('vnumber',$request->get('vnumber'))->first();
			return redirect('invenmaster/'.$tm_id->id);
		else:
		// from import add store
		$data_master=array(
			'vnumber'	=> $request->get('vnumber'),
			'itype'	=> $request->get('itype'),
			'idate'	=> $request->get('idate'),
			'amount'	=> $request->get('amount'),
			'currency_id'	=> 3,
			'note'	=> $request->get('note'),
			'person'	=> $request->get('person'),
			'sm_id'	=> $request->get('sm_id')!=null ? $request->get('sm_id') : 0,
			'pm_id'	=> $request->get('pm_id')!=null ? $request->get('pm_id') : 0,
			'com_id' => $com_id,
			'wh_id'  	=>  $option_cwh_id,
			'user_id' => Auth::id()
		);
		Invenmasters::create($data_master);
		$im_id=DB::table('acc_invenmasters')->where('com_id', $com_id)->where('vnumber',$request->get('vnumber'))->first();
		
		$qty= $request->get('qty');
		$qtys=array();
		foreach($qty as $key => $val){
			$qtys[$key]=$val;
		}
		//DB::table($request->get('check'))->first();
		
		if ($request->get('check')=='import'):
			$rate=$request->get('unitCost'); 
		else: 
		 	$rate=$request->get('rate');
		endif;
		
		$rates=array();
		foreach($rate as $key => $val){
			$rates[$key]=$val;
		}
		$item_id= $request->get('item_id');
		$item=array();
		foreach($item_id as $key => $val):
			$data=array(
				'im_id'  	=> $im_id->id,
				'item_id'	=>$val,
				'qty'    	=> $request->get('itype')=='Issue' ? -$qtys[$key] : $qtys[$key] ,
				'rate'    	=> $rates[$key],
				'amount'  	=> $qtys[$key] * $rates[$key], 
				'war_id'  	=>  $option_cwh_id,
				'com_id' => $com_id,
				'user_id' 	=> Auth::id()
				);
				//================ cost of sale
					$product = Products::findOrFail($val);
					$qty=Invendetails::where('item_id',$val)->sum('qty');
					if ($qty==0):
						$cos=array('cos'=>$rates[$key]);
					else:
						$ttl_value=$product->cos*$qty; $ttl_avg='';
						if ($request->get('itype')=='Issue'): 
							//$ttl_avg=$ttl_value/(-$qtys[$key]+$qty);
						else:
							$ttl_value += $qtys[$key]*$rates[$key];
							//$ttl_avg=$ttl_value/($qtys[$key]+$qty);
						endif;
						$cos=array('cos'=>$ttl_avg);
					endif;
					$product->update($cos);
					//---------------------------
				Invendetails::create($data);
		endforeach;
		// close import add store
		// tranmaster entry
		if ($request->get('vnumbers')!=null && $request->get('vnumbers')>0 && $request->get('check')=='import'):
				$data_tranmater=array(
					'vnumber'				=> $request->get('vnumbers'),
					'tdate'					=> $request->get('idate'),
					'note' 					=> $request->get('note'),
					'tmamount'				=> $request->get('amount'),
					'currency_id'			=> $option_cur_id,
					'ttype'					=> 'Journal',
					'tranwith_id'			=> $request->get('tranwith_id'),
					'com_id' => $com_id,
					'user_id' => Auth::id()
				);
				Tranmasters::create($data_tranmater);
				$tm=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('vnumber',$request->get('vnumbers'))->first();
				$data_trandetail1=array(
					'tm_id'					=>	$tm->id,
					'acc_id' 				=> $request->get('acc_id'),
					'amount'				=> -$request->get('amount'),
					'tranwiths_id'			=> $request->get('tranwith_id'),
					'com_id' => $com_id,
					'ilc_id' 				=> $request->get('ilc_id'),
					'user_id' => Auth::id()
				);
				Trandetails::create($data_trandetail1);
				$data_trandetail2=array(
					'tm_id'					=> $tm->id,
					'acc_id' 				=> $request->get('tranwith_id'),
					'amount'				=> $request->get('amount'),
					'tranwiths_id'			=> $request->get('acc_id'),
					'com_id' 				=> $com_id,
					'ilc_id' 				=> $request->get('ilc_id'),
					'user_id' => Auth::id()
				);
				Trandetails::create($data_trandetail2);
		elseif ($request->get('vnumbers')!=null && $request->get('vnumbers')>0 && $request->get('check')=='purchase'):
		if($request->get('dues')==0 ):
			// Transaction for cash paid in Tranmasters
				$data_tranmater=array(
					'vnumber'				=> $request->get('vnumbers'),
					'tdate'					=> $request->get('tdate'),
					'note' 					=> $request->get('note'),
					'tmamount'				=> $request->get('tmamount'),
					'currency_id'			=> $option_cur_id,
					'ttype'					=> 'Payment',
					'tranwith_id'			=> $request->get('tranwith_id'),
					'com_id' => $com_id,
					'user_id' => Auth::id()
				);
				Tranmasters::create($data_tranmater);
				// Transaction for cash paid in Trandetails
				$tm=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('vnumber',$request->get('vnumbers'))->first();
				$data_trandetail1=array(
					'tm_id'					=>	$tm->id,
					'acc_id' 				=> $request->get('acc_id'),
					'amount'				=> $request->get('amounts'),
					'tranwiths_id'			=> $request->get('tranwith_id'),
					'com_id' => $com_id,
					'user_id' => Auth::id()
				);
				Trandetails::create($data_trandetail1);
				$data_trandetail2=array(
					'tm_id'					=> $tm->id,
					'acc_id' 				=> $request->get('tranwith_id'),
					'amount'				=> -$request->get('amounts'),
					'tranwiths_id'			=> $request->get('acc_id'),
					'flag' => 1,
					'com_id' 				=> $com_id,
					'user_id' => Auth::id()
				);
				Trandetails::create($data_trandetail2);
		endif;
					if($request->get('dues')>0 ):
					// transaction for credit Purchase in Tranmasters
						$data_tranmater=array(
							'vnumber'				=> $request->get('vnumbers'),
							'tdate'					=> $request->get('tdate'),
							'note' 					=> $request->get('note'),
							'tmamount'				=> $request->get('amount'),
							'currency_id'			=> $option_cur_id,
							'ttype'					=> 'Journal',
							'tranwith_id'			=> $request->get('acc_id'),
							'com_id' => $com_id,
							'user_id' => Auth::id()
						);
						Tranmasters::create($data_tranmater);
						// transaction for credit Purchase in Trandetails
						$tm=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('vnumber',$request->get('vnumbers'))->first();
						$data_trandetail1=array(
							'tm_id'					=>	$tm->id,
							'acc_id' 				=> $request->get('acc_id'),
							'amount'				=> $request->get('amount'),
							'tranwiths_id'			=> $request->get('clacc_id'),
							'com_id' => $com_id,
							'user_id' => Auth::id()
						);
						Trandetails::create($data_trandetail1);
						$data_trandetail2=array(
							'tm_id'					=> $tm->id,
							'acc_id' 				=> $request->get('clacc_id'),
							'amount'				=> -$request->get('amount'),
							'tranwiths_id'			=> $request->get('acc_id'),
							'flag' => 1,
							'com_id' 				=> $com_id,
							'user_id' => Auth::id()
						);
						Trandetails::create($data_trandetail2);
					// transaction for paid
							if($request->get('paid')>0 ):
								$data_tranmater=array(
									'vnumber'				=> $request->get('vnumbers')+1,
									'tdate'					=> $request->get('tdate'),
									'note' 					=> $request->get('note'),
									'tmamount'				=> $request->get('paid'),
									'currency_id'			=> $option_cur_id,
									'ttype'					=> 'Payment',
									'tranwith_id'			=> $request->get('tranwith_id'),
									'com_id' => $com_id,
									'user_id' => Auth::id()
								);
								Tranmasters::create($data_tranmater);
								$tm=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('vnumber',$request->get('vnumbers')+1)->first();
								$data_trandetail1=array(
									'tm_id'					=>	$tm->id,
									'acc_id' 				=> $request->get('clacc_id'),
									'amount'				=> $request->get('paid'),
									'tranwiths_id'			=> $request->get('tranwith_id'),
									'com_id' => $com_id,
									'user_id' => Auth::id()
								);
								Trandetails::create($data_trandetail1);
								$data_trandetail2=array(
									'tm_id'					=> $tm->id,
									'acc_id' 				=> $request->get('tranwith_id'),
									'amount'				=> -$request->get('paid'),
									'tranwiths_id'			=> $request->get('clacc_id'),
									'flag' => 1,
									'com_id' 				=> $com_id,
									'user_id' => Auth::id()
								);
								Trandetails::create($data_trandetail2);
							endif;
					endif;
		elseif ($request->get('vnumbers')!=null && $request->get('vnumbers')>0 && $request->get('check')=='sale'):
		if($request->get('dues')==0 ):
		// Transaction for cash Sale
				$data_tranmater=array(
					'vnumber'				=> $request->get('vnumbers'),
					'tdate'					=> $request->get('tdate'),
					'note' 					=> $request->get('note'),
					'tmamount'				=> $request->get('tmamount'),
					'currency_id'			=> $option_cur_id,
					'ttype'					=> 'Receive',
					'tranwith_id'			=> $request->get('sales_id'),
					'com_id' => $com_id,
					'user_id' => Auth::id()
				);
				Tranmasters::create($data_tranmater);
				$tm=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('vnumber',$request->get('vnumbers'))->first();
				$data_trandetail1=array(
					'tm_id'					=>	$tm->id,
					'acc_id' 				=> $request->get('cash_id'),
					'amount'				=> $request->get('amounts'),
					'tranwiths_id'			=> $request->get('sales_id'),
					'com_id' => $com_id,
					'user_id' => Auth::id()
				);
				Trandetails::create($data_trandetail1);
				$data_trandetail2=array(
					'tm_id'					=> $tm->id,
					'acc_id' 				=> $request->get('sales_id'),
					'amount'				=> -$request->get('amounts'),
					'tranwiths_id'			=> $request->get('cash_id'),
					'flag' => 1,
					'com_id' 				=> $com_id,
					'user_id' => Auth::id()
				);
				Trandetails::create($data_trandetail2);
		endif;
					if($request->get('dues')>0 ):
					// transaction for credit sales
						$data_tranmater=array(
							'vnumber'				=> $request->get('vnumbers'),
							'tdate'					=> $request->get('tdate'),
							'note' 					=> $request->get('note'),
							'tmamount'				=> $request->get('tmamount'),
							'currency_id'			=> $option_cur_id,
							'ttype'					=> 'Journal',
							'tranwith_id'			=> $request->get('sales_id'),
							'com_id' => $com_id,
							'user_id' => Auth::id()
						);
						Tranmasters::create($data_tranmater);
						$tm=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('vnumber',$request->get('vnumbers'))->first();
						$data_trandetail1=array(
							'tm_id'					=>	$tm->id,
							'acc_id' 				=> $request->get('clacc_id'),
							'amount'				=> $request->get('dues'),
							'tranwiths_id'			=> $request->get('sales_id'),
							'com_id' => $com_id,
							'user_id' => Auth::id()
						);
						Trandetails::create($data_trandetail1);
						$data_trandetail2=array(
							'tm_id'					=> $tm->id,
							'acc_id' 				=> $request->get('sales_id'),
							'amount'				=> -$request->get('dues'),
							'tranwiths_id'			=> $request->get('clacc_id'),
							'flag' => 1,
							'com_id' 				=> $com_id,
							'user_id' => Auth::id()
						);
						Trandetails::create($data_trandetail2);
					// transaction for paid
					if($request->get('paid')>0 ):
						$data_tranmater=array(
							'vnumber'				=> $request->get('vnumbers')+1,
							'tdate'					=> $request->get('tdate'),
							'note' 					=> $request->get('note'),
							'tmamount'				=> $request->get('paid'),
							'currency_id'			=> $option_cur_id,
							'ttype'					=> 'Receive',
							'tranwith_id'			=> $request->get('cash_id'),
							'com_id' => $com_id,
							'user_id' => Auth::id()
						);
						Tranmasters::create($data_tranmater);
						$tm=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('vnumber',$request->get('vnumbers')+1)->first();
						$data_trandetail1=array(
							'tm_id'					=>	$tm->id,
							'acc_id' 				=> $request->get('cash_id'),
							'amount'				=> $request->get('paid'),
							'tranwiths_id'			=> $request->get('clacc_id'),
							'com_id' => $com_id,
							'user_id' => Auth::id()
						);
						Trandetails::create($data_trandetail1);
						$data_trandetail2=array(
							'tm_id'					=> $tm->id,
							'acc_id' 				=> $request->get('clacc_id'),
							'amount'				=> -$request->get('paid'),
							'tranwiths_id'			=> $request->get('cash_id'),
							'flag' => 1,
							'com_id' 				=> $com_id,
							'user_id' => Auth::id()
						);
						Trandetails::create($data_trandetail2);
						endif; // cash collection
					endif;

		endif;
			return redirect('invenmaster');
		endif;
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

		$warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }
		$projects = Projects::where('com_id',$com_id)->latest()->get();
		$project['']="Select ...";
        foreach($projects as $data) {
            $project[$data['id']] = $data['name'];
        }		
		$unit = AccUnits::latest()->get();
		$units['']="Select ...";
        foreach($unit as $unit_data) {
            $units[$unit_data['id']] = $unit_data['name'];
        }
		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($currencys as $data) {
            $currency[$data['id']] = $data['name'];
        }
		$ittype = Ittypes::latest()->get();
		$ittypes['']="Select ...";
        foreach($ittype as $data) {
            $ittypes[$data['id']] = $data['name'];
        }
			Session::has('sswh_id') ? $wh_id=Session::get('sswh_id') : $wh_id='' ; //echo $wh_id.'hasan habib';
			Session::has('ssitype') ? $itype=Session::get('ssitype') : $itype='' ; //echo $itype.'hasan habib';
		if ($itype!='Issue'):
			$product = Products::where('com_id', $com_id)->where('ptype','Product')->latest()->get();
		else:
			$product = Products::join('acc_invendetails','acc_products.id','=','acc_invendetails.item_id')->select('acc_products.*')->having(DB::raw('sum(qty)'),'>',0)
			->where('acc_products.com_id',$com_id)
			->groupBy('item_id')->get();
		endif;
		$products['']="Select ...";
        foreach($product as $product_data) {
            $products[$product_data['id']] = $product_data['name'];
        }
		$lc = Lcinfos::where('com_id', $com_id)->latest()->get();
		$lcs['']="Select ...";
        foreach($lc as $lc_data) {
            $lcs[$lc_data['id']] = $lc_data['lcnumber'];
        }
		$ord = Orderinfos::where('com_id', $com_id)->latest()->get();
		$ords['']="Select ...";
        foreach($ord as $ord_data) {
            $ords[$ord_data['id']] = $ord_data['ordernumber'];
        }
		$stl = Styles::where('com_id', $com_id)->latest()->get();
		$stls['']="Select ...";
        foreach($stl as $stl_data) {
            $stls[$stl_data['id']] = $stl_data['name'];
        }
		$req = Prequisitions::where('com_id', $com_id)->latest()->get();
		$reqs['']="Select ...";
        foreach($req as $req_data) {
            $reqs[$req_data['id']] = $req_data['name'];
        }
		$acccoas = Acccoas::where('com_id', $com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        }
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }

		$langs = $this->language();
		$invenmaster = Invenmasters::findOrFail($id);
		return view('acc.invenmaster.show', compact(['invenmaster', 'langs','users','acccoa', 'lcs', 'ords', 'stls', 'reqs','products', 'units', 'currency', 'sbs','project','warehouses','ittypes']));
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

        $prequisition = Prequisitions::where('com_id', $com_id)->latest()->get();
		$prequisitions['']="Select ...";
        foreach($prequisition as $data) {
            $prequisitions[$data['id']] = $data['name'];
        }
        $project = Projects::where('com_id', $com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $data) {
            $projects[$data['id']] = $data['name'];
        }
		$warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }
        $currencys = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($currencys as $currencys_data) {
            $currency[$currencys_data['id']] = $currencys_data['name'];
        }
		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
		foreach($clients as $clients_data):
			$client[$clients_data['id']]=$clients_data['name'];
		endforeach;
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$invenmaster = Invenmasters::findOrFail($id);
		return view('acc.invenmaster.edit', compact(['invenmaster', 'langs','users','currency','prequisitions','projects','client','warehouses']));
	}
	public function sbfilter(Request $request)
	{
		
		Session::put('sbwar_id', $request->get('war_id'));
		Session::put('sbgroup_id', $request->get('group_id'));
		Session::put('sbdto', $request->get('dto'));
		
		return redirect('invenmaster/stock');
	}
	public function invfilter(Request $request)
	{
		
		Session::put('invitype', $request->get('itype'));
		Session::put('invwh_id', $request->get('wh_id'));
		Session::put('invdfrom', $request->get('dfrom'));
		Session::put('invdto', $request->get('dto'));
		return redirect('invenmaster/report');
	}
	public function lgfilter(Request $request)
	{
		
		Session::put('lgprod_id', $request->get('prod_id'));
		Session::put('lgwh_id', $request->get('wh_id'));
		Session::put('lgdfrom', $request->get('dfrom'));
		Session::put('lgdto', $request->get('dto'));
		return redirect('invenmaster/ledger');
	}

	/*public function stock()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

  		$warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }

		$p_group = Products::where('com_id', $com_id)->where('ptype','<>','Product')->latest()->get();
		$p_groups['']="Select ...";
        foreach($p_group as $data) {
            $p_groups[$data['id']] = $data['name'];
        } 
		$com = Companies::latest()->first();
		$product = Products::where('com_id', $com_id)->where('topGroup_id','0')->latest()->get();
        $langs = $this->language();
		return view('acc.invenmaster.stock', compact(['product', 'langs', 'com', 'p_groups','warehouses']));
	}*/
	public function stock_value()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

  		$warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }

		$p_group = Products::where('com_id', $com_id)->where('ptype','<>','Product')->latest()->get();
		$p_groups['']="Select ...";
        foreach($p_group as $data) {
            $p_groups[$data['id']] = $data['name'];
        } 
		$com = Companies::latest()->first();
		$product = Products::where('com_id', $com_id)->where('topGroup_id','0')->latest()->get();
        $langs = $this->language();
		return view('acc.invenmaster.stock_value', compact(['product', 'langs', 'com', 'p_groups','warehouses']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$invenmaster = Invenmasters::findOrFail($id);
		$invenmaster->update($request->all());
		return redirect('invenmaster');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Invenmasters::destroy($id);
		return redirect('invenmaster');
	}
 public function report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }
		$warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }
		$stock = Invenmasters::join('acc_invendetails','acc_invenmasters.id','=','acc_invendetails.im_id')
		->join('acc_products','acc_invendetails.item_id','=','acc_products.id')
		->where('acc_invenmasters.com_id',$com_id)->groupBy('acc_products.id')->orderby('acc_products.name')->get();
        $langs = $this->language();
		return view('acc.invenmaster.report', compact(['stock', 'langs','products','warehouses']));
	}    
public function ledger()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }
		$warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }
		$invoice = Invenmasters::where('com_id',$com_id)->groupBy('vnumber')->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['vnumber'];
        }
		$unit = AccUnits::latest()->get();
		$units['']="Select ...";
        foreach($unit as $data) {
            $units[$data['id']] = $data['name'];
        } 
		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($currencys as $data) {
            $currency[$data['id']] = $data['name'];
        } 
		$sale = array(); //Invenmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.invenmaster.ledger', compact(['sale', 'langs','invoices', 'users','products','units','currency','warehouses']));
	}    

 public function help()
	{
		$tranmasters = Invenmasters::latest()->get();
        $langs = $this->language();
		return view('acc.invenmaster.help', compact(['tranmasters', 'langs']));
	}    
 public function getSegment($id)
     {

		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
    	
		$courts = DB::table('acc_pplannings')->where('com_id',$com_id)->where('pro_id', $id)->get();
        $options = array();

        foreach ($courts as $court) {
            $options += array($court->id => $court->segment);
        }

        return Response::json($options);
     }
public function getOrder($id)
     {

		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
	    $courts = DB::table('acc_Orderinfos')->where('com_id',$com_id)->where('lcnumber', $id)->get();
        $options = array(''=>'Select ..');

        foreach ($courts as $court) {
            $options += array($court->id => $court->ordernumber);
        }

        return Response::json($options);
     }
public function getStyle($id)
     {
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

	    $courts = DB::table('acc_styles')->where('com_id',$com_id)->where('ordernumber', $id)->get();
        $options = array(''=>'Select ...');

        foreach ($courts as $court) {
            $options += array($court->id => $court->name);
        }
		
        return Response::json($options);
     }
   
	/**
	 * Display a listing of the languages code.
	 *
	 * @return Response
	 */
    public function language()
    {        
        $languages = Languages::latest()->get();
        foreach($languages as $lang) {
            $langs[$lang->code] = $lang->value;
        }
        return $langs;
    }
public function getPrice($id)
     {
	Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
    $product = DB::table('acc_products')->where('com_id',$com_id)->where('id', $id)->get();
        $options = array();

        foreach ($product as $court) {
            $options += array($court->id => $court->rate);
        }
        return Response::json($options);
     }
public function getQty($id)
     {
	Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
	Session::has('sswh_id') ? $wh_id=Session::get('sswh_id') : $wh_id='' ;
    $product = DB::table('acc_invendetails')->select(DB::raw('sum(qty) as qty, item_id'))->where('com_id',$com_id)->where('item_id', $id)->where('war_id', $wh_id)->groupBy('item_id')->get();
        $options = array();

        foreach ($product as $court) {
            $options += array($court->item_id => $court->qty);
        }
        return Response::json($options);
     }
	public function stock_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
  		$warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }
		$products = Products::where('com_id',$com_id)->orderBy('group_id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.invenmaster.stock_print', compact(['products', 'langs','warehouses']))->setOption('minimum-font-size', 10);
        return $pdf->stream('Stock_list.pdf');
    }
    
    public function stock_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
		$p_group = Products::where('com_id',$com_id)->where('ptype','<>','Product')->latest()->get();
		$p_groups['']="Select ...";
        foreach($p_group as $data) {
            $p_groups[$data['id']] = $data['name'];
        } 
		$product = Products::where('com_id',$com_id)->where('topGroup_id','0')->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.invenmaster.stock_print', compact(['product', 'langs','p_groups']))->setOption('minimum-font-size', 10);
        return $pdf->stream('Stock_list.pdf');
    }

	public function stock_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
		$p_group = Products::where('com_id',$com_id)->where('ptype','<>','Product')->latest()->get();
		$p_groups['']="Select ...";
        foreach($p_group as $data) {
            $p_groups[$data['id']] = $data['name'];
        } 
		$product = Products::where('com_id',$com_id)->where('topGroup_id','0')->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Stock_balance.doc");

		return view('acc.invenmaster.stock_word', compact(['product', 'langs','p_groups']));
	}
    public function stock_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('challan', function($excel) {

            	$excel->sheet('challan', function($sheet) {
				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$langs = $this->language();
                $sheet->loadView('acc.invenmaster.challan_excel', ['langs' => $langs,'users'=>'users']);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function stock_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('challan', function($excel) {

            	$excel->sheet('challan', function($sheet) {
				Session::has('sm_id') ? 
				$sm_id=Session::get('sm_id') : $sm_id='' ;// echo $com_id.'osama';
				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
			
				$langs = $this->language();
				$product = Products::findOrFail($sm_id);
                $sheet->loadView('acc.invenmaster.challan_excel', ['product' => $product->toArray(), 'langs' => $langs,'users'=>'users']);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	public function ledger_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }
		$sale = Invenmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.invenmaster.ledger_print', compact(['sale', 'langs','products']))->setOption('minimum-font-size', 10);
        return $pdf->stream('ledger.pdf');
    }
    
    public function ledger_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }
		$sale = Invenmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.invenmaster.ledger_print', compact(['sale', 'langs','products']))->setOption('minimum-font-size', 10);
        return $pdf->stream('ledger.pdf');
    }

	public function ledger_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
		$p_group = Products::where('com_id',$com_id)->where('ptype','<>','Product')->latest()->get();
		$p_groups['']="Select ...";
        foreach($p_group as $data) {
            $p_groups[$data['id']] = $data['name'];
        } 
		$product = Products::where('com_id',$com_id)->where('topGroup_id','0')->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Stock_balance.doc");

		return view('acc.invenmaster.ledger_word', compact(['product', 'langs','p_groups']));
	}
    public function ledger_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('challan', function($excel) {

            	$excel->sheet('challan', function($sheet) {
				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$langs = $this->language();
                $sheet->loadView('acc.invenmaster.ledger_excel', ['langs' => $langs,'users'=>'users']);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function ledger_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('challan', function($excel) {

            	$excel->sheet('challan', function($sheet) {
				Session::has('sm_id') ? 
				$sm_id=Session::get('sm_id') : $sm_id='' ;// echo $com_id.'osama';
				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
			
				$langs = $this->language();
				$product = Products::findOrFail($sm_id);
                $sheet->loadView('acc.invenmaster.ledger_excel', ['product' => $product->toArray(), 'langs' => $langs,'users'=>'users']);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	public function checkby()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		// uncheck
		isset($_GET['uc']) ? $uc=$_GET['uc'] : $uc='';
		//echo strpos($uc, '/').$uc.'hasan habib';
		if(strpos($uc, '/')!=0):
			$rr=explode('/',$uc);
			$find=array('idate'=>$rr[1],'vnumber'=>$rr[0]);
			$tran=DB::table('acc_invenmasters')->where($find)->first(); //echo $tran->id;
			$tranmaster = Invenmasters::findOrFail($tran->id);
			$data=array('check_action'=>0);
			$tranmaster->update($data);
		endif;

		$invenmasters = Invenmasters::where('com_id',$com_id)->where('check_action','')->where('check_id',Auth::id())->latest()->get();
        $langs = $this->language();
		return view('acc.invenmaster.checkby', compact(['invenmasters', 'langs']));
	}
	public function checked($id, Request $request)
	{
		//echo $request->get('check_note');
		$invenmaster = Invenmasters::findOrFail($id);
		$invenmaster->update($request->all());
		
		return redirect('invenmaster/checkby');

	}
 public function invoice()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Invenmasters::where('com_id',$com_id)->groupBy('vnumber')->latest()->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['vnumber'];
        }
		$sale = array(); //Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.invenmaster.invoice', compact(['sale', 'langs','invoices', 'users']));
	}    
	
		 public function challan()
	{
		
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Invenmasters::where('com_id',$com_id)->groupBy('vnumber')->latest()->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['vnumber'];
        }
		$sale = array(); //Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.invenmaster.challan', compact(['sale', 'langs','invoices', 'users','comid']));
	}    
	public function inifilter(Request $request)
	{
		
		Session::put('siacc_id', $request->get('acc_id'));
		return redirect('invenmaster/invoice');
	}
	public function chfilter(Request $request)
	{
		Session::put('siacc_id', $request->get('acc_id'));
		return redirect('invenmaster/challan');
	}
	public function sbalance()
	{
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$wh = Warehouses::where('com_id',$com_id)->latest()->get();
		$products = Products::where('com_id',$com_id)->orderby('acc_products.name')->get();
        $langs = $this->language();
		return view('acc.invenmaster.sbalance', compact(['wh', 'langs','products']));
	}
public function stock()
	{
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

  		$warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }
		$products = Products::where('com_id',$com_id)->orderBy('group_id')->get();
        $langs = $this->language();
		return view('acc.invenmaster.stock', compact(['wh', 'langs','products','warehouses']));
	}
public function client()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
		foreach($clients as $clients_data):
			$client[$clients_data['id']]=$clients_data['name'];
		endforeach;

		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }
		$sale = array(); //Invenmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.invenmaster.client', compact(['sale', 'langs','invoices', 'users','products','units','currency','client']));
	}    
public function client_ref()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
		foreach($clients as $clients_data):
			$client[$clients_data['id']]=$clients_data['name'];
		endforeach;

		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }
		$sale = array(); //Invenmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.invenmaster.client_ref', compact(['sale', 'langs','invoices', 'users','products','units','currency','client']));
	}    

	public function clfilter(Request $request)
	{
		
		Session::put('clclient_id', $request->get('client_id'));
		Session::put('cldfrom', $request->get('dfrom'));
		Session::put('cldto', $request->get('dto'));
		
		return redirect('invenmaster/client');
	}
	public function rtfilter(Request $request)
	{
		
		Session::put('rtwh_id', $request->get('wh_id'));
		Session::put('rtdfrom', $request->get('dfrom'));
		Session::put('rtdto', $request->get('dto'));
		
		return redirect('invenmaster/report');
	}
	public function sfilter(Request $request)
	{
		
		Session::put('sdto', $request->get('dto'));
		
		return redirect('invenmaster/sbalance');
	}
	public function client_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
		foreach($clients as $clients_data):
			$client[$clients_data['id']]=$clients_data['name'];
		endforeach;

		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }
		$sale = array(); //Invenmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.invenmaster.client_print', compact(['sale', 'langs','products','client','users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('ledger.pdf');
    }
	public function report_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }
		$warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }
		$stock = Invenmasters::join('acc_invendetails','acc_invenmasters.id','=','acc_invendetails.im_id')
		->join('acc_products','acc_invendetails.item_id','=','acc_products.id')
		->where('acc_invenmasters.com_id',$com_id)->groupBy('acc_products.id')->orderby('acc_products.name')->get();
        $langs = $this->language();

        $pdf = \PDF::loadView('acc.invenmaster.report_print', compact(['stock', 'langs','products','client','users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('ledger.pdf');
    }
	public function sbalance_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
		$wh = Warehouses::where('com_id',$com_id)->latest()->get();
		$products = Products::where('com_id',$com_id)->orderby('acc_products.name')->get();
        $langs = $this->language();

        $pdf = \PDF::loadView('acc.invenmaster.sbalance_print', compact(['stock', 'langs','products','wh','users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('ledger.pdf');
    }

	public function invoice_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Invenmasters::where('com_id',$com_id)->groupBy('vnumber')->latest()->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['vnumber'];
        }
		$sale = array(); //Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();

        $pdf = \PDF::loadView('acc.invenmaster.invoice_print', compact(['sale', 'langs','invoices', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('ledger.pdf');
    }
	public function challan_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Invenmasters::where('com_id',$com_id)->groupBy('vnumber')->latest()->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['vnumber'];
        }
		$sale = array(); //Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();

        $pdf = \PDF::loadView('acc.invenmaster.challan_print', compact(['sale', 'langs','invoices', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('ledger.pdf');
    }

	public function rcvdissue(){ 
	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		Session::has('irdto') ?  $data=array('dfrom'=>Session::get('irdfrom'),'dto'=>Session::get('irdto')) : 
		$data=array('dfrom'=>date('Y-m-d'),'dto'=>date('Y-m-d')) ; 
		$invendetail = Invendetails::join('acc_invenmasters','acc_invenmasters.id','=','acc_invendetails.im_id')
					   ->whereBetween('acc_invenmasters.idate', [$data['dfrom'], $data['dto']])
					   ->where('acc_invendetails.com_id',$com_id)->orderBy('acc_invenmasters.id','DESC')->get();
    
	    $langs = $this->language();
		return view('acc.invenmaster.rcvdissue', compact(['invendetail', 'langs']));
	 
    }
	public function irfilter(Request $request)
	{
		
		Session::put('irdfrom', $request->get('dfrom'));
		Session::put('irdto', $request->get('dto'));
		
		return redirect('invenmaster/rcvdissue');
	}

}