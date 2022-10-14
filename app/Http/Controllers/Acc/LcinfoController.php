<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Lcinfos;
use App\Models\Acc\Buyerinfos;
use App\Models\Acc\Countries;
use App\Models\Acc\Currencies;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Trandetails;
use App\Models\Acc\Tranmasters;

use App\User;

use Illuminate\Http\Request;
use Carbon\Carbon;

use DB;
use Session; 
use Response;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class LcinfoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$unit = AccUnits::latest()->get();
		$units['0']="";
		foreach($unit as $data):
			$units[$data['id']]=$data['name'];
		endforeach;
		$buyers=Buyerinfos::lists('name', 'id');
		
		$lcinfos = Lcinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
		
        if($user_only && !$admin_user) {
            $lcinfos = $lcinfos->where('user_id',Auth::id());
        }
		return view('acc.lcinfo.index', compact(['lcinfos', 'langs','buyers', 'units']));
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

		$buyer = Buyerinfos::where('com_id',$com_id)->latest()->get();
		$buyers['']="Select ...";
		foreach($buyer as $buyer_data):
			$buyers[$buyer_data['id']]=$buyer_data['name'];
		endforeach;
		$countrys = Countries::latest()->get();
		$country['']="Select ...";
		foreach($countrys as $data):
			$country[$data['id']]=$data['name'];
		endforeach;
		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
		foreach($currencys as $data):
			$currency[$data['id']]=$data['name'];
		endforeach;
		$unit = AccUnits::latest()->get();
		$units['']="Select ...";
		foreach($unit as $data):
			$units[$data['id']]=$data['name'];
		endforeach;
		
        $langs = $this->language();
		return view('acc.lcinfo.create', compact('langs','buyers', 'country', 'currency', 'units'));
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
		
		if($request->get('acc_id')):
			$data=array(
			'vnumber'	=>	$request->get('vnumber'),
			'tdate'	=>	$request->get('tdate'),
			'tranwith_id'	=>	$request->get('tranwith_id'),
			'check_id'	=>	$request->get('check_id'),
			'tmamount'	=>	$request->get('tmamount'),
			'note'	=>	$request->get('note'),
			'currency_id'	=>	$request->get('currency_id'),
			'ttype'	=>	'Journal',
			'user_id'	=>	Auth::id(),
			'com_id'	=>	$com_id
			);
			Tranmasters::create($data);
			$tm_id=DB::table('acc_tranmasters')->where('vnumber',$request->get('vnumber'))->where('com_id',$com_id)->first();
			
			$dataD=array(
			'tm_id'	=>	$tm_id->id,
			'acc_id'	=>	$request->get('acc_id'),
			'tranwiths_id'	=>	$request->get('tranwith_id'),
			'lc_id'	=>	$request->get('lc_id'),
			'b2b_id'	=>	$request->get('b2b_id'),
			'amount'	=>	$request->get('tmamount'),
			'user_id'	=>	Auth::id(),
			'com_id'	=>	$com_id
			);
			Trandetails::create($dataD);
			$dataC=array(
			'tm_id'	=>	$tm_id->id,
			'acc_id'	=>	$request->get('tranwith_id'),
			'tranwiths_id'	=>	$request->get('acc_id'),
			'lc_id'	=>	$request->get('lc_id'),
			'b2b_id'	=>	$request->get('b2b_id'),
			'amount'	=>	-$request->get('tmamount'),
			'user_id'	=>	Auth::id(),
			'flag'	=>	'1',
			'com_id'	=>	$com_id
			);
			Trandetails::create($dataC);			
			if ($request->get('td_id')>0):
				$sis_action=array(
				'sis_action'=>1
				);
				$trandetails = Trandetails::findOrFail($request->get('td_id'));
				$trandetails->update($sis_action);
			endif;
				
				return redirect('tranmaster');
	
		else:
			$lcinfo = $request->all();
			$lcinfo['user_id'] = Auth::id();
			 $lcinfo['com_id'] = $com_id;
			Lcinfos::create($lcinfo);
		endif;
		return redirect('lcinfo');
	}
	public function transaction(Request $request)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		//return redirect('lcinfo');
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

		$countrys = Countries::latest()->get();
		$country['']="Select ...";
		foreach($countrys as $data):
			$country[$data['id']]=$data['name'];
		endforeach;
		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
		foreach($currencys as $data):
			$currency[$data['id']]=$data['name'];
		endforeach;
		
		$unit = AccUnits::latest()->get();
		$units['']="Select ...";
		foreach($unit as $data):
			$units[$data['id']]=$data['name'];
		endforeach;
		
		$user = User::latest()->get();
		$users['']="Select ...";
		foreach($user as $data):
			$users[$data['id']]=$data['name'];
		endforeach;
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$buyers=Buyerinfos::lists('name', 'id');
        $langs = $this->language();
		$lcinfo = Lcinfos::findOrFail($id);
		return view('acc.lcinfo.show', compact(['lcinfo', 'langs','buyers', 'country', 'currency', 'units','acccoa','users']));
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

		$countrys = Countries::latest()->get();
		$country['']="Select ...";
		foreach($countrys as $data):
			$country[$data['id']]=$data['name'];
		endforeach;
		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
		foreach($currencys as $data):
			$currency[$data['id']]=$data['name'];
		endforeach;
		
		$unit = AccUnits::latest()->get();
		$units['']="Select ...";
		foreach($unit as $data):
			$units[$data['id']]=$data['name'];
		endforeach;

		$buyer = Buyerinfos::where('com_id',$com_id)->latest()->get();
		$buyers['']="Select ...";
		foreach($buyer as $data):
			$buyers[$data['id']]=$data['name'];
		endforeach;
		//$buyers=Buyerinfos::where('com_id',$com_id)->lists('name', 'id');
        $langs = $this->language();
		$lcinfo = Lcinfos::findOrFail($id);
		return view('acc.lcinfo.edit', compact(['lcinfo', 'langs','buyers', 'country', 'currency', 'units']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$lcinfo = Lcinfos::findOrFail($id);
		$lcinfo->update($request->all());
		return redirect('lcinfo');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Lcinfos::destroy($id);
		return redirect('lcinfo');
	}
    
	/**
	 * Display a listing of the help file.
	 *
	 * @return Response
	 */
	
	 public function help()
	{
		$lcinfos = Lcinfos::latest()->get();
        $langs = $this->language();
		return view('acc.lcinfo.help', compact(['acccoas', 'langs','lcinfos']));
	}
	 public function costsheet()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$lcinfo = Lcinfos::where('com_id',$com_id)->latest()->get();
		$lcinfos['']="Select ...";
        foreach($lcinfo as $data) {
            $lcinfos[$data['id']] = $data['lcnumber'];
        } 


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
		$tran = Acccoas::where('group_id',0)->groupBy('id')->get();
        $langs = $this->language();
		return view('acc.lcinfo.costsheet', compact(['tran', 'langs', 'acccoa', 'users', 'lcinfos', 'lcinfos']));
	}
	public function csfilter(Request $request)
	{
		
		Session::put('cslc_id', $request->get('lc_id'));
		Session::put('csord_id', $request->get('ord_id'));
		
		return redirect('lcinfo/costsheet');

	}

	/**
	 * to get report.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function filter(Request $request)
	{
		
		Session::put('lgacc_id', $request->get('acc_id'));
		Session::put('lglc_id', $request->get('lc_id'));
		
		return redirect('lcinfo/ledger');

	}

	public function report()
	{
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$buyer = Buyerinfos::where('com_id',$com_id)->latest()->get();
		$buyers['']="Select ...";
        foreach($buyer as $data) {
            $buyers[$data['id']] = $data['name'];
        } 
		$countrys = Countries::latest()->get();
		$country['']="Select ...";
        foreach($countrys as $data) {
            $country[$data['id']] = $data['name'];
        } 
		$lcinfo = Lcinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.lcinfo.report', compact(['lcinfo', 'langs','buyers','country']));
	}

		
		public function lcfilter(Request $request)
	{
		
		Session::put('lcacc_id', $request->get('acc_id'));
		Session::put('lclc_id', $request->get('lc_id'));
		
		return redirect('lcinfo/ledger');

	}

	public function report_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$lcinfo = Lcinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.lcinfo.print', compact(['lcinfo', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('Lcinfo.pdf');
    }
    
    public function report_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$lcinfo = Lcinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.lcinfo.print', compact(['lcinfo', 'langs', 'day']))->setOption('minimum-font-size', 16);
        return $pdf->download('Lcinfo.pdf');
    }

	public function report_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$lcinfo = Lcinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Lcinfo.doc");

		return view('acc.lcinfo.word', compact(['lcinfo', 'langs']));
	}
    public function report_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Lcinfo', function($excel) {

            	$excel->sheet('lcinfo', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$lcinfo = Lcinfos::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.lcinfo.excel', ['lcinfo' => $lcinfo->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function report_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('Lcinfo', function($excel) {

            	$excel->sheet('lcinfo', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$lcinfo = Lcinfos::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.lcinfo.excel', ['lcinfo' => $lcinfo->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
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
		$lc = Lcinfos::where('com_id',$com_id)->latest()->get();
		$lcs['']="Select ...";
        foreach($lc as $data) {
            $lcs[$data['id']] = $data['lcnumber'];
        } 
		$tran = array(); //Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
        $langs = $this->language();
		return view('acc.lcinfo.ledger', compact(['tran', 'langs', 'acccoa', 'users','lcs']));
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
	public function byrfilter(Request $request)
	{
		
		Session::put('brbuyer_id', $request->get('buyer_id'));
		Session::put('brcountry_id', $request->get('country_id'));
		Session::put('brdfrom', $request->get('dfrom'));
		Session::put('brdto', $request->get('dto'));
		
		return redirect('lcinfo/report');

	}

}