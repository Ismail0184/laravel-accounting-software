<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Qproducts;
use App\Models\Acc\Quotations;
use App\Models\Acc\Products;
use App\Models\Acc\Companies;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use Session;
use Response;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class QproductController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$company=Companies::where('id',$com_id)->first();	
		Session::has('quotation_id') ? $quotation_id=Session::get('quotation_id') : $quotation_id='' ;
		
		$langs = Languages::lists('value', 'code');
        $qproducts = Qproducts::where('quotation_id',$quotation_id)->latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $qproducts = $qproducts->where('user_id',Auth::id());
        }
        $qproducts = $qproducts->get();
		return view('acc.qproduct.index', compact(['langs', 'qproducts','company']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		Session::has('quotation_id') ? $quotation_id=Session::get('quotation_id') : $quotation_id='' ;

		$quotation=Quotations::Latest()->get();
		$quotations=array(''=>'Select ...');
		foreach($quotation as $item):
			$quotations[$item['id']]=$item['name'];
		endforeach;

		$product=Products::where('com_id',$com_id)->where('ptype','Product')->Latest()->get();
		$products=array(''=>'Select ...');
		foreach($product as $item):
			$products[$item['id']]=$item['name'];
		endforeach;

        $langs = Languages::lists('value', 'code');
		return view('acc.qproduct.create', compact('langs','quotations','products','quotation_id'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
	    Session::put('quotation_id',$request->get('quotation_id'));
		
		$qproduct = $request->all();
        $qproduct['user_id'] = Auth::id();
		$qproduct['com_id'] = $com_id;
        Qproducts::create($qproduct);
		return redirect('qproduct');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$qproduct = Qproducts::findOrFail($id);
        $langs = Languages::lists('value', 'code');
	    Session::put('quotation_id',$qproduct->quotation_id);
        $qproducts = Qproducts::where('quotation_id',$qproduct->quotation_id)->latest()->get();
		return view('acc.qproduct.show', compact(['langs', 'qproducts']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$quotation=Quotations::Latest()->get();
		$quotations=array(''=>'Select ...');
		foreach($quotation as $item):
			$quotations[$item['id']]=$item['name'];
		endforeach;

		$product=Products::Latest()->get();
		$products=array(''=>'Select ...');
		foreach($product as $item):
			$products[$item['id']]=$item['name'];
		endforeach;

        $langs = Languages::lists('value', 'code');
		$qproduct = Qproducts::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $qproduct->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.qproduct.edit', compact(['langs', 'qproduct','quotations','products']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$qproduct = Qproducts::findOrFail($id);
		$qproduct->update($request->all());
		return redirect('qproduct');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Qproducts::destroy($id);
		return redirect('qproduct');
	}
public function getPrice($id)
     {
	Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
    $product = DB::table('acc_products')->where('com_id',$com_id)->where('id', $id)->get();
        $options = array();

        foreach ($product as $court) {
            $options += array($court->id => $court->price);
        }
        return Response::json($options);
     }


}