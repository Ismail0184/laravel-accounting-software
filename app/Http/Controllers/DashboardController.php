<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use DB;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Tranmasters;
use App\Models\Acc\Trandetails;
use App\Models\Acc\Invendetails;
use App\Models\Acc\Products;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Warehouses;

use Session;
use App\Models\Lib\Languages;


class DashboardController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
		$this->middleware('auth', ['only' => 'logged']);
	}

	public function index()
	{
		return view('dashboard.index');
	}
	
	public function topsheet()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		Session::put('subdfrom', date('Y-m-01'));
		Session::put('subdto', date('Y-m-d'));

		$langs = Languages::lists('value', 'code');

		$acc = Acccoas::where('com_id',$com_id)->where('name','Cash and Bank')->first();
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
		$units=AccUnits::lists('name', 'id');
		$chart=Acccoas::where('com_id',$com_id)->where('name','Sundry Debtors')->first();
    	isset($chart->id) && $chart->id>0 ? $sdebtors = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $chart->id)->lists('name','id') : $sdebtors='';

		$chart=Acccoas::where('com_id',$com_id)->where('name','Sundry Creditors')->first();
    	isset($chart->id) && $chart->id>0 ? $screditors = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $chart->id)->lists('name','id') : $screditors='';
		
		$projects = DB::table('acc_projects')->where('com_id',$com_id)->Latest()->get();
		$texpenses=Trandetails::join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
		->where('tdate',date('Y-m-d'))->where('acc_tranmasters.com_id',$com_id)->where('flag',0)->where('ttype','Payment')->get();

		$adv=Acccoas::where('com_id',$com_id)->where('name','Advance for Expenses')->first();
		isset($adv) && $adv->id> 0 ? $adv_id=$adv->id : $adv_id='';
		Session::put('subacc_id', $adv_id);
 		$advance=Trandetails::select(DB::raw('sum(amount) as amount, sh_id'))->where('acc_id',$adv_id)->groupBy('sh_id')->where('com_id',$com_id)->where('sh_id','>','0')->get();
		$wh = Warehouses::where('com_id',$com_id)->latest()->get();
		$whs['']="Select ...";
        foreach($wh as $acccoas_data) {
            $whs[$acccoas_data['id']] = $acccoas_data['name'];
        }
		
		$stock=Invendetails::select(DB::raw('sum(qty) as qty, item_id','war_id'))->groupBy('item_id','war_id')->where('com_id',$com_id)->get();
		return view('dashboard.topsheet', compact(['coa', 'langs','sdebtors','screditors','projects','texpenses','stock','units','advance','whs']));
	}

	public function coming()
	{
		return view('dashboard.coming');
	}
	public function stock()
	{
		$id = \Input::get('id');
		
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		Session::has('extdate') ? $tdate=Session::get('extdate') : $tdate='0000-00-00' ; //echo $tdate.'osama';

		$langs = Languages::lists('value', 'code');
		$stock=Invendetails::select(DB::raw('sum(qty) as qty, item_id','war_id'))->groupBy('item_id','war_id')->where('com_id',$com_id)->where('war_id',$id)->get();
		
		return view('dashboard.stock',compact(['stock', 'langs']));
	}
	public function display()
	{
		$id = \Input::get('id');
		
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		Session::has('extdate') ? $tdate=Session::get('extdate') : $tdate='0000-00-00' ; //echo $tdate.'osama';

		$langs = Languages::lists('value', 'code');
		$texpenses=Trandetails::join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
		->where('tdate',$id)->where('acc_tranmasters.com_id',$com_id)->where('flag',0)->where('ttype','Payment')->get();
		
		return view('dashboard.display',compact(['texpenses', 'langs']));
	}

	public function ajaxsample()
	{
		return view('dashboard.ajaxsample');
	}
	
	public function get(){


		$entry = 'coming.jpg';
		$file = Storage::disk('local')->get($entry);

		return (new Response($file, 200))
              ->header('Content-Type', 'image/jpeg');

	}

public function tdayex($id)
     {
		Session::put('extdate',$id);
     }
}
