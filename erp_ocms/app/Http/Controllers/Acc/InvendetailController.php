<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Invendetails;
use App\Models\Acc\Products;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Warehouses;
use App\Models\Acc\Projects;
use App\Models\Acc\Ittypes;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class InvendetailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$unit = AccUnits::latest()->get();
		$units['']="Select ...";
        foreach($unit as $unit_data) {
            $units[$unit_data['id']] = $unit_data['name'];
        }
		$product = Products::latest()->get();
		$products['']="Select ...";
        foreach($product as $product_data) {
            $products[$product_data['id']] = $product_data['name'];
        }
		$invendetails = Invendetails::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $invendetails = $invendetails->where('user_id',Auth::id());
        }
		return view('acc.invendetail.index', compact(['invendetails', 'langs', 'products', 'units']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('acc.invendetail.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ; // echo $com_id.'osama';

	   	if ($request->get('itype')=='Receive'):
			$invendetail = $request->all();
			$invendetail['user_id'] = Auth::id();
			$invendetail['com_id'] = $com_id;
			$invendetail['war_id'] = $request->get('war_id');
			Invendetails::create($invendetail);

	   		if ($request->get('wr_id') > 0):
				$invendetail['qty'] = -$request->get('qty');
				$invendetail['war_id'] = $request->get('wr_id');
				$invendetail['flag'] = 1;
				Invendetails::create($invendetail);
			endif;
	   	elseif ($request->get('itype')=='Opening'):
			//DB::table('a')->first();
			$invendetail = $request->all();
			$invendetail['user_id'] = Auth::id();
			$invendetail['com_id'] = $com_id;
//			$invendetail['war_id'] = $request->get('wh_id');
			Invendetails::create($invendetail);

	   		if ($request->get('wr_id') > 0):
				$invendetail['qty'] = -$request->get('qty');
				$invendetail['war_id'] = $request->get('wr_id');
				$invendetail['flag'] = 1;
				Invendetails::create($invendetail);
			endif;

		elseif ($request->get('itype')=='Issue'):
			$invendetail = $request->all();
			$invendetail['user_id'] = Auth::id();
			$invendetail['qty'] = -$request->get('qty');
			$invendetail['com_id'] = $com_id;
			$invendetail['war_id'] = $request->get('war_id');
			Invendetails::create($invendetail);	
			if ($request->get('wr_id') > 0):
				$invendetail['qty'] = $request->get('qty');
				$invendetail['war_id'] = $request->get('wr_id');
				$invendetail['flag'] = 1;
				Invendetails::create($invendetail);
			endif;

		endif;
		return redirect('invenmaster/'.$request->get('im_id'));
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
		$invendetail = Invendetails::findOrFail($id);
		return view('acc.invendetail.show', compact(['invendetail', 'langs']));
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
        $project = Projects::where('com_id', $com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $data) {
            $projects[$data['id']] = $data['name'];
        }

  		$warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }
  		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }
  		$ittype = Ittypes::latest()->get();
		$ittypes['']="Select ...";
        foreach($ittype as $data) {
            $ittypes[$data['id']] = $data['name'];
        }
	
	    $langs = $this->language();
		$invendetail = Invendetails::findOrFail($id);
		return view('acc.invendetail.edit', compact(['invendetail', 'langs','warehouses','products','projects','ittypes']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$invendetail = Invendetails::findOrFail($id);
		$invendetail->update($request->all());
		return redirect('invenmaster/'.$request->get('im_id'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$find=DB::table('acc_invendetails')->where('id',$id)->first();
		$find_im_id=''; isset($find) && $find->id>0 ? $find_im_id=$find->im_id : $find_im_id='';
		
		Invendetails::destroy($id);
		return redirect('invenmaster/'.$find_im_id);
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