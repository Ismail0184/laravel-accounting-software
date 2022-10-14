<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Reconciliations;
use App\Models\Acc\Acccoas;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session; 
use DB; 
use App\User; 
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class ReconciliationController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$langs = Languages::lists('value', 'code');
        $reconciliations = Reconciliations::where('com_id',$com_id)->latest()->get();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $reconciliations = $reconciliations->where('user_id',Auth::id());
        }
		return view('acc.reconciliation.index', compact(['langs', 'reconciliations']));
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

		$acc = Acccoas::where('com_id',$com_id)->where('name','Bank Account')->first();
    	isset($acc->id) && $acc->id>0 ? $coas = DB::table('acc_coas')->where('com_id',$com_id)->where('id', $acc->id)->get() : 
		$coas = DB::table('acc_coas')->get();
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
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 

        $langs = Languages::lists('value', 'code');
		return view('acc.reconciliation.create', compact('langs','coa','acccoa'));
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
		
		// date range	
		$pm=date('m',strtotime($request->get('tdate')));
		$pm==12 ? $pm='01' : $pm=$pm;
		$pm==12 ? $y=date('Y' ,strtotime($request->get('tdate')))-1 : $y=date('Y',strtotime($request->get('tdate')));
		strlen($pm)==1 ? $pm='0'.$pm : '';
		$pmfd=date($y.'-'.$pm.'-01');
		$pmld=date($y.'-'.$pm.'-t');
		Session::put('rpmfd',$pmfd);
		Session::put('rpmld',$pmld);
		// ========date range close==============
		
		Session::put('racc_id',$request->get('acc_id'));
		
	    $reconciliation = $request->all();
        $reconciliation['user_id'] = Auth::id();
		$reconciliation['com_id'] = $com_id;
        Reconciliations::create($reconciliation);
		return redirect('reconciliation');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $langs = Languages::lists('value', 'code');
		$reconciliation = Reconciliations::findOrFail($id);
		return view('acc.reconciliation.show', compact(['langs', 'reconciliation']));
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

		$acc = Acccoas::where('com_id',$com_id)->where('name','Bank Account')->first();
    	isset($acc->id) && $acc->id>0 ? $coas = DB::table('acc_coas')->where('com_id',$com_id)->where('id', $acc->id)->get() : 
		$coas = DB::table('acc_coas')->get();
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
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 

        $langs = Languages::lists('value', 'code');
		$reconciliation = Reconciliations::findOrFail($id);
		return view('acc.reconciliation.edit', compact(['langs', 'reconciliation','coa','acccoa']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		// date range	
		$pm=date('m',strtotime($request->get('tdate')));
		$pm==12 ? $pm='01' : $pm=$pm;
		$pm==12 ? $y=date('Y' ,strtotime($request->get('tdate')))-1 : $y=date('Y',strtotime($request->get('tdate')));
		strlen($pm)==1 ? $pm='0'.$pm : '';
		$pmfd=date($y.'-'.$pm.'-01');
		$pmld=date($y.'-'.$pm.'-t');
		Session::put('rpmfd',$pmfd);
		Session::put('rpmld',$pmld);
		// ========date range close==============

		$reconciliation = Reconciliations::findOrFail($id);
		$reconciliation->update($request->all());
		return redirect('reconciliation');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Reconciliations::destroy($id);
		return redirect('reconciliation');
	}

public function bankcash($id)
     {	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$acc = Acccoas::where('com_id',$com_id)->where('name','Bank Account')->first();
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
	public function report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$acc = Acccoas::where('com_id',$com_id)->where('name','Bank Account')->first();
    	isset($acc->id) && $acc->id>0 ? $coas = DB::table('acc_coas')->where('com_id',$com_id)->where('id', $acc->id)->get() : 
		$coas = DB::table('acc_coas')->get();
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

		$langs = Languages::lists('value', 'code');
        $reconciliations = Reconciliations::where('com_id',$com_id)->oldest()->get();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $reconciliations = $reconciliations->where('user_id',Auth::id());
        }
		return view('acc.reconciliation.report', compact(['langs', 'reconciliations','coa']));
	}
	public function recfilter(Request $request)
	{
		
		Session::put('racc_id', $request->get('acc_id'));
		Session::put('rdfrom', $request->get('dfrom'));
		Session::put('rdto', $request->get('dto'));
		
		return redirect('reconciliation/report');

	}
	public function report_print(){  
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
		$reconciliations = Reconciliations::where('com_id',$com_id)->oldest()->get();
        $langs = Languages::lists('value', 'code');
		
        $pdf = \PDF::loadView('acc.reconciliation.report_print', compact(['reconciliations', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 16);
        return $pdf->stream('Reconciliation.pdf');
    }
    
    public function  report_pdf(){  
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
		$reconciliations = Reconciliations::where('com_id',$com_id)->oldest()->get();
        $langs = Languages::lists('value', 'code');
		
        $pdf = \PDF::loadView('acc.reconciliation.report_print', compact(['reconciliations', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 16);
        return $pdf->stream('Reconciliation.pdf');
		}

	public function  report_word()
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
		$reconciliations = Reconciliations::where('com_id',$com_id)->oldest()->get();
        $langs = Languages::lists('value', 'code');
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Reconciliation.doc");

		return view('acc.reconciliation.report_word', compact(['reconciliations', 'langs', 'acccoa', 'users']));
	}
    public function  report_excel(){

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
	public function rdatefilter(Request $request)
	{
		
		Session::put('rpmfd',$request->get('dfrom'));
		Session::put('rpmld',$request->get('dto'));
		
		return redirect('reconciliation');

	}

}