<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Tranmasters;
use App\Models\Acc\Trandetails;
use App\Models\Acc\Prequisitions;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Lcinfos;
use App\Models\Acc\Orderinfos;
use App\Models\Acc\Styles;
use App\Models\Acc\Subheads;
use App\Models\Acc\Projects;
use App\Models\Acc\Lcimports;
use App\Models\Acc\Currencies;
use App\Models\Acc\Departments;
use App\Models\Acc\Companies;
use App\Models\Acc\Products;

use App\User;
use DB;
use Session; 
use Response;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class TranmasterController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
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
		$tranmasters = Tranmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $tranmasters = $tranmasters->where('user_id',Auth::id());
        }
		
		return view('acc.tranmaster.index', compact(['tranmasters', 'langs', 'acccoa','users']));
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

		$shs = Subheads::where('com_id',$com_id)->latest()->get();
		$sh['']="Select ...";
        foreach($shs as $data) {
            $sh[$data['id']] = $data['name'];
        } 
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
		$req = Prequisitions::where('com_id',$com_id)->where('check_action',1)->where('paid','')->latest()->get();
		$reqs['']="Select ...";
        foreach($req as $req_data) {
            $reqs[$req_data['id']] = $req_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$shs = Subheads::where('com_id',$com_id)->latest()->get();
		$sh['']="Select ...";
        foreach($shs as $data) {
            $sh[$data['id']] = $data['name'];
        } 
		$langs = $this->language();
		return view('acc.tranmaster.create', compact('langs','acccoa', 'users', 'reqs', 'sh','currency','coa','sh'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		Session::put('ttdate', $request->get('tdate'));
		// for Voucher Number
		$vnumber = DB::table('acc_tranmasters')->where('com_id',$com_id)->max('vnumber')+1;  
		//echo $vnumber; //exit;
		//-----------------------------------
	    $tranmaster = $request->all();
        $tranmaster['vnumber'] = $vnumber;
        $tranmaster['user_id'] = Auth::id();
		$tranmaster['com_id'] = $com_id;
        Tranmasters::create($tranmaster);
		// requisition
		if ($request->get('req_id')!=''):
			$udate_requisition=Prequisitions::findOrFail($request->get('req_id'));
			$data=array('paid'=>1);
			$udate_requisition->update($data);
		endif;
		//------------------------------------------------
		$tm_id=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('vnumber',$vnumber)->first();
		return redirect('tranmaster/'.$tm_id->id);
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

		$sister = Companies::where('id','<>',$com_id)->latest()->get();
		$sisters['']="Select ...";
        foreach($sister as $data) {
            $sisters[$data['id']] = $data['name'];
        }
		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($currencys as $data) {
            $currency[$data['id']] = $data['name'];
        } 
		$department = Departments::where('com_id',$com_id)->latest()->get();
		$departments['']="Select ...";
        foreach($department as $data) {
            $departments[$data['id']] = $data['name'];
        } 
		$shs = Subheads::where('com_id',$com_id)->latest()->get();
		$sh['']="Select ...";
        foreach($shs as $data) {
            $sh[$data['id']] = $data['name'];
        } 
		$projects = Projects::where('com_id',$com_id)->latest()->get();
		$project['']="Select ...";
        foreach($projects as $data) {
            $project[$data['id']] = $data['name'];
        }		
		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }		

		$lc = Lcinfos::where('com_id',$com_id)->latest()->get();
		$lcs['']="Select ...";
        foreach($lc as $lc_data) {
            $lcs[$lc_data['id']] = $lc_data['lcnumber'];
        }
		$ilc = Lcimports::where('com_id',$com_id)->latest()->get();
		$ilcs['']="Select ...";
        foreach($ilc as $data) {
            $ilcs[$data['id']] = $data['lcnumber'];
        }
		$ord = Orderinfos::where('com_id',$com_id)->latest()->get();
		$ords['']="Select ...";
        foreach($ord as $ord_data) {
            $ords[$ord_data['id']] = $ord_data['ordernumber'];
        }
		$stl = Styles::where('com_id',$com_id)->latest()->get();
		$stls['']="Select ...";
        foreach($stl as $stl_data) {
            $stls[$stl_data['id']] = $stl_data['name'];
        }
		$req = Prequisitions::where('com_id',$com_id)->where('paid',0)->latest()->get();
		$reqs['']="Select ...";
        foreach($req as $req_data) {
            $reqs[$req_data['id']] = $req_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        }
		//$user=User::lists('id', 'name'); 
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
        $langs = $this->language();
		$tranmaster = Tranmasters::findOrFail($id);
		return view('acc.tranmaster.show', compact(['tranmaster', 'langs', 'acccoa', 'users', 'reqs', 'lcs', 'ords', 'stls','sh','project', 'ilcs','currency','departments','sisters','products']));
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
		$shs = Subheads::where('com_id',$com_id)->latest()->get();
		$sh['']="Select ...";
        foreach($shs as $data) {
            $sh[$data['id']] = $data['name'];
        } 
		$ilc = Lcimports::where('com_id',$com_id)->latest()->get();
		$ilcs['']="Select ...";
        foreach($ilc as $data) {
            $ilcs[$data['id']] = $data['lcnumber'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$req = Prequisitions::where('com_id',$com_id)->latest()->get();
		$reqs['']="Select ...";
        foreach($req as $req_data) {
            $reqs[$req_data['id']] = $req_data['name'];
        }
		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($req as $req_data) {
            $projects[$req_data['id']] = $req_data['name'];
        }
		$sister = Companies::latest()->get();
		$sisters['']="Select ...";
        foreach($sister as $data) {
            $sisters[$data['id']] = $data['name'];
        }
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$tranmaster = Tranmasters::findOrFail($id);
		return view('acc.tranmaster.edit', compact(['tranmaster', 'langs','users', 'reqs','acccoa', 'ilcs','currency','projects','sisters','sh']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$tranmaster = Tranmasters::findOrFail($id);
			if ($request->get('sh_id')>0): 
				DB::table('acc_trandetails')->where('tm_id', $id)->where('flag', 1)->update(['sh_id' => $request->get('sh_id')]);
			endif;
		$tranmaster->update($request->all());
		// requisition
		$find=DB::table('acc_prequisitions')->where('id',$request->get('req_id'))->first();
		$find_paid=''; isset($find) && $find->paid == 0 ? $find_paid=$find->paid : $find_paid='';
		if ($request->get('req_id')!='' && $find_paid=''):
			$udate_requisition=Prequisitions::findOrFail($request->get('req_id'));
			$data=array('paid'=>1);
			$udate_requisition->update($data);
		endif;
		//------------------------------------------------
		
		return redirect('tranmaster');
	}
	public function checked($id, Request $request)
	{
		$tranmaster = Tranmasters::findOrFail($id);
		$tranmaster->update($request->all());
		
		return redirect('tranmaster/checkby');

	}
	public function techecked($id, Request $request)
	{
		$tranmaster = Tranmasters::findOrFail($id);
		$tranmaster->update($request->all());
		
		return redirect('tranmaster/techeckby');

	}
	
	public function approved($id, Request $request)
	{
		$tranmaster = Tranmasters::findOrFail($id);
		$tranmaster['appr_id'] = Auth::id();
		$tranmaster->update($request->all());
		
		return redirect('tranmaster/approveby');

	}

	public function audited($id, Request $request)
	{
		$tranmaster = Tranmasters::findOrFail($id);
		$tranmaster['audit_id'] = Auth::id();
		$tranmaster->update($request->all());
		
		return redirect('tranmaster/auditby');

	}
	public function filter(Request $request)
	{
		
		Session::put('acc_id', $request->get('acc_id'));
		Session::put('dfrom', $request->get('dfrom'));
		Session::put('dto', $request->get('dto'));
		
		return redirect('tranmaster/ledger');

	}
	public function tfilter(Request $request)
	{
		
		Session::put('tbacc_id', $request->get('acc_id'));
		Session::put('tbdto', $request->get('dto'));
		
		return redirect('tranmaster/trialbalance');

	}
	public function bfilter(Request $request)
	{
		
		Session::put('bacc_id', $request->get('acc_id'));
		Session::put('bdto', $request->get('dto'));
		
		return redirect('tranmaster/balancesheet');

	}
	public function pfilter(Request $request)
	{
		
		Session::put('pacc_id', $request->get('acc_id'));
		Session::put('pdfrom', $request->get('dfrom'));
		Session::put('pdto', $request->get('dto'));
		
		return redirect('tranmaster/profitloss');

	}
	public function trfilter(Request $request)
	{
		
		Session::put('tracc_id', $request->get('acc_id'));
		Session::put('trdfrom', $request->get('dfrom'));
		Session::put('trdto', $request->get('dto'));
		
		return redirect('tranmaster/trading');

	}

	public function mfilter(Request $request)
	{
		
		Session::put('macc_id', $request->get('acc_id'));
		Session::put('mdfrom', $request->get('dfrom'));
		Session::put('mdto', $request->get('dto'));
		
		return redirect('tranmaster/manufacturing');
	}
	public function plfilter(Request $request)
	{
		
		Session::put('placc_id', $request->get('acc_id'));
		Session::put('pldfrom', $request->get('dfrom'));
		Session::put('pldto', $request->get('dto'));
		
		return redirect('tranmaster/pldistribution');
	}
	public function rfilter(Request $request)
	{
		
		Session::put('racc_id', $request->get('acc_id'));
		Session::put('rdfrom', $request->get('dfrom'));
		Session::put('rdto', $request->get('dto'));
		
		return redirect('tranmaster/receiptpayment');
	}
	public function crfilter(Request $request)
	{
		
		Session::put('cracc_id', $request->get('acc_id'));
		Session::put('crdfrom', $request->get('dfrom'));
		Session::put('crdto', $request->get('dto'));
		
		return redirect('tranmaster/cheqregister');
	}
	public function tmfilter(Request $request)
	{
		
		Session::put('tmdfrom', $request->get('dfrom'));
		Session::put('tmdto', $request->get('dto'));
		
		return redirect('tranmaster');
	}
	public function depfilter(Request $request)
	{
		
		Session::put('depacc_id', $request->get('acc_id'));
		Session::put('depdep_id', $request->get('dep_id'));
		Session::put('depdfrom', $request->get('dfrom'));
		Session::put('depdto', $request->get('dto'));
		
		return redirect('tranmaster/department');
	}
	public function subfilter(Request $request)
	{
		
		Session::put('subacc_id', $request->get('acc_id'));
		Session::put('subsh_id', $request->get('sh_id'));
		Session::put('subdfrom', $request->get('dfrom'));
		Session::put('subdto', $request->get('dto'));
		
		return redirect('tranmaster/subhead');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Tranmasters::destroy($id);
		return redirect('tranmaster');
	}
  public function help()
	{
		$tranmasters = Tranmasters::latest()->get();
        $langs = $this->language();
		return view('acc.tranmaster.help', compact(['tranmasters', 'langs']));
	}    
	public function techeckby()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		// uncheck
		isset($_GET['uc']) ? $uc=$_GET['uc'] : $uc='';
		//echo strpos($uc, '/').$uc.'hasan habib';
		if(strpos($uc, '/')!=0):
			$rr=explode('/',$uc);
			$find=array('tdate'=>$rr[0],'vnumber'=>$rr[1]);
			$tran=DB::table('acc_tranmasters')->where($find)->first(); //echo $tran->id;
			$tranmaster = Tranmasters::findOrFail($tran->id);
			$data=array('check_action'=>0);
			$tranmaster->update($data);
		endif;

		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$req = Prequisitions::where('com_id',$com_id)->latest()->get();
		$reqs['']="Select ...";
        foreach($req as $req_data) {
            $reqs[$req_data['id']] = $req_data['name'];
        }
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$tranmasters = Tranmasters::where('com_id',$com_id)->where('check_id','0')->where('techeck_id',Auth::id())->where('tmamount','>','0')->latest()->get();
        $langs = $this->language();
		return view('acc.tranmaster.techeckby', compact(['tranmasters', 'langs', 'acccoa', 'users', 'reqs' ]));
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
			$find=array('tdate'=>$rr[0],'vnumber'=>$rr[1]);
			$tran=DB::table('acc_tranmasters')->where($find)->first(); //echo $tran->id;
			$tranmaster = Tranmasters::findOrFail($tran->id);
			$data=array('check_action'=>0);
			$tranmaster->update($data);
		endif;

		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$req = Prequisitions::where('com_id',$com_id)->latest()->get();
		$reqs['']="Select ...";
        foreach($req as $req_data) {
            $reqs[$req_data['id']] = $req_data['name'];
        }
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$tranmasters = Tranmasters::where('com_id',$com_id)->where('check_action','')->where('check_id',Auth::id())->where('tmamount','>','0')->latest()->get();
        $langs = $this->language();
		return view('acc.tranmaster.checkby', compact(['tranmasters', 'langs', 'acccoa', 'users', 'reqs' ]));
	} 
	
	public function approveby()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$req = Prequisitions::where('com_id',$com_id)->latest()->get();
		$reqs['']="Select ...";
        foreach($req as $req_data) {
            $reqs[$req_data['id']] = $req_data['name'];
        }
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$tranmasters = Tranmasters::where('com_id',$com_id)
		->where('appr_action','')->where('check_action','1')
		->where('appr_id',Auth::id())->latest()->get();
        $langs = $this->language();
		return view('acc.tranmaster.approveby', compact(['tranmasters', 'langs', 'acccoa', 'users', 'reqs' ]));
	} 
	
	public function auditby()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$req = Prequisitions::where('com_id',$com_id)->latest()->get();
		$reqs['']="Select ...";
        foreach($req as $req_data) {
            $reqs[$req_data['id']] = $req_data['name'];
        }
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$tranmasters = Tranmasters::where('com_id',$com_id)->where('audit_action','')->where('appr_action','1')->latest()->get();
        $langs = $this->language();
		return view('acc.tranmaster.auditby', compact(['tranmasters', 'langs', 'acccoa', 'users', 'reqs' ]));
	}
	/**
	 * to get report.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function ledger()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		Session::has('pettycash_id') ? $pettycash_id=Session::get('pettycash_id') : $pettycash_id='' ;

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		
		$admin_user = Auth::user()->can('admin_user');
		$where=array();
		if(Auth::user()->can('petty_cash') && $pettycash_id!='' && !$admin_user):
			$where=array('id'=>$pettycash_id);
		endif;
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->where($where)->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
        $langs = $this->language();
		return view('acc.tranmaster.ledger', compact(['tran', 'langs', 'acccoa', 'users']));
	}
	public function trialbalance()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

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
		$tran = Acccoas::where('com_id',$com_id)->where('topGroup_id',0)->groupBy('id')->get();
        $langs = $this->language();
		return view('acc.tranmaster.trialbalance', compact(['tran', 'langs', 'acccoa', 'users']));
	}
public function profitloss()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Account')->groupBy('id')->get();
        $langs = $this->language();
		return view('acc.tranmaster.profitloss', compact(['tran', 'langs', 'acccoa', 'users']));
	}
public function trading()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Trading Account')->groupBy('sl')->get();
        $langs = $this->language();
		return view('acc.tranmaster.trading', compact(['tran', 'langs', 'acccoa', 'users']));
	}
public function pldistribution()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Distribution Account')->groupBy('id')->get();
        $langs = $this->language();
		return view('acc.tranmaster.pldistribution', compact(['tran', 'langs', 'acccoa', 'users']));
	}

public function manufacturing()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Manufacturing Account')->groupBy('id')->get();
        $langs = $this->language();
		return view('acc.tranmaster.manufacturing', compact(['tran', 'langs', 'acccoa', 'users']));
	}

	public function balancesheet()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Balance Sheet')->groupBy('id')->get();
        $langs = $this->language();
		return view('acc.tranmaster.balancesheet', compact(['tran', 'langs', 'acccoa', 'users']));
	}
	public function receiptpayment()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$acc='';
		$acc = Acccoas::where('com_id',$com_id)->where('name','Cash and Bank')->first();
    	isset($acc->id) && $acc->id>0 ? $coas = DB::table('acc_coas')->where('id', $acc->id)->get() : 
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
		return view('acc.tranmaster.receiptpayment', compact(['tran', 'langs', 'acccoa', 'users', 'coa']));
	}

public function bankcash($id)
     {	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

	 	$acc='';
		if ($id=='Payment' || $id=='Receipt' || $id=='Contra'):
			$acc = Acccoas::where('com_id',$com_id)->where('name','Cash and Bank')->first();
		endif;
    	isset($acc->id) && $acc->id>0 ? $coas = DB::table('acc_coas')->where('com_id',$com_id)->where('id', $acc->id)->get() : 
		$coas = DB::table('acc_coas')->get();
        $coa = array();		
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
		//$coa = array('' => 'Select ...');	
        return Response::json($coa);
     }
public function coacon($id)
     {	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

	 	$acc='';
		$coas = DB::table('acc_coaconditions')->where('acc_id', $id)->first();
        $coacon = array();		
			$coacon += array('interval' => $coas->interval);
			$coacon += array('amount' => $coas->amount);
			$coacon += array('osl' => $coas->osl);
			$coacon += array('depreciation' => $coas->depreciation);
			$coacon += array('dep_formula' => $coas->dep_formula);
			$coacon += array('dep_interval' => $coas->dep_interval);
        return Response::json($coacon);
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
public function voucher($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$user = User::latest()->get();
		$users[0]="Waiting";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$tranmaster = Tranmasters::findOrFail($id);
		$find=DB::table('acc_tranmasters')->where('id',$id)->first();
		$ttype=''; isset($find) && $find->id >0 ? $ttype=$find->ttype : $ttype='';
		if ($ttype=='Journal'):
			return view('acc.tranmaster.jv', compact(['tranmaster', 'langs','users', 'reqs','acccoa']));
		else:
			return view('acc.tranmaster.voucher', compact(['tranmaster', 'langs','users', 'reqs','acccoa']));
		endif;
	}
public function cheqregister()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$acc='';
		$acc = Acccoas::where('name','Bank Account')->where('com_id',$com_id)->first();
    	isset($acc->id) && $acc->id>0 ? $coas = DB::table('acc_coas')->where('com_id',$com_id)->where('id', $acc->id)->get() : 
		$coas = DB::table('acc_coas')->where('com_id',$com_id)->get();
        $coa = array();		
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
        $acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$user = User::latest()->get();
		$users[0]="None";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$tran = Acccoas::where('com_id',$com_id)->where('name','Cash and Bank')->groupBy('id')->get();
		return view('acc.tranmaster.cheqregister', compact(['tran', 'langs','users', 'reqs','acccoa', 'coa']));
	}
public function sis_acc($id)
     {

	    $courts = DB::table('acc_coas')->where('atype','Account')->where('com_id',$id)->get();
        $options = array(''=>'Select ..');

        foreach ($courts as $court) {
            $options += array($court->id => $court->name);
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
 public function department()
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
		$department = Departments::where('com_id',$com_id)->latest()->get();
		$departments['']="Select ...";
        foreach($department as $data) {
            $departments[$data['id']] = $data['name'];
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
		$ref = Trandetails::where('com_id',$com_id)->where('ref','<>','')->latest()->groupBy('ref')->get();
		$refs['']="Select ...";
        foreach($ref as $data) {
            $refs[$data['ref']] = $data['ref'];
        }
		
		$tran = array(); //Trandetails::where('com_id',$com_id)->where('ref','<>',0)->get();
        $langs = $this->language();
		return view('acc.tranmaster.department', compact(['tran', 'langs', 'acccoa', 'users', 'coa', 'lcinfos', 'orders', 'refs','departments']));
	}
 public function subhead()
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
		$subhead = Subheads::where('com_id',$com_id)->latest()->get();
		$subheads['']="Select ...";
        foreach($subhead as $data) {
            $subheads[$data['id']] = $data['name'];
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
		$ref = Trandetails::where('com_id',$com_id)->where('ref','<>','')->latest()->groupBy('ref')->get();
		$refs['']="Select ...";
        foreach($ref as $data) {
            $refs[$data['ref']] = $data['ref'];
        }
		$tran = Trandetails::where('com_id',$com_id)->where('ref','<>',0)->get();
        $langs = $this->language();
		return view('acc.tranmaster.subhead', compact(['tran', 'langs', 'acccoa', 'users', 'coa', 'lcinfos', 'orders', 'refs','subheads']));
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
	public function voucher_print($id){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$user = User::latest()->get();
		$users[0]="Waiting...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$tranmaster = Tranmasters::findOrFail($id);
		
        $pdf = \PDF::loadView('acc.tranmaster.voucher_print', compact(['tranmaster', 'langs','users', 'reqs','acccoa']))->setOption('minimum-font-size', 10);
        return $pdf->stream('voucher_'.$id.'.pdf');
    }
    
    public function voucher_pdf($id){  
       ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$user = User::latest()->get();
		$users[0]="Waiting...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$tranmaster = Tranmasters::findOrFail($id);
		
        $pdf = \PDF::loadView('acc.tranmaster.voucher_print', compact(['tranmaster', 'langs','users', 'reqs','acccoa']))->setOption('minimum-font-size', 10);
        return $pdf->stream('voucher_'.$id.'.pdf');    
		}

	public function voucher_word($id)
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$user = User::latest()->get();
		$users[0]="Waiting...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$tranmaster = Tranmasters::findOrFail($id);
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Voucher_".$id.".doc");

		return view('acc.tranmaster.voucher_word', compact(['tranmaster', 'langs','users', 'reqs','acccoa']));
	}
    public function voucher_excel($id){
				Session::put('vtm_id',$id);
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('voucher', function($excel) {

            	$excel->sheet('voucher', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users[0]="Waiting...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}

				$langs = $this->language();
                $sheet->loadView('acc.tranmaster.voucher_excel', ['langs' => $langs, 'users'=>$users]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function voucher_csv($id){
				Session::put('vtm_id',$id);
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('voucher', function($excel) {

            	$excel->sheet('voucher', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users[0]="Waiting...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}

				$langs = $this->language();
                $sheet->loadView('acc.tranmaster.voucher_excel', ['langs' => $langs, 'users'=>$users]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
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
		
        $pdf = \PDF::loadView('acc.tranmaster.ledger_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('ledger.pdf');
    }
    
    public function ledger_pdf(){  
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
		
        $pdf = \PDF::loadView('acc.tranmaster.ledger_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('ledger.pdf');
		}

	public function ledger_word()
	{
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
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Ledger.doc");

		return view('acc.tranmaster.ledger_word', compact(['tran', 'langs', 'acccoa', 'users']));
	}
    public function ledger_excel(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('ledger', function($excel) {

            	$excel->sheet('ledger', function($sheet) {
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
				
                $sheet->loadView('acc.tranmaster.ledger_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function ledger_csv(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('ledger', function($excel) {

            	$excel->sheet('ledger', function($sheet) {
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
				
                $sheet->loadView('acc.tranmaster.ledger_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
public function department_print(){  
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
		
        $pdf = \PDF::loadView('acc.tranmaster.department_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('ledger.pdf');
    }
    
    public function department_pdf(){  
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
		
        $pdf = \PDF::loadView('acc.tranmaster.department_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('ledger.pdf');
		}

	public function department_word()
	{
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
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Ledger.doc");

		return view('acc.tranmaster.department_word', compact(['tran', 'langs', 'acccoa', 'users']));
	}
    public function department_excel(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('ledger', function($excel) {

            	$excel->sheet('ledger', function($sheet) {
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
				
                $sheet->loadView('acc.tranmaster.department_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function department_csv(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('ledger', function($excel) {

            	$excel->sheet('ledger', function($sheet) {
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
				
                $sheet->loadView('acc.tranmaster.department_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }	
public function receiptpayment_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$acc='';
		$acc = Acccoas::where('com_id',$com_id)->where('name','Cash and Bank')->first();
    	isset($acc->id) && $acc->id>0 ? $coas = DB::table('acc_coas')->where('id', $acc->id)->get() : 
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
		
        $pdf = \PDF::loadView('acc.tranmaster.receiptpayment_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('receiptpayment.pdf');
    }
    
    public function receiptpayment_pdf(){  
       ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$acc='';
		$acc = Acccoas::where('com_id',$com_id)->where('name','Cash and Bank')->first();
    	isset($acc->id) && $acc->id>0 ? $coas = DB::table('acc_coas')->where('id', $acc->id)->get() : 
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
		
        $pdf = \PDF::loadView('acc.tranmaster.receiptpayment_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('receiptpayment.pdf');
		}

	public function receiptpayment_word()
	{
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
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Ledger.doc");

		return view('acc.tranmaster.department_word', compact(['tran', 'langs', 'acccoa', 'users']));
	}
    public function receiptpayment_excel(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('ledger', function($excel) {

            	$excel->sheet('ledger', function($sheet) {
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
				
                $sheet->loadView('acc.tranmaster.department_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function receiptpayment_csv(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('ledger', function($excel) {

            	$excel->sheet('ledger', function($sheet) {
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
				
                $sheet->loadView('acc.tranmaster.department_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }	public function subhead_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
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
		$subhead = Subheads::where('com_id',$com_id)->latest()->get();
		$subheads['']="Select ...";
        foreach($subhead as $data) {
            $subheads[$data['id']] = $data['name'];
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
		$ref = Trandetails::where('com_id',$com_id)->where('ref','<>','')->latest()->groupBy('ref')->get();
		$refs['']="Select ...";
        foreach($ref as $data) {
            $refs[$data['ref']] = $data['ref'];
        }
		$tran = Trandetails::where('com_id',$com_id)->where('ref','<>',0)->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.subhead_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('subhead.pdf');
    }
    
    public function subhead_pdf(){  
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
		$subhead = Subheads::where('com_id',$com_id)->latest()->get();
		$subheads['']="Select ...";
        foreach($subhead as $data) {
            $subheads[$data['id']] = $data['name'];
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
		$ref = Trandetails::where('com_id',$com_id)->where('ref','<>','')->latest()->groupBy('ref')->get();
		$refs['']="Select ...";
        foreach($ref as $data) {
            $refs[$data['ref']] = $data['ref'];
        }
		$tran = Trandetails::where('com_id',$com_id)->where('ref','<>',0)->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.subhead_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('subhead.pdf');
		}

	public function subhead_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);

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
		$subhead = Subheads::where('com_id',$com_id)->latest()->get();
		$subheads['']="Select ...";
        foreach($subhead as $data) {
            $subheads[$data['id']] = $data['name'];
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
		$ref = Trandetails::where('com_id',$com_id)->where('ref','<>','')->latest()->groupBy('ref')->get();
		$refs['']="Select ...";
        foreach($ref as $data) {
            $refs[$data['ref']] = $data['ref'];
        }
		$tran = Trandetails::where('com_id',$com_id)->where('ref','<>',0)->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Subhead.doc");

		return view('acc.tranmaster.subhead_word', compact(['tran', 'langs', 'acccoa', 'users']));
	}
    public function subhead_excel(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('subhead', function($excel) {

            	$excel->sheet('subhead', function($sheet) {
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
				$subhead = Subheads::where('com_id',$com_id)->latest()->get();
				$subheads['']="Select ...";
				foreach($subhead as $data) {
					$subheads[$data['id']] = $data['name'];
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
				$ref = Trandetails::where('com_id',$com_id)->where('ref','<>','')->latest()->groupBy('ref')->get();
				$refs['']="Select ...";
				foreach($ref as $data) {
					$refs[$data['ref']] = $data['ref'];
				}
				$tran = Trandetails::where('com_id',$com_id)->where('ref','<>',0)->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.subhead_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function subhead_csv(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('ledger', function($excel) {

            	$excel->sheet('ledger', function($sheet) {
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
				
                $sheet->loadView('acc.tranmaster.ledger_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }

	public function balancesheet_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Balance Sheet')->groupBy('id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.balancesheet_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('balancesheet.pdf');
    }
    
    public function balancesheet_pdf(){  
       ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Balance Sheet')->groupBy('id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.balancesheet_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('balancesheet.pdf');
		}

	public function balancesheet_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);

		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Balance Sheet')->groupBy('id')->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=balancesheet.doc");

		return view('acc.tranmaster.balancesheet_word', compact(['tran', 'langs', 'acccoa', 'users']));
	}
    public function balancesheet_excel(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('balancesheet', function($excel) {

            	$excel->sheet('balancesheet', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Balance Sheet')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.balancesheet_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function balancesheet_csv(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('balancesheet', function($excel) {

            	$excel->sheet('balancesheet', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Balance Sheet')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.balancesheet_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	public function profitloss_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Account')->groupBy('id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.profitloss_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('profitloss.pdf');
    }
    
    public function profitloss_pdf(){  
       ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Account')->groupBy('id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.profitloss_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('profitloss.pdf');
		}

	public function profitloss_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);

		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Account')->groupBy('id')->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=profitloss.doc");

		return view('acc.tranmaster.profitloss_word', compact(['tran', 'langs', 'acccoa', 'users']));
	}
    public function profitloss_excel(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('profitloss', function($excel) {

            	$excel->sheet('profitloss', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Account')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.profitloss_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function profitloss_csv(){

				\Excel::create('profitloss', function($excel) {

            	$excel->sheet('profitloss', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Account')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.profitloss_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	public function manufacturing_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Manufacturing Account')->groupBy('id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.manufacturing_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('profitloss.pdf');
    }
    
    public function  manufacturing_pdf(){  
       ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Manufacturing Account')->groupBy('id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.manufacturing_pdf', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('profitloss.pdf');
		}

	public function  manufacturing_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);

		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Manufacturing Account')->groupBy('id')->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Manufacturing Account.doc");

		return view('acc.tranmaster.manufacturing_word', compact(['tran', 'langs', 'acccoa', 'users']));
	}
    public function  manufacturing_excel(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('manufacturing', function($excel) {

            	$excel->sheet('manufacturing', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Manufacturing Account')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.manufacturing_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function  manufacturing_csv(){

				\Excel::create('manufacturing', function($excel) {

            	$excel->sheet('manufacturing', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Manufacturing Account')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.manufacturing_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	public function pldistribution_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Distribution Account')->groupBy('id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.pldistribution_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('pldistribution.pdf');
    }
    
    public function  pldistribution_pdf(){  
       ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Distribution Account')->groupBy('id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.pldistribution_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('pldistribution.pdf');
		}

	public function  pldistribution_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);

		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Distribution Account')->groupBy('id')->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pldistribution.doc");

		return view('acc.tranmaster.pldistribution_word', compact(['tran', 'langs', 'acccoa', 'users']));
	}
    public function  pldistribution_excel(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('manufacturing', function($excel) {

            	$excel->sheet('manufacturing', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Distribution Account')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.pldistribution_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function  pldistribution_csv(){

				\Excel::create('manufacturing', function($excel) {

            	$excel->sheet('manufacturing', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Profit and Loss Distribution Account')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.pldistribution_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	public function trading_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Trading Account')->groupBy('id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.trading_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('Trading.pdf');
    }
    
    public function  trading_pdf(){  
       ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Trading Account')->groupBy('id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.pldistribution_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('pldistribution.pdf');
		}

	public function  trading_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);

		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Trading Account')->groupBy('id')->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pldistribution.doc");

		return view('acc.tranmaster.pldistribution_word', compact(['tran', 'langs', 'acccoa', 'users']));
	}
    public function  trading_excel(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('manufacturing', function($excel) {

            	$excel->sheet('manufacturing', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					//$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Trading Account')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.pldistribution_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function  trading_csv(){

				\Excel::create('manufacturing', function($excel) {

            	$excel->sheet('manufacturing', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Trading Account')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.pldistribution_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
   public function  clear_data(){
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

	   $affectedRows = Tranmasters::where('com_id', $com_id)->where('user_id',Auth::id())->delete();
	   $affectedRowsz = Trandetails::where('com_id', $com_id)->where('user_id',Auth::id())->delete();

		return redirect('tranmaster');
	   
	   }
	   
	public function sister()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$req = Prequisitions::where('com_id',$com_id)->latest()->get();
		$reqs['']="Select ...";
        foreach($req as $req_data) {
            $reqs[$req_data['id']] = $req_data['name'];
        }
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$tranmasters = Tranmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.tranmaster.sister', compact(['tranmasters', 'langs', 'acccoa', 'users', 'reqs' ]));
	} 
	
		public function depreciation()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

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
		$tran = Acccoas::where('com_id',$com_id)->where('name','Fixed Assets')->groupBy('id')->get();
        $langs = $this->language();

		return view('acc.tranmaster.depreciation', compact(['tran', 'langs']));
	}
	public function deprefilter(Request $request)
	{
		
		Session::put('depm_id', $request->get('m_id'));
		Session::put('depyear', $request->get('year'));
		
		return redirect('tranmaster/depreciation');
	}
	
	public function opening($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$sister = Companies::where('id','<>',$com_id)->latest()->get();
		$sisters['']="Select ...";
        foreach($sister as $data) {
            $sisters[$data['id']] = $data['name'];
        }
		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($currencys as $data) {
            $currency[$data['id']] = $data['name'];
        } 
		$department = Departments::where('com_id',$com_id)->latest()->get();
		$departments['']="Select ...";
        foreach($department as $data) {
            $departments[$data['id']] = $data['name'];
        } 
		$shs = Subheads::where('com_id',$com_id)->latest()->get();
		$sh['']="Select ...";
        foreach($shs as $data) {
            $sh[$data['id']] = $data['name'];
        } 
		$projects = Projects::where('com_id',$com_id)->latest()->get();
		$project['']="Select ...";
        foreach($projects as $data) {
            $project[$data['id']] = $data['name'];
        }		
		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }		

		$lc = Lcinfos::where('com_id',$com_id)->latest()->get();
		$lcs['']="Select ...";
        foreach($lc as $lc_data) {
            $lcs[$lc_data['id']] = $lc_data['lcnumber'];
        }
		$ilc = Lcimports::where('com_id',$com_id)->latest()->get();
		$ilcs['']="Select ...";
        foreach($ilc as $data) {
            $ilcs[$data['id']] = $data['lcnumber'];
        }
		$ord = Orderinfos::where('com_id',$com_id)->latest()->get();
		$ords['']="Select ...";
        foreach($ord as $ord_data) {
            $ords[$ord_data['id']] = $ord_data['ordernumber'];
        }
		$stl = Styles::where('com_id',$com_id)->latest()->get();
		$stls['']="Select ...";
        foreach($stl as $stl_data) {
            $stls[$stl_data['id']] = $stl_data['name'];
        }
		$req = Prequisitions::where('com_id',$com_id)->where('check_action',1)->where('paid',0)->latest()->get();
		$reqs['']="Select ...";
        foreach($req as $req_data) {
            $reqs[$req_data['id']] = $req_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        }
		//$user=User::lists('id', 'name'); 
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
        $langs = $this->language();
		$tranmaster = Tranmasters::findOrFail($id);
		return view('acc.tranmaster.show', compact(['tranmaster', 'langs', 'acccoa', 'users', 'reqs', 'lcs', 'ords', 'stls','sh','project', 'ilcs','currency','departments','sisters','products']));
	}
	public function reminder()
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
		$tranmasters = Tranmasters::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $tranmasters = $tranmasters->where('user_id',Auth::id());
        }
		return view('acc.tranmaster.reminder', compact(['tranmasters', 'langs', 'acccoa','users']));
	}
	public function trialbalance_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
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
		$tran = Acccoas::where('com_id',$com_id)->where('topGroup_id',0)->groupBy('id')->get();
        $langs = $this->language();
	
        $pdf = \PDF::loadView('acc.tranmaster.trialbalance_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('traialbalance.pdf');
    }
    
    public function  trialbalance_pdf(){  
       ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Trading Account')->groupBy('id')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.tranmaster.trialbalance_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 10);
        return $pdf->stream('pldistribution.pdf');
		}

	public function trialbalance_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);

		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Trading Account')->groupBy('id')->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pldistribution.doc");

		return view('acc.tranmaster.trialbalance_word', compact(['tran', 'langs', 'acccoa', 'users']));
	}
    public function  trialbalance_excel(){

				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('manufacturing', function($excel) {

            	$excel->sheet('manufacturing', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					//$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Trading Account')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.trialbalance_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function  trialbalance_csv(){

				\Excel::create('manufacturing', function($excel) {

            	$excel->sheet('manufacturing', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$user = User::latest()->get();
				$users['']="Select ...";
				foreach($user as $user_data) {
					$users[$user_data['id']] = $user_data['name'];
				}
				$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
				$acccoa['']="Select ...";
				foreach($acccoas as $acccoas_data) {
					$acccoa[$acccoas_data['id']] = $acccoas_data['name'];
				} 
				$tran = Acccoas::where('com_id',$com_id)->where('group_id',0)->where('name','Trading Account')->groupBy('id')->get();
				$langs = $this->language();
				
                $sheet->loadView('acc.tranmaster.trialbalance_excel', ['tran'=>$tran, 'langs' => $langs, 'users'=>$users,'acccoa'=>$acccoa]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }


}
