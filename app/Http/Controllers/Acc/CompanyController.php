<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Companies;
use App\Models\Acc\Warehouses;
use App\Models\Acc\Options;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Session; 
use DB;
use Response;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class CompanyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$companies = Companies::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $companies = $companies->where('user_id',Auth::id());
        }
		return view('acc.company.index', compact(['companies', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('acc.company.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $company = $request->all();
        $company['user_id'] = Auth::id();
        Companies::create($company);
		$com=DB::table('acc_companies')->where('name',$request->get('name'))->first();
		$com_id='';isset($com) && $com->id > 0 ? $com_id=$com->id : $com_id='';
		
		// warehouse created
			$wh=array(
			'name'=>'Central Warehouse',
			'com_id'=>$com_id,
			'user_id'=>Auth::id(),
			);
			Warehouses::create($wh);
			//$option=Options::findOrFail('com_id',$com_id);
			//$option->update(array())
		//=========================
		$this->add_coa($com_id);
		if($request->get('ctype')==0 ):
			DB::insert('insert into acc_usercompanies (name, users_id, setting, com_id, user_id) values (?,?,?,?,?)', ['Sample user',Auth::id(),'Defauld',$com_id,Auth::id()]);
			Session::put('com_id', $com_id);
		endif;
		return redirect('company');
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
		$company = Companies::findOrFail($id);
		return view('acc.company.show', compact(['company', 'langs']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $langs = $this->language();
		$company = Companies::findOrFail($id);
		return view('acc.company.edit', compact(['company', 'langs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$company = Companies::findOrFail($id);
		$company->update($request->all());
		return redirect('company');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Companies::destroy($id);
		DB::delete('delete from acc_coas where com_id='.$id);
		DB::delete('delete from acc_usercompanies where com_id='.$id);
		DB::delete('delete from acc_tranmasters where com_id='.$id);
		DB::delete('delete from acc_trandetails where com_id='.$id);
		DB::delete('delete from acc_options where com_id='.$id);
		DB::delete('delete from acc_buyerinfos where com_id='.$id);
		DB::delete('delete from acc_lcinfos where com_id='.$id);
		DB::delete('delete from acc_orderinfos where com_id='.$id);
		DB::delete('delete from acc_styles where com_id='.$id);
		DB::delete('delete from acc_clients where com_id='.$id);
		DB::delete('delete from acc_suppliers where com_id='.$id);
		DB::delete('delete from acc_warehouses where com_id='.$id);
		DB::delete('delete from acc_lcimports where com_id='.$id);
		DB::delete('delete from acc_importmasters where com_id='.$id);
		DB::delete('delete from acc_invenmasters where com_id='.$id);
		DB::delete('delete from acc_invendetails where com_id='.$id);
		DB::delete('delete from acc_salemasters where com_id='.$id);
		DB::delete('delete from acc_saledetails where com_id='.$id);
		DB::delete('delete from acc_products where com_id='.$id);
		DB::delete('delete from acc_audits where com_id='.$id);
		DB::delete('delete from acc_prequisitions where com_id='.$id);
		DB::delete('delete from acc_outlets where com_id='.$id);
		DB::delete('delete from acc_mteams where com_id='.$id);
		DB::delete('delete from acc_budgets where com_id='.$id);
		DB::delete('delete from acc_projects where com_id='.$id);
		DB::delete('delete from acc_pbudgets where com_id='.$id);
		DB::delete('delete from acc_pplannings where com_id='.$id);
		DB::delete('delete from acc_coaconditions where com_id='.$id);
		DB::delete('delete from acc_coadetails where com_id='.$id);
		
		return redirect('company');
	}
 public function help()
	{
		$acccoas = Companies::latest()->get();
        $langs = $this->language();
		return view('acc.company.help', compact(['acccoas', 'langs']));
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
		
	public function filter(Request $request)
	{
		
		Session::put('com_id', $request->get('com_id'));
		return redirect('company');

	}
	public function add_coa($com_id)
	{

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
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Sundry Debtors','Group',$cat_id,$bs_id,4,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Master LC Transaction','Group',$cat_id,$bs_id,5,$com_id,Auth::id()]);
			$mlc=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Master LC Transaction')->first();
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
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Prime Bank-123','Account',$ba_id,$bs_id,1,$com_id,Auth::id()]);
					DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Cash Account','Group',$cb_id,$bs_id,2,$com_id,Auth::id()]);
			$ca=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Cash Account')->first();
			$ca_id='';isset($ca) && $ca->id > 0 ? $ca_id=$ca->id : $ca_id='';
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Main Cash','Account',$ca_id,$bs_id,1,$com_id,Auth::id()]);
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Petty Cash','Account',$ca_id,$bs_id,2,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Capital','Group',$bs_id,$bs_id,4,$com_id,Auth::id()]);
			$cp=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Capital')->first();
			$cp_id='';isset($cp) && $cp->id > 0 ? $cp_id=$cp->id : $cp_id='';
						DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Paid Up Capital','Account',$cp_id,$bs_id,1,$com_id,Auth::id()]);
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Liabilities','Group',$bs_id,$bs_id,5,$com_id,Auth::id()]);
			$lia=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Liabilities')->first();
			$lia_id='';isset($lia) && $lia->id > 0 ? $lia_id=$lia->id : $lia_id='';

								DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Current Liabilities','Group',$lia_id,$bs_id,1,$com_id,Auth::id()]);
								DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Non-Current Liabilities','Group',$lia_id,$bs_id,2,$com_id,Auth::id()]);
			$cl=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Current Liabilities')->first();
			$cl_id='';isset($cl) && $cl->id > 0 ? $cl_id=$cl->id : $cl_id='';
				DB::insert('insert into acc_coas (name, atype, group_id, topGroup_id, sl, com_id, user_id) values (?,?,?,?,?,?,?)', ['Sundry Creditors','Group',$cl_id,$bs_id,1,$com_id,Auth::id()]);
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
			
			$mlc=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Master LC')->first();
			$mlc_id='';isset($mlc) && $mlc->id > 0 ? $mlc_id=$mlc->id : $mlc_id='';

			$mlcb=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Master LC Buyer')->first();
			$mlcb_id='';isset($mlcb) && $mlcb->id > 0 ? $mlcb_id=$mlcb->id : $mlcb_id='';

			$tlc=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Transferred Master LC')->first();
			$tlc_id='';isset($tlc) && $tlc->id > 0 ? $tlc_id=$tlc->id : $tlc_id='';
		
			$b2blc=DB::table('acc_coas')->where('com_id',$com_id)->where('name','B2B Master LC')->first();
			$b2blc_id='';isset($b2blc) && $b2blc->id > 0 ? $b2blc_id=$b2blc->id : $b2blc_id='';
			
			DB::insert('insert into acc_options (bstype, max_pay, currency_id, tcheck_id, tappr_id, mlctd_id, mlctc_id, tlctd_id, tlctc_id, b2btd_id, com_id, user_id) values (?,?,?,?,?,?,?,?,?,?,?,?)',['gf',5000,3,4,1,$mlc_id,$mlcb_id,$tlc_id,$mlc_id,$b2blc_id,$com_id,Auth::id()]);

		
	}


}