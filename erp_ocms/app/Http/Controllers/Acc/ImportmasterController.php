<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Importmasters;
use App\Models\Acc\Products;
use App\Models\Acc\Lcimports;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Currencies;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Suppliers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use DB;
use App\User;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class ImportmasterController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$importmasters = Importmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $importmasters = $importmasters->where('user_id',Auth::id());
        }
		return view('acc.importmaster.index', compact(['importmasters', 'langs']));
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

        $lcimports = Lcimports::where('com_id',$com_id)->latest()->get();
		$lcimport['']="Select ...";
		foreach($lcimports as $lcimports_data):
			$lcimport[$lcimports_data['id']]=$lcimports_data['lcnumber'];
		endforeach;
		$langs = $this->language();
		return view('acc.importmaster.create', compact('langs', 'lcimport'));
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

	    $importmaster = $request->all();
        $importmaster['user_id'] = Auth::id();
		$importmaster['com_id'] = $com_id;
        Importmasters::create($importmaster);
		$im=DB::table('acc_importmasters')->where('com_id',$com_id)->where('invoice',$request->get('invoice'))->first();
		$im_id=''; isset($im) && $im->id > 0 ? $im_id=$im->id : $im_id='';
		return redirect('importmaster/'.$im_id);
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
		
		$id> 0 ? Session::put('im_id', $id) : '';
		
		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $products_data) {
            $products[$products_data['id']] = $products_data['name'];
        }        
		$langs = $this->language();
		$importmaster = Importmasters::findOrFail($id);
		return view('acc.importmaster.show', compact(['importmaster', 'langs', 'products']));
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
	
		$lcimports=Lcimports::where('com_id',$com_id)->latest()->get();
		$lcimport['']='Select ....';
		foreach($lcimports as $lcimports_data){
			$lcimport[$lcimports_data['id']]=$lcimports_data['lcnumber'];
			}
        $langs = $this->language();
		$importmaster = Importmasters::findOrFail($id);
		return view('acc.importmaster.edit', compact(['importmaster', 'langs','lcimport']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$importmaster = Importmasters::findOrFail($id);
		$importmaster->update($request->all());
		return redirect('importmaster/'.Session::get('im_id'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Importmasters::destroy($id);
		return redirect('importmaster');
	}
	/**
	 * Display a listing of the help file.
	 *
	 * @return Response
	 */
	
	 public function help()
	{
		$importmasters = Importmasters::latest()->get();
        $langs = $this->language();
		return view('acc.importmaster.help', compact(['importmasters', 'langs','lcinfos']));
	}    
	/**
	 * Display  report.
	 *
	 * @return Response
	 */
	public function filter(Request $request)
	{
		
		Session::put('ilcacc_id', $request->get('acc_id'));
		
		return redirect('importmaster/report');
	}
	public function idfilter(Request $request)
	{
		
		Session::put('idprod_id', $request->get('prod_id'));
		Session::put('iddfrom', $request->get('dfrom'));
		Session::put('iddto', $request->get('dto'));
		
		return redirect('importmaster/imdetails');
	}
	public function csfilter(Request $request)
	{
		
		Session::put('imacc_id', $request->get('acc_id'));
		
		return redirect('importmaster/costsheet');
	}
	public function costsheet()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $products_data) {
            $products[$products_data['id']] = $products_data['name'];
        } 
		$lcimport = Lcimports::where('com_id',$com_id)->latest()->get();
		$lcimports['']="Select ...";
        foreach($lcimport as $data) {
            $lcimports[$data['id']] = $data['lcnumber'];
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
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$import = Importmasters::where('com_id',$com_id)->where('id','9999')->latest()->get();
        $langs = $this->language();
		return view('acc.importmaster.costsheet', compact(['import', 'langs','products','units','currency', 'lcimports', 'users']));
	}
	public function report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$lcimport = Lcimports::where('com_id',$com_id)->latest()->get();
		$lcimports['']="Select ...";
        foreach($lcimport as $data) {
            $lcimports[$data['id']] = $data['lcnumber'];
        } 
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
        $langs = $this->language();
		return view('acc.importmaster.report', compact(['tran', 'langs', 'acccoa', 'users','lcimports']));
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
	
	public function imdetails()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $products_data) {
            $products[$products_data['id']] = $products_data['name'];
        }        
		$langs = $this->language();
		$importmaster = Importmasters::where('com_id',$com_id)->Latest()->get();
		return view('acc.importmaster.imdetails', compact(['importmaster', 'langs', 'products']));
	}

	public function report_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$importmaster = Importmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.importmaster.imdetails_print', compact(['importmaster', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('Importdetails.pdf');
    }
    
    public function report_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$importmaster = Importmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.importmaster.imdetails_print', compact(['importmaster', 'langs', 'day']))->setOption('minimum-font-size', 16);
        return $pdf->download('Importdetails.pdf');
    }

	public function report_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$importmaster = Importmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Importdetails.doc");

		return view('acc.importmaster.imdetails_word', compact(['importmaster', 'langs']));
	}
    public function report_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Importdetails', function($excel) {

            	$excel->sheet('Importdetails', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$importmaster = Importmasters::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.importmaster.imdetails_excel', ['importmaster' => $importmaster->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function report_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('Importdetails', function($excel) {

            	$excel->sheet('Importdetails', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$importmaster = Importmasters::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.importmaster.imdetails_excel', ['importmaster' => $importmaster->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }

	public function ilcfilter(Request $request)
	{
		
		Session::put('ilcacc_id', $request->get('acc_id'));
		Session::put('ilclc_id', $request->get('lc_id'));
		
		return redirect('importmaster/ledger');

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
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$lc = Lcimports::where('com_id',$com_id)->latest()->get();
		$lcs['']="Select ...";
        foreach($lc as $data) {
            $lcs[$data['id']] = $data['lcnumber'];
        } 
		$tran = array();// Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
        $langs = $this->language();
		return view('acc.importmaster.ledger', compact(['tran', 'langs', 'acccoa', 'users','lcs']));
	}
		
	public function ledger_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.lcinfo.ledger_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 16);
        return $pdf->stream('ledger.pdf');
    }

	public function product()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $products_data) {
            $products[$products_data['id']] = $products_data['name'];
        } 
		$lcimport = Lcimports::where('com_id',$com_id)->latest()->get();
		$lcimports['']="Select ...";
        foreach($lcimport as $data) {
            $lcimports[$data['id']] = $data['lcnumber'];
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
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$import = Importmasters::where('com_id',$com_id)->where('id','9999')->latest()->get();
        $langs = $this->language();
		return view('acc.importmaster.product', compact(['import', 'langs','products','units','currency', 'lcimports', 'users']));
	}
	public function pfilter(Request $request)
	{
		Session::put('pprod_id', $request->get('prod_id'));
		Session::put('pdfrom', $request->get('dfrom'));
		Session::put('pdto', $request->get('dto'));
		return redirect('importmaster/product');
	}
	public function supplier()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $products_data) {
            $products[$products_data['id']] = $products_data['name'];
        } 
		$supplier = Suppliers::where('com_id',$com_id)->latest()->get();
		$suppliers['']="Select ...";
        foreach($supplier as $data) {
            $suppliers[$data['id']] = $data['name'];
        } 
		$lcimport = Lcimports::where('com_id',$com_id)->latest()->get();
		$lcimports['']="Select ...";
        foreach($lcimport as $data) {
            $lcimports[$data['id']] = $data['lcnumber'];
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
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$import = Importmasters::where('com_id',$com_id)->where('id','9999')->latest()->get();
        $langs = $this->language();
		return view('acc.importmaster.supplier', compact(['import', 'langs','products','units','currency', 'lcimports', 'users','suppliers']));
	}
	public function sfilter(Request $request)
	{
		Session::put('ssupplier_id', $request->get('supplier_id'));
		Session::put('sdfrom', $request->get('dfrom'));
		Session::put('sdto', $request->get('dto'));
		return redirect('importmaster/supplier');
	}

}