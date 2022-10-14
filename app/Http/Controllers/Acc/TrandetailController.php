<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Trandetails;
use App\Models\Acc\Tranmasters;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Lcinfos;
use App\Models\Acc\Orderinfos;
use App\Models\Acc\Styles;
use App\Models\Acc\Lcimports;
use App\Models\Acc\Departments;
use App\Models\Acc\Subheads;
use App\Models\Acc\Projects;
use App\Models\Acc\Companies;
use App\Models\Acc\Products;
use App\Models\Acc\Pplannings;

use DB;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class TrandetailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$trandetails = Trandetails::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $trandetails = $trandetails->where('user_id',Auth::id());
        }
		return view('acc.trandetail.index', compact(['trandetails', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('acc.trandetail.create', compact('langs'));
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
		//DB::table($request->get('shc_id'))->first();
	    if($request->get('ttype')=='Payment'):
			$trandetail = $request->all();
			$trandetail['user_id'] = Auth::id();
			$trandetail['com_id'] = $com_id;
			Trandetails::create($trandetail);
			
			// delete previous credit amount if any
			$tm_id=DB::table('acc_trandetails')
			->where('tm_id',$request->get('tm_id'))
			->where('flag',1)
			->delete();
			
			// make sum previous debit amount if any
			$amount_sum=DB::table('acc_trandetails')
			->where('tm_id',$request->get('tm_id'))
			->where('amount','>',0)
			->sum('amount');
			
			$dataC=array(
				'tm_id'  =>				$request->get('tm_id'),
				'acc_id' =>				$request->get('tranwiths_id'),
				'sh_id' =>				$request->get('shc_id'),
				'tranwiths_id' =>		$request->get('acc_id'),
				'amount' =>				-$amount_sum, //$request->get('amount'),
				'flag' =>				1,
				'com_id'=>				$com_id,
				'user_id'=>				Auth::id()
			);		 
			Trandetails::create($dataC);
			
		elseif ($request->get('ttype')=='Receipt'):
			
			$stu_id=$request->get('stu_id')=='' ? 0 : $request->get('stu_id');
			$stl_id=$request->get('stl_id')=='' ? 0 : $request->get('stl_id');
			$ord_id=$request->get('ord_id')=='' ? 0 : $request->get('ord_id');
			$lc_id=$request->get('lc_id')=='' ? 0 : $request->get('lc_id');
			
			$dataD=array(
				'tm_id'  =>				$request->get('tm_id'),
				'acc_id' =>				$request->get('acc_id'),
				'tranwiths_id' =>		$request->get('tranwiths_id'),
				'amount' =>				-$request->get('amount'),
				'rmndr_id' =>			$request->get('rmndr_id'),
				'rmndr_note' =>			$request->get('rmndr_note'),
				'rmndr_date' =>			$request->get('rmndr_date'),
				'pro_id' =>				$request->get('pro_id'),
				'sh_id' =>				$request->get('sh_id'),
				'user_id'=>				Auth::id(),
				'lc_id'  =>				$lc_id,
				'ord_id' =>				$ord_id,
				'stl_id' =>				$stl_id,
				'com_id'=>				$com_id,
				'stu_id' =>				$stu_id
			);		 
			Trandetails::create($dataD);
			
			// delete previous credit amount if any
			$tm_id=DB::table('acc_trandetails')
			->where('tm_id',$request->get('tm_id'))
			->where('flag',1)
			->delete();
			
			// make sum previous debit amount if any
			$amount_sum=DB::table('acc_trandetails')
			->where('tm_id',$request->get('tm_id'))
			->where('amount','<',0)
			->sum('amount');
			
			$dataC=array(
				'tm_id'  =>				$request->get('tm_id'),
				'acc_id' =>				$request->get('tranwiths_id'),
				'tranwiths_id' =>		$request->get('acc_id'),
				'sh_id' =>				$request->get('shc_id'),
				'flag' =>				1,
				'amount' =>				-$amount_sum,
				'com_id'=>				$com_id,
				'user_id'=>				Auth::id()
			);		 
			Trandetails::create($dataC);
			
		elseif ($request->get('ttype')=='Journal'):
			$trandetail = $request->all();
			$trandetail['user_id'] = Auth::id();
			$trandetail['com_id'] = $com_id;
			Trandetails::create($trandetail);
			
			// delete previous credit amount if any
			$tm_id=DB::table('acc_trandetails')
			->where('tm_id',$request->get('tm_id'))
			->where('flag',1)
			->delete();
			// make sum previous debit amount if any
			$amount_sum=DB::table('acc_trandetails')
			->where('tm_id',$request->get('tm_id'))
			->sum('amount');
			
			$dataC=array(
				'tm_id'  =>				$request->get('tm_id'),
				'acc_id' =>				$request->get('tranwiths_id'),
				'tranwiths_id' =>		$request->get('acc_id'),
				'sh_id' =>				$request->get('shc_id'),
				'flag' =>				1,
				'amount' =>				-$amount_sum, //$request->get('amount'),
				'com_id'=>				$com_id,
				'user_id'=>				Auth::id()
			);		 		 
			Trandetails::create($dataC);	
		elseif ($request->get('ttype')=='Opening'):
			$trandetail = $request->all();
			$trandetail['user_id'] = Auth::id();
			$trandetail['com_id'] = $com_id;
			Trandetails::create($trandetail);
			
			// delete previous credit amount if any
			$tm_id=DB::table('acc_trandetails')
			->where('tm_id',$request->get('tm_id'))
			->where('flag',1)
			->delete();
			// make sum previous debit amount if any
			$amount_sum=DB::table('acc_trandetails')
			->where('tm_id',$request->get('tm_id'))
			->sum('amount');
			
			$dataC=array(
				'tm_id'  =>				$request->get('tm_id'),
				'acc_id' =>				$request->get('tranwiths_id'),
				'tranwiths_id' =>		$request->get('acc_id'),
				'sh_id' =>				$request->get('shc_id'),
				'flag' =>				1,
				'amount' =>				-$amount_sum, //$request->get('amount'),
				'com_id'=>				$com_id,
				'user_id'=>				Auth::id()
			);
			$amount_sum!=0 ?		 		 
			Trandetails::create($dataC) : '';	

		elseif ($request->get('ttype')=='Contra'):
			
			$trandetail = $request->all();
			$trandetail['user_id'] = Auth::id();
			$trandetail['com_id'] = $com_id;
			Trandetails::create($trandetail);
			
			// delete previous credit amount if any
			$tm_id=DB::table('acc_trandetails')
			->where('tm_id',$request->get('tm_id'))
			->where('flag',1)
			->delete();
			
			// make sum previous debit amount if any
			$amount_sum=DB::table('acc_trandetails')
			->where('tm_id',$request->get('tm_id'))
			->where('amount','>',0)
			->sum('amount');
			
			$dataC=array(
				'tm_id'  =>				$request->get('tm_id'),
				'acc_id' =>				$request->get('tranwiths_id'),
				'tranwiths_id' =>		$request->get('acc_id'),
				'flag' =>				1,
				'amount' =>				-$amount_sum, //$request->get('amount'),
				'com_id'=>				$com_id,
				'user_id'=>				Auth::id()
			);		 		 
			Trandetails::create($dataC);
		endif;
			$amount_sum< 0 ? $amount_sum=substr($amount_sum, 1): '';
			$tranmast = Tranmasters::findOrFail($request->get('tm_id'));
			$data_tm_amount=array('tmamount'=>$amount_sum);
			$data_tm_amount=array('note'=>$request->get('notes'));
			$tranmast->update($data_tm_amount);
		return redirect('tranmaster/'.$request->get('tm_id'));
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
		$trandetail = Trandetails::findOrFail($id);
		return view('acc.trandetail.show', compact(['trandetail', 'langs']));
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

		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }		
		$pplanning = Pplannings::where('com_id',$com_id)->latest()->get();
		$pplannings['']="Select ...";
        foreach($pplanning as $data) {
            $pplannings[$data['id']] = $data['segment'];
        }		

        $com = Companies::where('id','<>',$com_id)->latest()->get();
		$coms['']="Select ...";
        foreach($com as $data) {
            $coms[$data['id']] = $data['name'];
        }
        $ilc = Lcimports::where('com_id',$com_id)->latest()->get();
		$ilcs['']="Select ...";
        foreach($ilc as $data) {
            $ilcs[$data['id']] = $data['lcnumber'];
        }
		$department = Departments::where('com_id',$com_id)->latest()->get();
		$departments['']="Select ...";
        foreach($department as $data) {
            $departments[$data['id']] = $data['name'];
        }
		$subhead = Subheads::where('com_id',$com_id)->latest()->get();
		$subheads['']="Select ...";
        foreach($subhead as $data) {
            $subheads[$data['id']] = $data['name'];
        }

		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
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
        foreach($order as $data) {
            $orders[$data['id']] = $data['ordernumber'];
        }
		$style = Styles::where('com_id',$com_id)->latest()->get();
		$styles['']="Select ...";
        foreach($style as $data) {
            $styles[$data['id']] = $data['name'];
        }
		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $data) {
            $projects[$data['id']] = $data['name'];
        }

		$langs = $this->language();
		$trandetail = Trandetails::findOrFail($id);
		return view('acc.trandetail.edit', compact(['trandetail', 'langs', 'acccoa', 'lcinfos', 'orders', 'styles', 'ilcs','departments','subheads','projects','coms','products','pplannings']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$trandetail = Trandetails::findOrFail($id);
		$trandetail->update($request->all());
		// update other information	
			$data=DB::table('acc_trandetails')
			->where('com_id',$com_id)
			->where('tm_id',$request->get('tm_id'))
			->where('flag',1)
			->first();
			$amount_sum='';
			if (isset($data->acc_id) && $data->acc_id>0 ):
				$tm_id=DB::table('acc_trandetails')
				->where('com_id',$com_id)
				->where('tm_id',$request->get('tm_id'))
				->where('flag',1)
				->delete();
				// make sum previous debit amount if any
				$amount_sum=DB::table('acc_trandetails')
				->where('com_id',$com_id)
				->where('tm_id',$request->get('tm_id'))
				->sum('amount');
				
				$dataC=array(
					'tm_id'  =>				$request->get('tm_id'),
					'acc_id' =>				$data->acc_id,
					'tranwiths_id' =>		$data->tranwiths_id,
					'amount' =>				-$amount_sum, //$request->get('amount'),
					'flag' =>				1,
					'com_id'=>				$com_id,
					'user_id'=>				Auth::id()
				);		
				$amount_sum!=0 ?  
				Trandetails::create($dataC) : '';
			endif;
			if($amount_sum):
				$amount_sum< 0 ? $amount_sum=substr($amount_sum, 1): '';
				$tranmast = Tranmasters::findOrFail($request->get('tm_id'));
				$data_tm_amount=array('tmamount'=>$amount_sum);
				$tranmast->update($data_tm_amount);
			endif;

		return redirect('tranmaster/'.$request->get('tm_id'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Request $request)
	{
		Trandetails::destroy($id);

		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		// update other information	
			$find=DB::table('acc_trandetails')
			->where('com_id',$com_id)
			->where('tm_id',$request->get('tm_id'))
			->where('flag',1)
			->first();
			
			$tm_id=DB::table('acc_trandetails')
			->where('com_id',$com_id)
			->where('tm_id',$request->get('tm_id'))
			->where('flag',1)
			->delete();
			// make sum previous debit amount if any
			$amount_sum=DB::table('acc_trandetails')
			->where('com_id',$com_id)
			->where('tm_id',$request->get('tm_id'))
			->sum('amount');
			if (isset($find) && $find->id>0):
			$dataC=array(
				'tm_id'  =>				$request->get('tm_id'),
				'acc_id' =>				$find->acc_id,
				'tranwiths_id' =>		$find->tranwiths_id,
				'amount' =>				-$amount_sum, //$request->get('amount'),
				'flag' =>				1,
				'com_id'=>				$com_id,
				'user_id'=>				Auth::id()
			);
			$amount_sum!=0 ? 		 
			Trandetails::create($dataC): '';
			endif;
			if ($amount_sum!=''):
				$tranmast = Tranmasters::findOrFail($request->get('tm_id'));
				$data_tm_amount=array('tmamount'=>$amount_sum);
				$tranmast->update($data_tm_amount);
			endif;
		return redirect('tranmaster/'.$request->get('tm_id'));// delete previous credit amount if any
			
		
		
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
	public function reminder()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

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
		$tranmasters = Trandetails::where('com_id',$com_id)->where('rmndr_id','>','0')->latest()->groupBy('tm_id')->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $tranmasters = $tranmasters->where('user_id',Auth::id());
        }
		return view('acc.trandetail.reminder', compact(['tranmasters', 'langs', 'acccoa','users']));
	}
	public function cashflowd()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
        $langs = $this->language();
		$transaction = array('Cash flows from operating activities','Cash flows from investing activities', 'Cash flows from financing activities','Net increase in cash and cash equivalents','Cash and cash equivalents at beginning of period','Cash and cash equivalents at end of period');
	return view('acc.trandetail.cashflowd', compact(['transaction', 'langs']));
	}
	public function cashflowid()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
        $langs = $this->language();
		$transaction = array('Cash flows from operating activities','Cash flows from investing activities', 'Cash flows from financing activities','Net increase in cash and cash equivalents','Cash and cash equivalents at beginning of period','Cash and cash equivalents at end of period');
	return view('acc.trandetail.cashflowid', compact(['transaction', 'langs']));
	}
	public function filterid(Request $request)
	{
		
		Session::put('cfdfrom', $request->get('dfrom'));
		Session::put('cfdto', $request->get('dto'));
		
		return redirect('trandetail/cashflowid');

	}
	public function filterd(Request $request)
	{
		
		Session::put('cfdfrom', $request->get('dfrom'));
		Session::put('cfdto', $request->get('dto'));
		
		return redirect('trandetail/cashflowd');

	}
	public function iofilter(Request $request)
	{
		
		Session::put('iodfrom', $request->get('dfrom'));
		Session::put('iodto', $request->get('dto'));
		
		return redirect('trandetail/ioslip');

	}

	public function ioslip()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		Session::has('iodto') ? $data=array('dfrom'=>Session::get('iodfrom'),'dto'=>Session::get('iodto')) : $data=array('dfrom'=>'0000-00-00','dto'=>'0000-00-00'); 
		// for Bank Receipt
		
		
		$bank_group=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Bank Account')->first();
		$bank_group_id=''; isset($bank_group) && $bank_group->id >0 ? $bank_group_id=$bank_group->id : $bank_group_id='';

		$mc=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Main Cash')->first();
		$mc_id=''; isset($mc) && $mc->id >0 ? $mc_id=$mc->id : $mc_id='';

		$afe=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Advance For Expenses')->first();
		$afe_id=''; isset($afe) && $afe->id >0 ? $afe_id=$afe->id : $afe_id='';
		
		$op_mc=Trandetails::join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')->where('acc_trandetails.com_id',$com_id)
		->where('acc_id',$mc_id)->where('tdate','<',$data['dfrom'])->sum('amount');
		$op_afe=Trandetails::join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')->where('acc_trandetails.com_id',$com_id)
		->where('acc_id',$afe_id)->where('tdate', '<', $data['dfrom'])->sum('amount');

		$cb_mc=Trandetails::join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')->where('acc_trandetails.com_id',$com_id)
		->where('acc_id',$mc_id)->where('tdate','<=',$data['dto'])->sum('amount');
		$cb_afe=Trandetails::join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')->where('acc_trandetails.com_id',$com_id)
		->where('acc_id',$afe_id)->where('tdate', '<=', $data['dto'])->sum('amount');

		//->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
		$bank_group=DB::table('acc_coas')->where('name','Bank Account')->first();
		$bank_group_id=''; isset($bank_group) && $bank_group->id >0 ? $bank_group_id=$bank_group->id : $bank_group_id='';
		
		$bankreceipt = Trandetails::join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
		->join('acc_coas','acc_trandetails.acc_id','=','acc_coas.id')->where('acc_trandetails.com_id',$com_id)
		->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
		->where('amount','>','0')->where('ttype','Receipt')->where('group_id',$bank_group_id)->get();
		// for Bank Payment
		$bankexpenses = Trandetails::join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
		->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
		->join('acc_coas','acc_trandetails.acc_id','=','acc_coas.id')->where('acc_trandetails.com_id',$com_id)
		->where('amount','<','0')->where('ttype','Payment')->where('group_id',$bank_group_id)->get();

		// for Cash Receipt
		$cash_group=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Cash Account')->first();
		$cash_group_id=''; isset($cash_group) && $cash_group->id >0 ? $cash_group_id=$cash_group->id : $cash_group_id='';

		$cashrecipt = Trandetails::join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
		->join('acc_coas','acc_trandetails.acc_id','=','acc_coas.id')->where('acc_id', $mc_id)
		->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])->where('acc_trandetails.com_id',$com_id)
		->where('amount','>','0')->where('group_id',$cash_group_id)->get();
		// cash expense
		$expenses = Trandetails::select('acc_trandetails.*','acc_coas.name','acc_tranmasters.vnumber')->join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
		->join('acc_coas','acc_trandetails.acc_id','=','acc_coas.id')->where('acc_id','<>',$mc_id)->where('acc_id','<>',$afe_id)
		->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])->where('acc_trandetails.com_id',$com_id)
		->where('amount','>','0')->where('ttype','Payment')->where('group_id','<>',$bank_group_id)->get();
        $langs = $this->language();
		return view('acc.trandetail.ioslip', compact(['bankreceipt','bankexpenses','cashrecipt','expenses', 'langs','op_mc','op_afe','cb_mc','cb_afe']));
	}
	
	public function afexpense()
	{
	
		isset($_GET['tdate']) ? Session::put('afdto',$_GET['tdate']) : '';
	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		Session::has('afdto') ? $data=array('dto'=>Session::get('afdto')) : $data=array('dto'=>'0000-00-00'); 

        $langs = $this->language();
		$adv=Acccoas::where('com_id',$com_id)->where('name','Advance for Expenses')->first();
		isset($adv) && $adv->id> 0 ? $adv_id=$adv->id : $adv_id='';
		Session::put('subacc_id', $adv_id);

 		$advance=Trandetails::join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')->select(DB::raw('sum(amount) as amount, acc_trandetails.sh_id'))
		->where('tdate','<=',$data['dto'])->where('acc_id',$adv_id)->groupBy('acc_trandetails.sh_id')
		->where('acc_trandetails.com_id',$com_id)->where('acc_trandetails.sh_id','>','0')->get();

	return view('acc.trandetail.afexpense', compact(['advance', 'langs']));
	}

	public function affilter(Request $request)
	{
		
		Session::put('afdfrom', $request->get('dfrom'));
		Session::put('afdto', $request->get('dto'));
		
		return redirect('trandetail/afexpense');

	}

}