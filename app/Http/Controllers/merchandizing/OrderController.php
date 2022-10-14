<?php namespace App\Http\Controllers\merchandizing;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\merchandizing\Orders;
use App\Models\merchandizing\Orderolds;
use App\Models\merchandizing\Lcmodes;
use App\Models\merchandizing\Incoterms;
use App\Models\merchandizing\Bdtypes;
use App\Models\Acc\Currencies;
use App\Models\merchandizing\Marketingteams;
use App\Models\merchandizing\Buyers;
use App\Models\Acc\Companies;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class OrderController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	 
	public function index()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$company = Companies::where('id', $com_id)->first();

		$langs = Languages::lists('value', 'code');
        $orders = Orders::where('com_id', $com_id)->orderBy('jobno','DESC')->latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $orders = $orders->where('user_id',Auth::id());
        }
        $orders = $orders->get();
		return view('merchandizing.order.index', compact(['langs', 'orders','company']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

		$months['']="Select ...";
		for ($i=1; $i<13; $i++){
 			$months[$i] = date("F", mktime(0, 0, 0, $i, 10));
		}
		$years['']="Select ...";
		for ($i=-5; $i<13; $i++){
 			$years[date('Y')+$i] = date('Y')+$i;
		}
		$lcmode=Lcmodes::Latest()->get();
		$lcmodes=array(''=>'Select ...');
		foreach($lcmode as $data):
			$lcmodes[$data['id']]=$data['name'];
		endforeach;
		$incoterm=Incoterms::Latest()->get();
		$incoterms=array(''=>'Select ...');
		foreach($incoterm as $data):
			$incoterms[$data['id']]=$data['name'];
		endforeach;
		$bdtype=Bdtypes::Latest()->get();
		$bdtypes=array(''=>'Select ...');
		foreach($bdtype as $data):
			$bdtypes[$data['id']]=$data['name'];
		endforeach;
		$currency=Currencies::Latest()->get();
		$currencys=array(''=>'Select ...');
		foreach($currency as $data):
			$currencys[$data['id']]=$data['name'];
		endforeach;
		$mt=Marketingteams::Latest()->get();
		$mts=array(''=>'Select ...');
		foreach($mt as $data):
			$mts[$data['id']]=$data['name'];
		endforeach;
		$buyer=Buyers::Latest()->get();
		$buyers=array(''=>'Select ...');
		foreach($buyer as $data):
			$buyers[$data['id']]=$data['name'];
		endforeach;
		$jobno=Orders::where('com_id',$com_id)->max('jobno')+1;
        $langs = Languages::lists('value', 'code');
		return view('merchandizing.order.create', compact('langs','months','years','lcmodes','incoterms','bdtypes','units','mts','buyers','currencys','jobno'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

	    $order = $request->all();
        $order['user_id'] = Auth::id();
		$order['com_id'] = $com_id;
        Orders::create($order);
		$request->get('jobno')!='' ? Session::put('jobno',$request->get('jobno')) :'';
		return redirect('order');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$months['']="Select ...";
		for ($i=1; $i<13; $i++){
 			$months[$i] = date("F", mktime(0, 0, 0, $i, 10));
		}
        $langs = Languages::lists('value', 'code');
		$order = Orders::findOrFail($id);
		return view('merchandizing.order.show', compact(['langs', 'order','months']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$months['']="Select ...";
		for ($i=1; $i<13; $i++){
 			$months[$i] = date("F", mktime(0, 0, 0, $i, 10));
		}
		$years['']="Select ...";
		for ($i=-5; $i<13; $i++){
 			$years[date('Y')+$i] = date('Y')+$i;
		}
		$lcmode=Lcmodes::Latest()->get();
		$lcmodes=array(''=>'Select ...');
		foreach($lcmode as $data):
			$lcmodes[$data['id']]=$data['name'];
		endforeach;
		$incoterm=Incoterms::Latest()->get();
		$incoterms=array(''=>'Select ...');
		foreach($incoterm as $data):
			$incoterms[$data['id']]=$data['name'];
		endforeach;
		$bdtype=Bdtypes::Latest()->get();
		$bdtypes=array(''=>'Select ...');
		foreach($bdtype as $data):
			$bdtypes[$data['id']]=$data['name'];
		endforeach;
		$currency=Currencies::Latest()->get();
		$currencys=array(''=>'Select ...');
		foreach($currency as $data):
			$currencys[$data['id']]=$data['name'];
		endforeach;
		$mt=Marketingteams::Latest()->get();
		$mts=array(''=>'Select ...');
		foreach($mt as $data):
			$mts[$data['id']]=$data['name'];
		endforeach;
		$buyer=Buyers::Latest()->get();
		$buyers=array(''=>'Select ...');
		foreach($buyer as $data):
			$buyers[$data['id']]=$data['name'];
		endforeach;

        $langs = Languages::lists('value', 'code');
		$order = Orders::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $order->user_id != Auth::id()) {
            abort(403);
        }
		return view('merchandizing.order.edit', compact(['langs', 'order','months','years','lcmodes','incoterms','bdtypes','currencys','mts','buyers']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$order = Orders::findOrFail($id);
		$order->update($request->all());
		$request->get('jobno')!='' ? Session::put('jobno',$request->get('jobno')) :'';
		return redirect('order');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Orders::destroy($id);
		return redirect('order');
	}

}