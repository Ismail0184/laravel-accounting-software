<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use  App\Models\Acc\Acccoas;
use  App\Models\Acc\Empolyees;
use  App\Models\Acc\Salaries;
use  App\Models\Acc\Subheads;
use  App\Models\Acc\Desigtns;
use  App\Models\Acc\Departments;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class EmpolyeeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$cname=Controller::comp();
		$langs = Languages::lists('value', 'code');
        $empolyees = Empolyees::where('com_id',$com_id)->latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $empolyees = $empolyees->where('user_id',Auth::id());
        }
        $empolyees = $empolyees->get();
		return view('acc.empolyee.index', compact(['langs', 'empolyees','cname']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

        $subhead=Subheads::where('com_id',$com_id)->get();
 	 	$subheads=array(''=>'Select ...');
		foreach($subhead as $data):
			$subheads[$data['id']]=$data['name'];
		endforeach;

        $department=Departments::where('com_id',$com_id)->get();
 	 	$departments=array(''=>'Select ...');
		foreach($department as $data):
			$departments[$data['id']]=$data['name'];
		endforeach;

        $designation=Desigtns::where('com_id',$com_id)->get();
 	 	$designations=array(''=>'Select ...');
		foreach($designation as $data):
			$designations[$data['id']]=$data['name'];
		endforeach;

		$langs = Languages::lists('value', 'code');
		return view('acc.empolyee.create', compact('langs','subheads','departments','designations'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

	    $empolyee = $request->all();
        $empolyee['user_id'] = Auth::id();
		$empolyee['com_id'] = $com_id;
        Empolyees::create($empolyee);
		return redirect('empolyee');
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
		$empolyee = Empolyees::findOrFail($id);
		return view('acc.empolyee.show', compact(['langs', 'empolyee']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

        $subhead=Subheads::where('com_id',$com_id)->get();
 	 	$subheads=array(''=>'Select ...');
		foreach($subhead as $data):
			$subheads[$data['id']]=$data['name'];
		endforeach;

        $department=Departments::where('com_id',$com_id)->get();
 	 	$departments=array(''=>'Select ...');
		foreach($department as $data):
			$departments[$data['id']]=$data['name'];
		endforeach;

        $designation=Desigtns::where('com_id',$com_id)->get();
 	 	$designations=array(''=>'Select ...');
		foreach($designation as $data):
			$designations[$data['id']]=$data['name'];
		endforeach;

        $langs = Languages::lists('value', 'code');
		$empolyee = Empolyees::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $empolyee->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.empolyee.edit', compact(['langs', 'empolyee','subheads','departments','designations']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$empolyee = Empolyees::findOrFail($id);
		$empolyee->update($request->all());
		return redirect('empolyee');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Empolyees::destroy($id);
		return redirect('empolyee');
	}

	public function salary()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$cname=Controller::comp();
		$m_id=date('m')-1;
		$year=date('Y');

        $department=Departments::where('com_id',$com_id)->get();
 	 	$departments=array(''=>'Select ...');
		foreach($department as $data):
			$departments[$data['id']]=$data['name'];
		endforeach;

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
		Session::has('sm_id') ? $m_id=Session::get('sm_id') : $m_id=0;
		Session::has('syear') ? $year=Session::get('syear') : $year=2015 ;

		Session::has('sdeprt') ? $department_id=Session::get('sdeprt') : $department_id='' ;
		$deprt=DB::table('acc_departments')->where(array('com_id'=>$com_id,'id'=>$department_id))->first();
		$deprt_name=''; isset($deprt) && $deprt->id>0 ? $deprt_name=$deprt->name : $deprt_name='';
		$period=array('m_id'=>$m_id,'year'=>$year,'acc_empolyees.department_id'=>$department_id);	
		$langs = Languages::lists('value', 'code');
        $department = Salaries::join('acc_empolyees','acc_salaries.emp_id','=','acc_empolyees.id')->where('acc_empolyees.com_id',$com_id)->where($period)->orderBy('sl')->get();
       // $department = Empolyees::where('acc_empolyees.com_id',$com_id)->where('department_id',$department_id)->where('active',0)->orderBy('sl')->get();

		return view('acc.empolyee.salary', compact(['langs', 'department','cname','departments','deprt_name','coa']));
		
	}
	public function salary_print()
	{

        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$cname=Controller::comp();
		$m_id=date('m')-1;
		$year=date('Y');

        $department=Departments::where('com_id',$com_id)->get();
 	 	$departments=array(''=>'Select ...');
		foreach($department as $data):
			$departments[$data['id']]=$data['name'];
		endforeach;

		Session::has('sdeprt') ? $department_id=Session::get('sdeprt') : $department_id='' ;
		$deprt=DB::table('acc_departments')->where(array('com_id'=>$com_id,'id'=>$department_id))->first();
		$deprt_name=''; isset($deprt) && $deprt->id>0 ? $deprt_name=$deprt->name : $deprt_name='';

		Session::has('sdeprt') ? $department_id=Session::get('sdeprt') : $department_id='' ;
		$langs = Languages::lists('value', 'code');
        $department = Empolyees::where('acc_empolyees.com_id',$com_id)->where('department_id',$department_id)->where('active',0)->orderBy('sl')->get();
	
        $pdf = \PDF::loadView('acc.empolyee.salary_print', compact(['langs', 'department','cname','departments','deprt_name']))->setPaper('letter')->setOrientation('landscape')->setOption('margin-left', 10)->setOption('margin-right', 10);
        return $pdf->stream('salary_print.pdf');
		
	}
	public function payslip($id)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$cname=Controller::comp();
		$m_id=date('m')-1;
		$year=date('Y');

        $department=Departments::where('com_id',$com_id)->get();
 	 	$departments=array(''=>'Select ...');
		foreach($department as $data):
			$departments[$data['id']]=$data['name'];
		endforeach;

		Session::has('sdeprt') ? $department_id=Session::get('sdeprt') : $department_id='' ;

		$langs = Languages::lists('value', 'code');
		$deprt=DB::table('acc_departments')->where(array('com_id'=>$com_id,'id'=>$department_id))->first();
		$deprt_name=''; isset($deprt) && $deprt->id>0 ? $deprt_name=$deprt->name : $deprt_name='';

        $department = Empolyees::where('acc_empolyees.com_id',$com_id)->where('department_id',$department_id)->where('id',$id)->where('active',0)->orderBy('sl')->get();

		return view('acc.empolyee.payslip', compact(['langs', 'department','cname','departments','deprt_name','id']));
		
	}

	public function payslip_print($id)
	{

        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$cname=Controller::comp();
		$m_id=date('m')-1;
		$year=date('Y');

        $department=Departments::where('com_id',$com_id)->get();
 	 	$departments=array(''=>'Select ...');
		foreach($department as $data):
			$departments[$data['id']]=$data['name'];
		endforeach;

		Session::has('sdeprt') ? $department_id=Session::get('sdeprt') : $department_id='' ;

		$langs = Languages::lists('value', 'code');
		$deprt=DB::table('acc_departments')->where(array('com_id'=>$com_id,'id'=>$department_id))->first();
		$deprt_name=''; isset($deprt) && $deprt->id>0 ? $deprt_name=$deprt->name : $deprt_name='';

        $department = Empolyees::where('acc_empolyees.com_id',$com_id)->where('department_id',$department_id)->where('id',$id)->where('active',0)->orderBy('sl')->get();
	
        $pdf = \PDF::loadView('acc.empolyee.payslip_print', compact(['langs', 'department','cname','departments','deprt_name','id']))->setOrientation('landscape')->setOption('minimum-font-size', 10);
        return $pdf->stream('salary_print.pdf');
		
	}

}