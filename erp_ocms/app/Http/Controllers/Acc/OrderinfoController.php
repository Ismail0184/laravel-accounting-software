<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Orderinfos;
use App\Models\Acc\Buyerinfos;
use App\Models\Acc\Lcinfos;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Trandetails;
use App\Models\Acc\Currencies;

use App\User;

use Illuminate\Http\Request;
use Carbon\Carbon;

use DB;
use Session; 
use Response;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class OrderinfoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$lc = Lcinfos::where('com_id',$com_id)->latest()->get();
		$lcs['']="Select ...";
		foreach($lc as $lc_data):
			$lcs[$lc_data['id']]=$lc_data['lcnumber'];
		endforeach;
		$orderinfos = Orderinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $orderinfos = $orderinfos->where('user_id',Auth::id());
        }
		return view('acc.orderinfo.index', compact(['orderinfos', 'langs','lcs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
		foreach($currencys as $data):
			$currency[$data['id']]=$data['name'];
		endforeach;

		$unit = Accunits::latest()->get();
		$units['']="Select ...";
		foreach($unit as $data):
			$units[$data['id']]=$data['name'];
		endforeach;

		$lc = Lcinfos::where('com_id',$com_id)->latest()->get();
		$lcs['']="Select ...";
		foreach($lc as $lc_data):
			$lcs[$lc_data['id']]=$lc_data['lcnumber'];
		endforeach;
		
        $langs = $this->language();
		return view('acc.orderinfo.create', compact('langs', 'lcs', 'currency','units'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response 
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

	    $orderinfo = $request->all();
        $orderinfo['user_id'] = Auth::id();
		$currencys=DB::table('acc_lcinfos')->where('id',$request->get('lc_id'))->first(); 
		$currency_id=''; isset($currencys) && $currencys->id > 0 ? $currency_id=$currencys->currency_id : $currency_id='';
		
		$orderinfo['currency_id'] = $currency_id;
		$orderinfo['com_id'] = $com_id;
        Orderinfos::create($orderinfo);
		return redirect('orderinfo');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $langs = $this->language();
		$orderinfo = Orderinfos::findOrFail($id);
		return view('acc.orderinfo.show', compact(['orderinfo', 'langs']));
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
		$com_id=Session::get('com_id') : $com_id='' ;

		$unit = Accunits::latest()->get();
		$units['']="Select ...";
		foreach($unit as $data):
			$units[$data['id']]=$data['name'];
		endforeach;
		$lc = Lcinfos::where('com_id',$com_id)->latest()->get();
		$lcs['']="Select ...";
		foreach($lc as $lc_data):
			$lcs[$lc_data['id']]=$lc_data['lcnumber'];
		endforeach;
		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
		foreach($currencys as $data):
			$currency[$data['id']]=$data['name'];
		endforeach;
        $langs = $this->language();
		$orderinfo = Orderinfos::findOrFail($id);
		return view('acc.orderinfo.edit', compact(['orderinfo', 'langs','lcs','currency','units']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$orderinfo = Orderinfos::findOrFail($id);
		$orderinfo->update($request->all());
		return redirect('orderinfo');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Orderinfos::destroy($id);
		return redirect('orderinfo');
	}
/**
	 * to get Help.
	 *
	 * @param  int  $id
	 * @return Response
	 */


 public function help()
	{
		$Orderinfos = Orderinfos::latest()->get();
        $langs = $this->language();
		return view('acc.orderinfo.help', compact(['Orderinfos', 'langs']));
	} 
	   
 public function costsheet()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        }
		$lcinfo = Lcinfos::where('com_id',$com_id)->latest()->get();
		$lcinfos['']="Select ...";
        foreach($lcinfo as $data) {
            $lcinfos[$data['id']] = $data['lcnumber'];
        } 
		$order = Orderinfos::where('com_id',$com_id)->latest()->get();
		$orders['']="Select ...";
        foreach($lcinfo as $data) {
            $orders[$data['id']] = $data['lcnumber'];
        } 
		$tran = Trandetails::where('ord_id','>',0)->groupBy('id')->get();
        $langs = $this->language();
		return view('acc.orderinfo.costsheet', compact(['tran', 'langs', 'acccoa', 'users', 'coa', 'lcinfos', 'orders']));
	}
	public function filter(Request $request)
	{
		
		Session::put('oacc_id', $request->get('acc_id'));
		
		return redirect('orderinfo/costsheet');

	}

	/**
	 * to get report.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$lcinfo = Lcinfos::where('com_id',$com_id)->latest()->get();
		$lcinfos['']="Select ...";
        foreach($lcinfo as $data) {
            $lcinfos[$data['id']] = $data['lcnumber'];
        } 
		$order = Orderinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.orderinfo.report', compact(['order', 'langs','lcinfos']));
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
	
		
	public function report_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$order = Orderinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.orderinfo.print', compact(['order', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('Orderinfo.pdf');
    }
    
    public function report_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$order = Orderinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.orderinfo.print', compact(['order', 'langs', 'day']))->setOption('minimum-font-size', 16);
        return $pdf->download('Orderinfo.pdf');
    }

	public function report_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$order = Orderinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Orderinfo.doc");

		return view('acc.orderinfo.word', compact(['order', 'langs']));
	}
    public function report_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Orderinfo', function($excel) {

            	$excel->sheet('Orderinfo', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$order = Orderinfos::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.orderinfo.excel', ['order' => $order->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function report_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('Orderinfo', function($excel) {

            	$excel->sheet('Orderinfo', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$order = Orderinfos::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.orderinfo.excel', ['order' => $order->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }

	public function orfilter(Request $request)
	{
		
		Session::put('orlc_id', $request->get('lc_id'));
	
		return redirect('orderinfo/report');

	}

}