<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Acccoas;
use App\Models\Acc\Coadetails;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\library\myFunctions;
use App\Models\Lib\Languages;
use Session;
use DB;
use Auth;
use App\User;


class AcccoaController extends Controller {


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

		$acccoas = Acccoas::where('com_id',$com_id)->orderBy('id')->where('topGroup_id',0)->get(); //, 'desc'
        $langs = $this->language();
		return view('acc.acccoa.index', compact(['acccoas', 'langs','users']));
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

		$topGroups = Acccoas::where('topGroup_id',0)->where('com_id',$com_id)->latest('name', 'id')->get();
		$topGroup['']='Select ...';
		foreach($topGroups as $topGroup_data){
			$topGroup[$topGroup_data['id']]=$topGroup_data['name'];
		}		
      	$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$group['']='Select ...';
		foreach($acccoas as $group_data){
			$group[$group_data['id']]=$group_data['name'];
		}
		
	    $langs = $this->language();
		return view('acc.acccoa.create', compact('langs','acccoas','topGroup','group'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		$data=array(
			'name'=>		$request->get('name'),
			'group_id'=>	$request->get('group_id'),
			'topGroup_id'=>	$request->get('topGroup_id'),
			'atype'=>		$request->get('atype'),
			'sl'=>			$request->get('sl'),
			'cond_id'=>		$request->get('cond_id'),
			'com_id'=>		$com_id,
			'user_id'=>		$request->get('user_id'),
			'detail_id'=>	$request->get('detail_id')
		);		 
		Acccoas::create($data);
		
		//Acccoas::create($request->all());
		return redirect('acccoa');
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
		$acccoa = Acccoas::findOrFail($id);
		return view('acc.acccoa.show', compact(['acccoa', 'langs']));
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

		$langs = $this->language();
		$acccoas = Acccoas::where('com_id', $com_id)->latest()->get();
		$acccoa = Acccoas::findOrFail($id);
		
		$topGroups = Acccoas::where('com_id', $com_id)->where('topGroup_id',0)->latest('name', 'id')->get();
		$topGroup['']='Select ...';
		foreach($topGroups as $topGroup_data){
			$topGroup[$topGroup_data['id']]=$topGroup_data['name'];
		}	
			
      	$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$group['']='Select ...';
		foreach($acccoas as $group_data){
			$group[$group_data['id']]=$group_data['name'];
		}		
		$coadetails = Coadetails::where('acc_id',$id)->first();
		return view('acc.acccoa.edit', compact(['acccoa','acccoas', 'langs','group','topGroup','coadetails']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
		$acccoa = Acccoas::findOrFail($id);
		$data=array(
			'name'=>		$request->get('name'),
			'group_id'=>	$request->get('group_id'),
			'topGroup_id'=>	$request->get('topGroup_id'),
			'atype'=>		$request->get('atype'),
			'sl'=>			$request->get('sl'),
			'cond_id'=>		$request->get('cond_id'),
			'detail_id'=>	$request->get('detail_id')
		);
		
		$acccoa->update($data);
		//$acccoa->update($request->all());
		return redirect('acccoa');
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Acccoas::destroy($id);
		return redirect('acccoa');
	}
  
  
  public function help()
	{
		$acccoas = Acccoas::latest()->get();
        $langs = $this->language();
		return view('acc.acccoa.help', compact(['acccoas', 'langs']));
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
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$coa = Acccoas::where('com_id', $com_id)->where('topGroup_id','0')->get();
        $langs = $this->language();
		return view('acc.acccoa.report', compact(['coa', 'langs']));
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
	public function add_coa()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$bs=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Balance Sheet')->first();
		$bs_id='';isset($bs) && $bs->id > 0 ? $bs_id=$bs->id : $bs_id='';
		$duplicate_check=DB::table('acc_coas')->where('com_id',$com_id)->where('topGroup_id',$bs_id)->first();
		if(!isset($duplicate_check) && !isset($duplicate_check->id)):
			DB::insert('insert into acc_coas (name, atype, com_id, user_id) values (?,?,?,?)', ['Balance Sheet','Group',$com_id,Auth::id()]);
			DB::insert('insert into acc_coas (name, atype, com_id, user_id) values (?,?,?,?)', ['Profit and Loss Account','Group',$com_id,Auth::id()]);
			DB::insert('insert into acc_coas (name, atype, com_id, user_id) values (?,?,?,?)', ['Trading Account','Group',$com_id,Auth::id()]);
			DB::insert('insert into acc_coas (name, atype, com_id, user_id) values (?,?,?,?)', ['Manufacturing Account','Group',$com_id,Auth::id()]);
			DB::insert('insert into acc_coas (name, atype, com_id, user_id) values (?,?,?,?)', ['Profit and Loss Distribution Account','Group',$com_id,Auth::id()]);
			
			$bs=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Balance Sheet')->first();
			$bs_id='';isset($bs) && $bs->id > 0 ? $bs_id=$bs->id : $bs_id='';
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Fixed Assets','Group',$bs_id,$bs_id,1,$com_id,Auth::id()]);
			$fa=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Fixed Assets')->first();
			$fa_id='';isset($fa) && $fa->id > 0 ? $fa_id=$fa->id : $fa_id='';
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Land and Buildings','Account',$fa_id,$bs_id,1,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Factory Machineries and Equipments','Account',$fa_id,$bs_id,2,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Office Equipment','Account',$fa_id,$bs_id,3,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Office Decoration','Account',$fa_id,$bs_id,4,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Furniture and Fixtures','Account',$fa_id,$bs_id,5,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Computer abd Networking','Account',$fa_id,$bs_id,6,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Cars and Vehicles','Account',$fa_id,$bs_id,7,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Current Assets','Group',$bs_id,$bs_id,2,$com_id,Auth::id()]);
			$cat=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Current Assets')->first();
			$cat_id='';isset($cat) && $cat->id > 0 ? $cat_id=$cat->id : $cat_id='';
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Preliminery Expenses','Account',$cat_id,$bs_id,1,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Advance, Deposit and Prepayment','Account',$cat_id,$bs_id,2,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Loan Account','Account',$cat_id,$bs_id,3,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Bills Receivable','Group',$cat_id,$bs_id,4,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Master LC','Group',$cat_id,$bs_id,5,$com_id,Auth::id()]);
			$mlc=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Master LC')->first();
			$mlc_id='';isset($mlc) && $mlc->id > 0 ? $mlc_id=$mlc->id : $mlc_id='';
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Master LC','Account',$mlc_id,$bs_id,1,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Transferred Master LC','Account',$mlc_id,$bs_id,2,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['B2B Master LC','Account',$mlc_id,$bs_id,3,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Cash and Bank','Group',$bs_id,$bs_id,3,$com_id,Auth::id()]);
			$cb=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Cash and Bank')->first();
			$cb_id='';isset($cb) && $cb->id > 0 ? $cb_id=$cb->id : $cb_id='';
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Bank Account','Group',$cb_id,$bs_id,1,$com_id,Auth::id()]);
			$ba=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Bank Account')->first();
			$ba_id='';isset($ba) && $ba->id > 0 ? $ba_id=$ba->id : $ba_id='';
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['ABC Bank 123','Account',$ba_id,$bs_id,1,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Cash Account','Group',$cb_id,$bs_id,2,$com_id,Auth::id()]);
			$ca=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Cash Account')->first();
			$ca_id='';isset($ca) && $ca->id > 0 ? $ca_id=$ca->id : $ca_id='';
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Main Cash','Account',$ca_id,$bs_id,1,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Petty Cash','Account',$ca_id,$bs_id,2,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Capital','Group',$bs_id,$bs_id,4,$com_id,Auth::id()]);
			$cp=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Capital')->first();
			$cp_id='';isset($cp) && $cp->id > 0 ? $cp_id=$cp->id : $cp_id='';
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Paid Up Capital','Account',$cp_id,$bs_id,1,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Current Liabilities','Group',$bs_id,$bs_id,5,$com_id,Auth::id()]);
			$cl=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Current Liabilities')->first();
			$cl_id='';isset($cl) && $cl->id > 0 ? $cl_id=$cl->id : $cl_id='';
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Bills Payables','Group',$cl_id,$bs_id,1,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Master LC Buyer','Account',$cl_id,$bs_id,1,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Profit and Loss','Group',$bs_id,$bs_id,6,$com_id,Auth::id()]);
			$pl=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Profit and Loss Account')->first();
			$pl_id='';isset($pl) && $pl->id > 0 ? $pl_id=$pl->id : $pl_id='';
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Income','Group',$pl_id,$pl_id,1,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Expenditure','Group',$pl_id,$pl_id,2,$com_id,Auth::id()]);
			$ex=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Expenditure')->first();
			$ex_id='';isset($ex) && $ex->id > 0 ? $ex_id=$ex->id : $ex_id='';
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Admin Expenses','Group',$ex_id,$pl_id,1,$com_id,Auth::id()]);
			$ad=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Admin Expenses')->first();
			$ad_id='';isset($ad) && $ad->id > 0 ? $ad_id=$ad->id : $ad_id='';
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Director Remuneration','Account',$ad_id,$pl_id,1,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Salary and Allowances','Account',$ad_id,$pl_id,2,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Office Rent','Account',$ad_id,$pl_id,3,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Office Electricity','Account',$ad_id,$pl_id,4,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Conveyance','Account',$ad_id,$pl_id,5,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Entertainment','Account',$ad_id,$pl_id,6,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Mobile and Phone','Account',$ad_id,$pl_id,7,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Computer and Accessories','Account',$ad_id,$pl_id,8,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Internet and WIFI','Account',$ad_id,$pl_id,9,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Telephone and FAX','Account',$ad_id,$pl_id,10,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Donation and Subscription','Account',$ad_id,$pl_id,11,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Repair and Maintenance','Account',$ad_id,$pl_id,12,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Oil and Lubricant -Vehicles','Account',$ad_id,$pl_id,13,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Gas and WASA','Account',$ad_id,$pl_id,14,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Licenses and Renewal','Account',$ad_id,$pl_id,15,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Legal Expenses','Account',$ad_id,$pl_id,16,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Audit Expenses','Account',$ad_id,$pl_id,17,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Bank Charges','Account',$ad_id,$pl_id,17,$com_id,Auth::id()]);
						
			$tr=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Trading Account')->first();
			$tr_id='';isset($tr) && $tr->id > 0 ? $tr_id=$tr->id : $tr_id='';
			
			$mf=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Manufacturing Account')->first();
			$mf_id='';isset($mf) && $mf->id > 0 ? $mf_id=$mf->id : $mf_id='';
			
			$pd=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Profit and Loss Distribution Account')->first();
			$pd_id='';isset($pd) && $pd->id > 0 ? $pd_id=$pd->id : $pd_id='';		
		endif;
		return redirect('acccoa');
		
	}
	public function add_coa_manu()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$mf=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Manufacturing Account')->first();
		$mf_id='';isset($mf) && $mf->id > 0 ? $mf_id=$mf->id : $mf_id='';
		$duplicate_check=DB::table('acc_coas')->where('com_id',$com_id)->where('topGroup_id',$mf_id)->first();
		if(!isset($duplicate_check) && !isset($duplicate_check->id)):
			DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Direct Expense','Group',$mf_id,$mf_id,1,$com_id,Auth::id()]);
		$de=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Direct Expense')->first();
		$de_id='';isset($de) && $de->id > 0 ? $de_id=$de->id : $de_id='';
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Yarn Purchase','Account',$de_id,$mf_id,1,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Knitting Bills','Account',$de_id,$mf_id,2,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Dyeing Bills','Account',$de_id,$mf_id,3,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Trims Purchases','Account',$de_id,$mf_id,4,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Sample Charges','Account',$de_id,$mf_id,5,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Worker OT','Account',$de_id,$mf_id,6,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Worker Salary','Account',$de_id,$mf_id,7,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Spare Parts','Account',$de_id,$mf_id,8,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Packing Charges','Account',$de_id,$mf_id,9,$com_id,Auth::id()]);
			DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Overhead Expense','Group',$mf_id,$mf_id,2,$com_id,Auth::id()]);
		$oe=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Overhead Expense')->first();
		$oe_id='';isset($oe) && $oe->id > 0 ? $oe_id=$oe->id : $oe_id='';
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Factory Rent','Account',$oe_id,$mf_id,1,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Factory Electricity','Account',$oe_id,$mf_id,2,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Supervisor Salary','Account',$oe_id,$mf_id,3,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Generator Oil and Maintenanace','Account',$oe_id,$mf_id,4,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Transport Bills','Account',$oe_id,$mf_id,5,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Repair and maintenance','Account',$oe_id,$mf_id,6,$com_id,Auth::id()]);
	endif;
		return redirect('acccoa');
		
	}
	public function add_coa_trading()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$tr=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Trading Account')->first();
		$tr_id='';isset($tr) && $tr->id > 0 ? $tr_id=$tr->id : $tr_id='';
		$duplicate_check=DB::table('acc_coas')->where('com_id',$com_id)->where('topGroup_id',$tr_id)->first();
		if(!isset($duplicate_check) && !isset($duplicate_check->id)):

			DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Revenue','Group',$tr_id,$tr_id,1,$com_id,Auth::id()]);
		$re=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Revenue')->first();
		$re_id='';isset($re) && $re->id > 0 ? $re_id=$re->id : $re_id='';
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Export','Account',$re_id,$tr_id,1,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Jute Sale','Account',$re_id,$tr_id,2,$com_id,Auth::id()]);
			DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Marketing Expense','Group',$tr_id,$tr_id,2,$com_id,Auth::id()]);
		$me=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Marketing Expense')->first();
		$me_id='';isset($me) && $me->id > 0 ? $me_id=$me->id : $me_id='';
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Marketing Salary','Account',$me_id,$tr_id,1,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Traveling and Tour','Account',$me_id,$tr_id,2,$com_id,Auth::id()]);
			DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Shipment Cost','Group',$tr_id,$tr_id,3,$com_id,Auth::id()]);
		$sc=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Shipment Cost')->first();
		$sc_id='';isset($sc) && $sc->id > 0 ? $sc_id=$sc->id : $sc_id='';
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Inspection Charges','Account',$sc_id,$tr_id,1,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['B/L Bills','Account',$sc_id,$tr_id,2,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['CNF Bills','Account',$sc_id,$tr_id,3,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Bank Charges','Account',$sc_id,$tr_id,4,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Transport','Account',$sc_id,$tr_id,5,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Courier Services Expenses','Account',$sc_id,$tr_id,6,$com_id,Auth::id()]);
		
				endif;

				return redirect('acccoa');

		
	}
	public function add_coa_pldistribution()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$pd=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Profit and Loss Distribution Account')->first();
		$pd_id='';isset($pd) && $pd->id > 0 ? $pd_id=$pd->id : $pd_id='';
		$duplicate_check=DB::table('acc_coas')->where('com_id',$com_id)->where('topGroup_id',$pd_id)->first();
		if(!isset($duplicate_check) && !isset($duplicate_check->id)):
			DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Govt. TAXES','Group',$pd_id,$pd_id,1,$com_id,Auth::id()]);
		$gt=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Govt. TAXES')->first();
		$gt_id='';isset($gt) && $gt->id > 0 ? $gt_id=$gt->id : $gt_id='';
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['VAT and TAX','Account',$gt_id,$pd_id,1,$com_id,Auth::id()]);
			DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Director Account','Group',$pd_id,$pd_id,2,$com_id,Auth::id()]);
		$da=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Director Account')->first();
		$da_id='';isset($da) && $da->id > 0 ? $da_id=$da->id : $da_id='';
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Managing Director','Account',$da_id,$pd_id,1,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Chairman','Account',$da_id,$pd_id,2,$com_id,Auth::id()]);
		endif;
		return redirect('acccoa');

		
	}
	public function clear_all()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		DB::table('acc_coas')->where('com_id',$com_id)->delete();
		return redirect('acccoa');

	}
	public function coa_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$coa = Acccoas::where('com_id', $com_id)->where('topGroup_id','0')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.acccoa.print', compact(['coa', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('coa.pdf');
    }
    
    public function coa_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$coa = Acccoas::where('com_id', $com_id)->where('topGroup_id','0')->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.acccoa.print', compact(['coa', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('coa.pdf');
    }

	public function coa_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$coa = Acccoas::where('com_id', $com_id)->where('topGroup_id','0')->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=COA.doc");

		return view('acc.acccoa.word', compact(['coa', 'langs']));
	}
    public function coa_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('COA', function($excel) {

            	$excel->sheet('COA', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				
				$coa = Acccoas::where('com_id', $com_id)->where('topGroup_id','0')->get();
		        $langs = $this->language();
                $sheet->loadView('acc.acccoa.excel', ['coa' => $coa->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function report_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('Clients', function($excel) {

            	$excel->sheet('Clients', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$clients = Clients::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.client.excel', ['clients' => $clients->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }

}
