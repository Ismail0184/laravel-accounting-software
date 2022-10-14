<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Purchasemasters;
use App\Models\Acc\Purchasedetails;
use App\Models\Acc\Warehouses;
use App\Models\Acc\Products;

use App\Models\Acc\AccUnits;
use App\Models\Acc\Currencies;
use App\Models\Acc\Clients;
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

class PurchasemasterController extends Controller {

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
        foreach($clients as $clients_data) {
            $client[$clients_data['id']] = $clients_data['name'];
        }    		
		$purchasemasters = Purchasemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $purchasemasters = $purchasemasters->where('user_id',Auth::id());
        }
		return view('acc.purchasemaster.index', compact(['purchasemasters', 'langs','client']));
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
		$clients = Clients::where('com_id',$com_id)->where('acc_id','>','0')->latest()->get();
		$client['']="Select ...";
        foreach($clients as $clients_data) {
            $client[$clients_data['id']] = $clients_data['name'];
        }    		
		$wh = Warehouses::where('com_id',$com_id)->latest()->get();
		$whs['']="Select ...";
        foreach($wh as $clients_data) {
            $whs[$clients_data['id']] = $clients_data['name'];
        }    		

        $langs = $this->language();
		return view('acc.purchasemaster.create', compact('langs', 'client','users','whs'));
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
			$option=DB::table('acc_options')->where('com_id',$com_id)->first();
			$option_cur_id=''; isset($option) && $option->id > 0 ? $option_cur_id=$option->currency_id : $option_cur_id='';
	//DB::table('acc_coas')->where('is',$option_cur_id)->first();
	    $purchasemaster = $request->all();
        $purchasemaster['user_id'] = Auth::id();
		$purchasemaster['com_id'] = $com_id;
		$purchasemaster['currency_id'] = $option_cur_id;
        Purchasemasters::create($purchasemaster);
		$pm=DB::table('acc_purchasemasters')->where('com_id',$com_id)->where('invoice',$request->get('invoice'))->first();
		$pm_id=''; isset($pm) && $pm->id > 0 ? $pm_id=$pm->id : $pm_id='';
		return redirect('purchasemaster/'.$pm_id);
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
	
		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
        foreach($clients as $clients_data) {
            $client[$clients_data['id']] = $clients_data['name'];
        } 
		$product = Products::where('com_id',$com_id)->where('ptype','product')->latest()->get();
		$productz['']="Select ...";
        foreach($product as $products_data) {
            $productz[$products_data['id']] = $products_data['name'];
        }		
		//$products = Products::where('ptype','product')->lists('name', 'id');
		$id> 0 ? Session::put('pm_id', $id) : '';

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
		$purchasedetail = Purchasedetails::all();
		$purchasemaster = Purchasemasters::findOrFail($id);
		return view('acc.purchasemaster.show', compact(['purchasemaster', 'langs','purchasedetail','productz','client','coa']));
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

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }

		$clients = Clients::where('com_id',$com_id)->where('acc_id','>','0')->latest()->get();
		$client['']="Select ...";
        foreach($clients as $clients_data) {
            $client[$clients_data['id']] = $clients_data['name'];
        }  
		$wh = Warehouses::where('com_id',$com_id)->latest()->get();
		$whs['']="Select ...";
        foreach($wh as $clients_data) {
            $whs[$clients_data['id']] = $clients_data['name'];
        }    		

        $langs = $this->language();
		$purchasemaster = Purchasemasters::findOrFail($id);
		return view('acc.purchasemaster.edit', compact(['purchasemaster', 'langs', 'client','users','whs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$purchasemaster = Purchasemasters::findOrFail($id);
		$purchasemaster->update($request->all());
		return redirect('purchasemaster');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Purchasemasters::destroy($id);
		return redirect('purchasemaster');
	}
	
	public function filter(Request $request)
	{
		
		Session::put('pdacc_id', $request->get('acc_id'));
		Session::put('pddfrom', $request->get('dfrom'));
		Session::put('pddto', $request->get('dto'));
		
		return redirect('purchasemaster/report');
	}
	public function pfilter(Request $request)
	{
		
		Session::put('pacc_id', $request->get('acc_id'));
		Session::put('pdfrom', $request->get('dfrom'));
		Session::put('pdto', $request->get('dto'));
		
		return redirect('purchasemaster/product');
	}

  public function help()
	{
		$purchasemasters = Purchasemasters::latest()->get();
        $langs = $this->language();
		return view('acc.purchasemaster.help', compact(['purchasemasters', 'langs']));
	}    
	/**
	 * Display  report.
	 *
	 * @return Response
	 */
	public function report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$invoice = Purchasemasters::where('com_id',$com_id)->groupBy('invoice')->get();
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
		$purchase = Purchasemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.purchasemaster.report', compact(['purchase', 'langs','products','units','currency','invoices', 'users']));
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
	public function pmdetails()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
        foreach($clients as $clients_data) {
            $client[$clients_data['id']] = $clients_data['name'];
        } 
		$product = Products::where('com_id',$com_id)->where('ptype','product')->latest()->get();
		$productz['']="Select ...";
        foreach($product as $products_data) {
            $productz[$products_data['id']] = $products_data['name'];
        }		
		//$products = Products::where('ptype','product')->lists('name', 'id');
		Session::has('pm_id') ? 
		$pm_id=Session::get('pm_id') : $pm_id='' ;// echo $com_id.'osama';
	
        $langs = $this->language();
		$purchasemaster = Purchasemasters::findOrFail($pm_id);
		return view('acc.purchasemaster.pmdetails', compact(['purchasemaster', 'langs','purchasedetail','productz','client']));
	}
	public function report_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('pm_id') ? 
		$pm_id=Session::get('pm_id') : $pm_id='' ;// echo $com_id.'osama';
	
        $langs = $this->language();
		$purchasemaster = Purchasemasters::findOrFail($pm_id);
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.purchasemaster.pmdetails_print', compact(['purchasemaster', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('Purchasemasters.pdf');
    }
    
    public function report_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('pm_id') ? 
		$pm_id=Session::get('pm_id') : $pm_id='' ;// echo $com_id.'osama';
	
        $langs = $this->language();
		$purchasemaster = Purchasemasters::findOrFail($pm_id);
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.purchasemaster.pmdetails_print', compact(['purchasemaster', 'langs', 'day']))->setOption('minimum-font-size', 16);
        return $pdf->download('Purchasemasters.pdf');
    }

	public function report_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('pm_id') ? 
		$pm_id=Session::get('pm_id') : $pm_id='' ;// echo $com_id.'osama';
	
        $langs = $this->language();
		$purchasemaster = Purchasemasters::findOrFail($pm_id);
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Purchasemasters.doc");

		return view('acc.purchasemaster.pmdetails_word', compact(['purchasemaster', 'langs']));
	}
    public function report_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Purchasemasters', function($excel) {

            	$excel->sheet('Purchasemasters', function($sheet) {
				Session::has('pm_id') ? 
				$pm_id=Session::get('pm_id') : $pm_id='' ;// echo $com_id.'osama';
			
				$langs = $this->language();
				$purchasemaster = Purchasemasters::findOrFail($pm_id);
                $sheet->loadView('acc.purchasemaster.pmdetails_excel', ['purchasemaster' => $purchasemaster->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function report_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('Purchasemasters', function($excel) {

            	$excel->sheet('Purchasemasters', function($sheet) {
				Session::has('pm_id') ? 
				$pm_id=Session::get('pm_id') : $pm_id='' ;// echo $com_id.'osama';
			
				$langs = $this->language();
				$purchasemaster = Purchasemasters::findOrFail($pm_id);
                $sheet->loadView('acc.purchasemaster.pmdetails_excel', ['purchasemaster' => $purchasemaster->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	public function checked($id, Request $request)
	{
		$purchasemaster = Purchasemasters::findOrFail($id);
		$purchasemaster->update($request->all());
		
		return redirect('purchasemaster/check');

	}
	public function check()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$clients = Clients::where('com_id',$com_id)->latest()->get();
		$client['']="Select ...";
        foreach($clients as $clients_data) {
            $client[$clients_data['id']] = $clients_data['name'];
        }    		
		$purchasemasters = Purchasemasters::where('com_id',$com_id)->where('check_action','0')->where('check_id',Auth::id())->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $purchasemasters = $purchasemasters->where('user_id',Auth::id());
        }
		return view('acc.purchasemaster.check', compact(['purchasemasters', 'langs','client']));
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
		$invoice = Purchasemasters::where('com_id',$com_id)->groupBy('invoice')->get();
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
		$purchase = Purchasemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.purchasemaster.product', compact(['purchase', 'langs','products','units','currency','invoices', 'users']));
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
		$invoice = Purchasemasters::where('com_id',$com_id)->groupBy('invoice')->get();
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
		$client = Clients::where('com_id',$com_id)->latest()->get();
		$clients['']="Select ...";
        foreach($client as $data) {
            $clients[$data['id']] = $data['name'];
        } 
		$purchase = Purchasemasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.purchasemaster.client', compact(['purchase', 'langs','products','units','currency','invoices', 'users','clients']));
	}
	public function clfilter(Request $request)
	{
		
		Session::put('clacc_id', $request->get('acc_id'));
		Session::put('cldfrom', $request->get('dfrom'));
		Session::put('cldto', $request->get('dto'));
		
		return redirect('purchasemaster/client');
	}
	public function payment()
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
		->where('amount','>','0')->groupBy('acc_id')->get();
		
        $langs = $this->language();
		
		return view('acc.purchasemaster.collection', compact(['collections', 'langs', 'acccoa']));

	}
	public function collection_print()
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
		->where('amount','>','0')->groupBy('acc_id')->get();
		
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.purchasemaster.collection_print', compact(['collections', 'langs']))->setOption('minimum-font-size', 10);
        return $pdf->stream('collection.pdf');

	}
	public function payfilter(Request $request)
	{
		
		Session::put('colacc_id', $request->get('acc_id'));
		Session::put('coldfrom', $request->get('dfrom'));
		Session::put('coldto', $request->get('dto'));
		
		return redirect('purchasemaster/payment');

	}

}