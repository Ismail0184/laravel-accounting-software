<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Purchasedetails;
use App\Models\Acc\Purchasemasters;
use App\Models\Acc\Invendetails;

use App\Models\Acc\Products;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

use Auth;
use DB;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class PurchasedetailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$purchasedetails = Purchasedetails::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $purchasedetails = $purchasedetails->where('user_id',Auth::id());
        }
		return view('acc.purchasedetail.index', compact(['purchasedetails', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('acc.purchasedetail.create', compact('langs'));
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

	    $purchasedetail = $request->all();
        $purchasedetail['user_id'] = Auth::id();
		$purchasedetail['com_id'] = $com_id;
        Purchasedetails::create($purchasedetail);
		//================
			$purchasemaster = Purchasemasters::findOrFail($request->get('pm_id'));
			$amount_sum=DB::table('acc_purchasedetails')->where('com_id',$com_id)->where('pm_id',$request->get('pm_id'))->sum('amount');
			if (isset($amount_sum) && $amount_sum!=0):
				$data_pm_amount=array('amount'=>$amount_sum);
				$purchasemaster->update($data_pm_amount);
			endif;

		return redirect('purchasemaster/'.$request->get('pm_id'));
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
		$purchasedetail = Purchasedetails::findOrFail($id);
		return view('acc.purchasedetail.show', compact(['purchasedetail', 'langs']));
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

		$product = Products::where('com_id',$com_id)->where('ptype','product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $products_data) {
            $products[$products_data['id']] = $products_data['name'];
        }        $langs = $this->language();
		$purchasedetail = Purchasedetails::findOrFail($id);
		return view('acc.purchasedetail.edit', compact(['purchasedetail', 'langs','products']));
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

		$purchasedetail = Purchasedetails::findOrFail($id);
		$purchasedetail->update($request->all());

		//================
			$purchasemaster = Purchasemasters::findOrFail($request->get('pm_id'));
			$amount_sum=DB::table('acc_purchasedetails')->where('com_id',$com_id)->where('pm_id',$request->get('pm_id'))->sum('amount');
			if (isset($amount_sum) && $amount_sum!=0):
				$data_pm_amount=array('amount'=>$amount_sum);
				$purchasemaster->update($data_pm_amount);
			endif;
		return redirect('purchasemaster/'.$request->get('pm_id'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
		$pm=DB::table('acc_purchasedetails')->where('com_id',$com_id)->where('id',$id)->first();
		$pm_id=0; isset($pm) && $pm->id > 0 ? $pm_id=$pm->pm_id : $pm_id=0;

		Purchasedetails::destroy($id);

		//================
		
			$amount_sum=DB::table('acc_purchasedetails')->where('com_id',$com_id)->where('pm_id',$pm_id)->sum('amount');
			if (isset($amount_sum) && $amount_sum!=0):
				$purchasemaster = Purchasemasters::findOrFail($pm_id);
				$data_pm_amount=array('amount'=>$amount_sum);
				$purchasemaster->update($data_pm_amount);
			endif;
		return redirect('purchasemaster/'.$pm_id);
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

}