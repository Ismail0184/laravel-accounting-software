<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Salemasters;
use App\Models\Acc\Saledetails;
use App\Models\Acc\Clients;
use App\Models\Acc\Products;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Currencies;
use App\Models\Acc\Companies;
use App\Models\Acc\Outlets;
use App\Models\Acc\Mteams;
use App\Models\Acc\Options;
use App\Models\Acc\Warehouses;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Trandetails;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\User;

use Auth;
use DB;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class SalemasterController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
		foreach($clients as $clients_data):
			$client[$clients_data['id']]=$clients_data['name'];
		endforeach;
		
		Session::has('sdfrom') ? $dfrom=Session::get('sdfrom') : $dfrom=date('Y-m-d');
		Session::has('sdto') ? $dto=Session::get('sdto') : $dto=date('Y-m-d') ;
		
		$salemasters = Salemasters::where('com_id',$com_id)->whereBetween('sdate', [$dfrom, $dto])->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $salemasters = $salemasters->where('user_id',Auth::id());
        }
		return view('acc.salemaster.index', compact(['salemasters', 'langs', 'client']));
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
        $mteam = Mteams::where('com_id',$com_id)->latest()->get();
		$mteams['']="Select ...";
		foreach($mteam as $data):
			$mteams[$data['id']]=$data['name'];
		endforeach;
        $wh = Warehouses::where('com_id',$com_id)->latest()->get();
		$whs['']="Select ...";
		foreach($wh as $data):
			$whs[$data['id']]=$data['name'];
		endforeach;
		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
		foreach($clients as $clients_data):
			$client[$clients_data['id']]=$clients_data['name'];
		endforeach;
		$outlet = Outlets::where('com_id',$com_id)->latest()->get();
		$outlets['']="Select ...";
		foreach($outlet as $data):
			$outlets[$data['id']]=$data['name'];
		endforeach;

		$langs = $this->language();
		return view('acc.salemaster.create', compact('langs','client', 'outlets', 'mteams','users','whs'));
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
		$option=Options::where('com_id',$com_id)->first();
		$option_cur=''; isset($option) && $option->id > 0 ? $option_cur=$option->currency_id : $option_cur='';
		Session::put('sdate', $request->get('sdate'));

		$salemaster = $request->all();
        $salemaster['user_id'] = Auth::id();
		$salemaster['com_id'] = $com_id;
		$salemaster['currency_id'] = $option_cur;
        Salemasters::create($salemaster);
		$sm=DB::table('acc_salemasters')->where('com_id',$com_id)->where('invoice',$request->get('invoice'))->first();
		$sm_id=''; isset($sm) && $sm->id > 0 ? $sm_id=$sm->id : $sm_id='';
		Session::put('siacc_id', $sm_id);
		//Session::put('sswh_id', $salemaster['wh_id']);

		return redirect('salemaster/'.$sm_id);
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
		$id> 0 ? Session::put('sm_id', $id) : '';

        $currencys = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($currencys as $data) {
            $currency[$data['id']] = $data['name'];
        }
		
		$produ = Products::where('com_id',$com_id)->lists('name', 'id');
        $group = Saledetails::where('com_id',$com_id)->where('sm_id',$id)->where('group_id','=',0)->latest()->get();
		$groups['']="Select ...";
        foreach($group as $data) {
            $groups[$data['id']] = $produ[$data['item_id']];
        }
		$unit = AccUnits::latest()->get();
		$units['']="Select ...";
        foreach($unit as $data) {
            $units[$data['id']] = $data['name'];
        }
		$mteam = Mteams::where('com_id',$com_id)->latest()->get();
		$mteams['']="Select ...";
		foreach($mteam as $data):
			$mteams[$data['id']]=$data['name'];
		endforeach;

		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
		foreach($clients as $clients_data):
			$client[$clients_data['id']]=$clients_data['name'];
		endforeach;
		
		//$product = Products::where('com_id',$com_id)->where('ptype', 'Product')->latest()->get();
			Session::has('sswh_id') ? $wh_id=Session::get('sswh_id') : $wh_id='' ;
			$product = Products::join('acc_invendetails','acc_products.id','=','acc_invendetails.item_id')->select('acc_products.*')->having(DB::raw('sum(qty)'),'>',0)
			->where('acc_products.com_id',$com_id)
			->where('war_id', $wh_id)
			->groupBy('item_id')->get();

		$productz['']="Select ...";
		foreach($product as $products_data):
			$productz[$products_data['id']]=$products_data['name'];
		endforeach;

		$acc = Acccoas::where('com_id',$com_id)->where('name','Cash and Bank')->first();
    	isset($acc->id) && $acc->id>0 ? $coas = DB::table('acc_coas')->where('com_id',$com_id)->where('id', $acc->id)->get() : 
		$coas = DB::table('acc_coas')->where('com_id',$com_id)->get();
        $coa = array(''=>'Select ...');		
        foreach ($coas as $data) {
			$coas = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $data->id)->get() ;
            foreach($coas as $data):
				if ($data->atype=='Account'):
					$coa += array($data->id => $data->name);
				endif;
				$coas = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $data->id)->get(); 
				foreach($coas as $data):
					if ($data->atype=='Account'):
						$coa += array($data->id => $data->name);
					endif;
				endforeach;			
			endforeach;
			
        }

		$langs = $this->language();
		$salemaster = Salemasters::findOrFail($id);
		return view('acc.salemaster.show', compact(['salemaster', 'langs', 'client', 'productz', 'mteams','units','currency','groups','coa']));
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

		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($currencys as $data) {
            $currency[$data['id']] = $data['name'];
        } 
        $mteam = Mteams::where('com_id',$com_id)->latest()->get();
		$mteams['']="Select ...";
		foreach($mteam as $data):
			$mteams[$data['id']]=$data['name'];
		endforeach;

		$outlet = Outlets::where('com_id',$com_id)->latest()->get();
		$outlets['']="Select ...";
		foreach($outlet as $data):
			$outlets[$data['id']]=$data['name'];
		endforeach;

		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
		foreach($clients as $clients_data):
			$client[$clients_data['id']]=$clients_data['name'];
		endforeach;
        $wh = Warehouses::where('com_id',$com_id)->latest()->get();
		$whs['']="Select ...";
		foreach($wh as $data):
			$whs[$data['id']]=$data['name'];
		endforeach;
		$langs = $this->language();
		$salemaster = Salemasters::findOrFail($id);
		return view('acc.salemaster.edit', compact(['salemaster', 'langs','client','outlets', 'mteams','currency','whs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$salemaster = Salemasters::findOrFail($id);
		$salemaster->update($request->all());
		return redirect('salemaster');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Salemasters::destroy($id);
		return redirect('salemaster');
	}
 /**
	 * Display  report.
	 *
	 * @return Response
	 */
	public function filter(Request $request)
	{
		
		Session::put('smacc_id', $request->get('acc_id'));
		Session::put('smdfrom', $request->get('dfrom'));
		Session::put('smdto', $request->get('dto'));
		
		return redirect('salemaster/report');
	}
	public function ifilter(Request $request)
	{
		
		Session::put('sdfrom', $request->get('dfrom'));
		Session::put('sdto', $request->get('dto'));
		
		return redirect('salemaster');
	}
	public function mfilter(Request $request)
	{
		
		Session::put('macc_id', $request->get('acc_id'));
		Session::put('mdfrom', $request->get('dfrom'));
		Session::put('mdto', $request->get('dto'));
		
		return redirect('salemaster/mteam');
	}
	public function clfilter(Request $request)
	{
		
		Session::put('clacc_id', $request->get('acc_id'));
		Session::put('cldfrom', $request->get('dfrom'));
		Session::put('cldto', $request->get('dto'));
		
		return redirect('salemaster/client');
	}
	public function sifilter(Request $request)
	{
		
		Session::put('siacc_id', $request->get('acc_id'));
		return redirect('salemaster/invoice');
	}
	public function tsfilter(Request $request)
	{
		
		Session::put('tsacc_id', $request->get('acc_id'));
		Session::put('tsdfrom', $request->get('dfrom'));
		Session::put('tsdto', $request->get('dto'));
		
		return redirect('salemaster/teamsale');
	}
	public function pfilter(Request $request)
	{
		
		Session::put('pacc_id', $request->get('acc_id'));
		Session::put('pdfrom', $request->get('dfrom'));
		Session::put('pdto', $request->get('dto'));
		
		return redirect('salemaster/product');
	}
	public function sbfilter(Request $request)
	{
		
		Session::put('sbacc_id', $request->get('acc_id'));
		Session::put('sbdto', $request->get('dto'));
		return redirect('salemaster/stock');
	}
	public function ofilter(Request $request)
	{
		
		Session::put('oacc_id', $request->get('acc_id'));
		Session::put('odfrom', $request->get('dfrom'));
		Session::put('odto', $request->get('dto'));
		
		return redirect('salemaster/outlet');
	}

	public function report()
	{
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Salemasters::where('com_id',$com_id)->groupBy('invoice')->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['invoice'];
        }
		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $products_data) {
            $products[$products_data['id']] = $products_data['name'];
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
		$sale = array(); //Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.salemaster.report', compact(['sale', 'langs','products','units','currency', 'invoices', 'users']));
	}
	 public function invoice()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Salemasters::where('com_id',$com_id)->groupBy('invoice')->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['invoice'];
        }
		$sale = array(); //Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.salemaster.invoice', compact(['sale', 'langs','invoices', 'users']));
	}    
	 public function challan()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Salemasters::where('com_id',$com_id)->groupBy('invoice')->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['invoice'];
        }
		$sale = Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.salemaster.challan', compact(['sale', 'langs','invoices', 'users']));
	}    
public function mteam()
	{
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Salemasters::where('com_id',$com_id)->groupBy('invoice')->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['invoice'];
        }
		$mteam = Mteams::where('com_id',$com_id)->get();
		$mteams['']="Select ...";
        foreach($mteam as $data) {
            $mteams[$data['id']] = $data['name'];
        }

		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $products_data) {
            $products[$products_data['id']] = $products_data['name'];
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
		$sale = Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.salemaster.mteam', compact(['sale', 'langs','products','units','currency', 'invoices', 'users','mteams']));
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
		$invoice = Salemasters::where('com_id',$com_id)->groupBy('invoice')->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['invoice'];
        }
		$client = Clients::where('com_id',$com_id)->get();
		$clients['']="Select ...";
        foreach($client as $data) {
            $clients[$data['id']] = $data['name'];
        }

		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $products_data) {
            $products[$products_data['id']] = $products_data['name'];
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
		$sale = Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.salemaster.client', compact(['sale', 'langs','products','units','currency', 'invoices', 'users','mteams','clients']));
	}
public function product()
	{
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Salemasters::where('com_id',$com_id)->groupBy('invoice')->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['invoice'];
        }
		$client = Clients::where('com_id',$com_id)->get();
		$clients['']="Select ...";
        foreach($client as $data) {
            $clients[$data['id']] = $data['name'];
        }

		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $products_data) {
            $products[$products_data['id']] = $products_data['name'];
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
		$sale = Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.salemaster.product', compact(['sale', 'langs','products','units','currency', 'invoices', 'users','mteams','clients']));
	}
public function outlet()
	{
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Salemasters::where('com_id',$com_id)->groupBy('invoice')->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['invoice'];
        }
		$client = Clients::where('com_id',$com_id)->get();
		$clients['']="Select ...";
        foreach($client as $data) {
            $clients[$data['id']] = $data['name'];
        }
		$outlet = Outlets::where('com_id',$com_id)->get();
		$outlets['']="Select ...";
        foreach($outlet as $data) {
            $outlets[$data['id']] = $data['name'];
        }
		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $products_data) {
            $products[$products_data['id']] = $products_data['name'];
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
		$sale = Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.salemaster.outlet', compact(['sale', 'langs','products','units','currency', 'invoices', 'users','mteams','clients','outlets']));
	}

	public function stock()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$p_group = Products::where('com_id',$com_id)->where('ptype','<>','Product')->latest()->get();
		$p_groups['']="Select ...";
        foreach($p_group as $data) {
            $p_groups[$data['id']] = $data['name'];
        } 
		$product = Products::where('com_id',$com_id)->where('topGroup_id','0')->latest()->get();
        $langs = $this->language();
		return view('acc.salemaster.stock', compact(['product', 'langs', 'p_groups']));
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
	public function invoice_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('siacc_id') ? 	$sm_id=Session::get('siacc_id') : $sm_id=''; 
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$sale = Salemasters::findOrFail($sm_id);
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.salemaster.invoice_print', compact(['sale', 'langs','users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('invoice_'.$sm_id.'.pdf');
    }
    
    public function invoice_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('siacc_id') ? 	$sm_id=Session::get('siacc_id') : $sm_id=''; 
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$sale = Salemasters::findOrFail($sm_id);
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.salemaster.invoice_print', compact(['sale', 'langs','users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('invoice_'.$sm_id.'.pdf');
    }

	public function invoice_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('sm_id') ? 
		$sm_id=Session::get('sm_id') : $sm_id='' ;// echo $com_id.'osama';
	
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$sale = Salemasters::findOrFail($sm_id);
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Invoice_".$sm_id.".doc");

		return view('acc.salemaster.invoice_word', compact(['sale', 'langs','users']));
	}
    public function invoice_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('sale', function($excel) {

            	$excel->sheet('sale', function($sheet) {
				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$langs = $this->language();
                $sheet->loadView('acc.salemaster.invoice_excel', ['langs' => $langs,'users'=>'users']);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function invoice_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('sale', function($excel) {

            	$excel->sheet('sale', function($sheet) {
				Session::has('sm_id') ? 
				$sm_id=Session::get('sm_id') : $sm_id='' ;// echo $com_id.'osama';
				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
			
				$langs = $this->language();
				$sale = Salemasters::findOrFail($sm_id);
                $sheet->loadView('acc.salemaster.invoice_excel', ['sale' => $sale->toArray(), 'langs' => $langs,'users'=>'users']);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	public function challan_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		Session::has('siacc_id') ? 	$sm_id=Session::get('siacc_id') : $sm_id=''; 

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Salemasters::where('com_id',$com_id)->groupBy('invoice')->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['invoice'];
        }
		$sale = Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.salemaster.challan_print', compact(['sale', 'langs','users','invoices']))->setOption('minimum-font-size', 10);
        return $pdf->stream('challan'.$sm_id.'.pdf');
    }
    
    public function challan_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		Session::has('siacc_id') ? 	$sm_id=Session::get('siacc_id') : $sm_id=''; 

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Salemasters::where('com_id',$com_id)->groupBy('invoice')->get();
		$invoices['']="Select ...";
        foreach($invoice as $data) {
            $invoices[$data['id']] = $data['invoice'];
        }
		$sale = Salemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.salemaster.challan_print', compact(['sale', 'langs','users','invoices']))->setOption('minimum-font-size', 10);
        return $pdf->stream('challan'.$sm_id.'.pdf');
    }

	public function challan_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('sm_id') ? 
		$sm_id=Session::get('sm_id') : $sm_id='' ;// echo $com_id.'osama';
	
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$sale = Salemasters::findOrFail($sm_id);
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Challan_".$sm_id.".doc");

		return view('acc.salemaster.challan_word', compact(['sale', 'langs','users']));
	}
    public function challan_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('challan', function($excel) {

            	$excel->sheet('challan', function($sheet) {
				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$langs = $this->language();
                $sheet->loadView('acc.salemaster.challan_excel', ['langs' => $langs,'users'=>'users']);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function challan_csv(){
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
				$sale = Salemasters::findOrFail($sm_id);
                $sheet->loadView('acc.salemaster.challan_excel', ['sale' => $sale->toArray(), 'langs' => $langs,'users'=>'users']);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	public function stock_print(){  
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
		
        $pdf = \PDF::loadView('acc.salemaster.stock_print', compact(['product', 'langs','p_groups']))->setOption('minimum-font-size', 10);
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
		
        $pdf = \PDF::loadView('acc.salemaster.stock_print', compact(['product', 'langs','p_groups']))->setOption('minimum-font-size', 10);
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

		return view('acc.salemaster.stock_word', compact(['product', 'langs','p_groups']));
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
                $sheet->loadView('acc.salemaster.challan_excel', ['langs' => $langs,'users'=>'users']);
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
                $sheet->loadView('acc.salemaster.challan_excel', ['product' => $product->toArray(), 'langs' => $langs,'users'=>'users']);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	public function check()
	{
			// uncheck
		isset($_GET['uc']) ? $uc=$_GET['uc'] : $uc='';
		//echo strpos($uc, '/').$uc.'hasan habib';
		if(strpos($uc, '/')!=0):
			$rr=explode('/',$uc);
			$find=array('sdate'=>$rr[1],'invoice'=>$rr[0]);
			$tran=DB::table('acc_salemasters')->where($find)->first(); //echo $tran->id;
			$tranmaster = Salemasters::findOrFail($tran->id);
			$data=array('check_action'=>0);
			$tranmaster->update($data);
		endif;
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
		foreach($clients as $clients_data):
			$client[$clients_data['id']]=$clients_data['name'];
		endforeach;
		$salemasters = Salemasters::where('com_id',$com_id)->where('check_action','0')->Oldest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $salemasters = $salemasters->where('user_id',Auth::id());
        }
		return view('acc.salemaster.check', compact(['salemasters', 'langs', 'client','uc_data']));
	}
	public function checked($id, Request $request)
	{
		$salemaster = Salemasters::findOrFail($id);
		$salemaster->update($request->all());
		
		return redirect('salemaster/check');

	}
	public function collection()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		Session::has('coldfrom') ? $dfrom=Session::get('coldfrom') : $dfrom='0000-00-00' ;// echo $com_id.'osama';
		Session::has('coldto') ? $dto=Session::get('coldto') : $dto='0000-00-00' ;// echo $com_id.'osama';
		Session::has('colacc_id') ? $sd_id=Session::get('colacc_id') : $sd_id='' ;// echo $com_id.'osama';

		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        }
		

		$collections = Trandetails::join('acc_coas','acc_trandetails.acc_id','=','acc_coas.id')
		->join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
		->select(DB::raw('sum(amount) as amount,name'))
		->where('acc_trandetails.com_id',$com_id)
		->where('group_id',$sd_id)
		->whereBetween('acc_tranmasters.tdate', [$dfrom, $dto])
		->where('amount','<','0')->groupBy('acc_id')->get();
		
        $langs = $this->language();
		
		return view('acc.salemaster.collection', compact(['collections', 'langs', 'acccoa']));

	}
	public function collection_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('sm_id') ? 
		$sm_id=Session::get('sm_id') : $sm_id=0 ;// echo $com_id.'osama';
	
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$sale = Salemasters::findOrFail($sm_id);
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.salemaster.challan_print', compact(['sale', 'langs','users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('challan'.$sm_id.'.pdf');
    }

/*	public function collection_print()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		Session::has('coldfrom') ? $dfrom=Session::get('coldfrom') : $dfrom='0000-00-00' ;// echo $com_id.'osama';
		Session::has('coldto') ? $dto=Session::get('coldto') : $dto='0000-00-00' ;// echo $com_id.'osama';
		Session::has('colacc_id') ? $sd_id=Session::get('colacc_id') : $sd_id='' ;// echo $com_id.'osama';

		$collections = Trandetails::join('acc_coas','acc_trandetails.acc_id','=','acc_coas.id')
		->join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
		->select(DB::raw('sum(amount) as amount,name'))
		->where('acc_trandetails.com_id',$com_id)
		->where('group_id',$sd_id)
		->whereBetween('acc_tranmasters.tdate', [$dfrom, $dto])
		->where('amount','<','0')->groupBy('acc_id')->get();
		
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.salemaster.collection_print', compact(['collections', 'langs']))->setOption('minimum-font-size', 10);
        return $pdf->stream('collection.pdf');

	}
*/	public function cfilter(Request $request)
	{
		
		Session::put('colacc_id', $request->get('acc_id'));
		Session::put('coldfrom', $request->get('dfrom'));
		Session::put('coldto', $request->get('dto'));
		
		return redirect('salemaster/collection');

	}

}