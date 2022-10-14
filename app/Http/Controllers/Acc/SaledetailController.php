<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Saledetails;
use App\Models\Acc\Salemasters;
use App\Models\Acc\Products;
use App\Models\Acc\Invendetails;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

use Auth;
use DB;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class SaledetailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$saledetails = Saledetails::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $saledetails = $saledetails->where('user_id',Auth::id());
        }
		return view('acc.saledetail.index', compact(['saledetails', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('acc.saledetail.create', compact('langs'));
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

	    $saledetail = $request->all();
        $saledetail['user_id'] = Auth::id();
		$saledetail['com_id'] = $com_id;
        Saledetails::create($saledetail);
			// amount update
			$amount_sum=DB::table('acc_saledetails')->where('com_id',$com_id)->where('sm_id',$request->get('sm_id'))->sum('amount');
			$amount_sum< 0 ? $amount_sum=substr($amount_sum, 1): '';
			$tranmast = Salemasters::findOrFail($request->get('sm_id'));
			$data_tm_amount=array('amount'=>$amount_sum);
			$tranmast->update($data_tm_amount);
			// cost of sales
			$tranmast = Products::findOrFail($request->get('item_id'));
			$qty=Invendetails::where('item_id',$request->get('item_id'))->sum('qty');
			//echo $qty;
			//exit;
			$tranmast->update();
		return redirect('salemaster/'.$request->get('sm_id'));
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
		$saledetail = Saledetails::findOrFail($id);
		return view('acc.saledetail.show', compact(['saledetail', 'langs']));
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

		$produ = Products::where('com_id',$com_id)->lists('name', 'id');
        $group = Saledetails::where('com_id',$com_id)->where('sm_id',$id)->where('group_id','=',0)->latest()->get();
		$groups['']="Select ...";
        foreach($group as $data) {
            $groups[$data['id']] = $produ[$data['item_id']];
        }
        $product = Products::where('ptype', 'Product')->where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
		foreach($product as $products_data):
			$products[$products_data['id']]=$products_data['name'];
		endforeach;
		$langs = $this->language();
		$saledetail = Saledetails::findOrFail($id);
		return view('acc.saledetail.edit', compact(['saledetail', 'langs','products','groups']));
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

		$saledetail = Saledetails::findOrFail($id);
		$saledetail->update($request->all());
			// amount update
			$amount_sum=DB::table('acc_saledetails')->where('com_id',$com_id)->where('sm_id',$request->get('sm_id'))->sum('amount');
			$amount_sum< 0 ? $amount_sum=substr($amount_sum, 1): '';
			$tranmast = Salemasters::findOrFail($request->get('sm_id'));
			$data_tm_amount=array('samount'=>$amount_sum);
			$tranmast->update($data_tm_amount);
		return redirect('salemaster/'.$request->get('sm_id'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$sm=DB::table('acc_saledetails')->where('id',$id)->first();
		$sm_id=''; isset($sm) && $sm->id > 0 ? $sm_id=$sm->sm_id : $sm_id='';
		Saledetails::destroy($id);
		
		return redirect('salemaster/'.$sm_id);
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