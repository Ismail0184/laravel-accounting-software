<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Salaries;
use App\Models\Acc\Tranmasters;
use App\Models\Acc\Trandetails;
use App\Models\Acc\Empolyees;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class SalaryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $salaries = Salaries::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $salaries = $salaries->where('user_id',Auth::id());
        }
        $salaries = $salaries->get();
		return view('acc.salary.index', compact(['langs', 'salaries']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

        $employee=Empolyees::where('com_id',$com_id)->get();
 	 	$employees=array(''=>'Select ...');
		foreach($employee as $data):
			$employees[$data['id']]=$data['name'];
		endforeach;
        $langs = Languages::lists('value', 'code');
		return view('acc.salary.create', compact('langs','employees'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

	    $salary = $request->all();
        $salary['user_id'] = Auth::id();
        $salary['com_id'] = $com_id;
        Salaries::create($salary);
		return redirect('salary');
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
		$salary = Salaries::findOrFail($id);
		return view('acc.salary.show', compact(['langs', 'salary']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $langs = Languages::lists('value', 'code');
		$salary = Salaries::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
/*        if($user_only && !$admin_user && $salary->user_id != Auth::id()) {
            abort(403);
        }
*//*		$emp=Empolyees::where('department_id','25')->get();
		foreach($emp as $data):
			DB::table('acc_salaries')
            ->where('emp_id', $data->id)
            ->update(['department_id' => 25]);
		endforeach;
*/		return view('acc.salary.edit', compact(['langs', 'salary']));
	}
 
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$salary = Salaries::findOrFail($id);
		$salary->update($request->all());
		return redirect('empolyee/salary');
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Salaries::destroy($id);
		return redirect('salary');
	}
	public function filter(Request $request)
	{
		Session::put('stdate',$request->get('tdate'));
		Session::put('sm_id',$request->get('m_id'));
		Session::put('syear',$request->get('year'));
		Session::put('sdeprt',$request->get('department_id'));
		Session::put('sacc_id',$request->get('acc_id'));

		return redirect('empolyee/salary');
	}
	public function pay($id, Request $request)
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		// salary cash paid
	    if($request->get('amount')!=0):
			$tranmaster = $request->all();
			$tranmaster['user_id'] = Auth::id();
			$tranmaster['com_id'] = $com_id;
			$tranmaster['sh_id'] = '';
			$tranmaster['currency_id'] = '3';
			Tranmasters::create($tranmaster);
		endif;

		$tm=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('vnumber',$request->get('vnumber'))->first();
		isset($tm) && $tm->id >0 ? $tm_id=$tm->id : $tm_id='';
		// Cash Paid	    
	    if($request->get('amount')!=0):
			$trandetail = $request->all();
			$trandetail['user_id'] = Auth::id();
			$trandetail['com_id'] = $com_id;
			$trandetail['tranwiths_id'] =  $request->get('tranwith_id');
			$trandetail['acc_id'] =  $request->get('acc_id');
			$trandetail['tm_id'] =  $tm_id;
			Trandetails::create($trandetail);
			
			$trandetail = $request->all();
			$trandetail['user_id'] = Auth::id();
			$trandetail['com_id'] = $com_id;
			$trandetail['tranwiths_id'] =  $request->get('acc_id');
			$trandetail['acc_id'] =  $request->get('tranwith_id');
			$trandetail['amount'] =  -$request->get('amount');
			$trandetail['m_id'] =  0;
			$trandetail['year'] =  0;
			$trandetail['sh_id'] = 0;
			$trandetail['tm_id'] =  $tm_id;
			$trandetail['flag'] =  1;
        Trandetails::create($trandetail);		
		endif;
		// Advance salary and Loam adjust
			$vnumber = DB::table('acc_tranmasters')->where('com_id',$com_id)->max('vnumber')+1;
		if($request->get('eloan')>0 || $request->get('asalary')>0 || $request->get('esf')>0):
			$tranmaster = $request->all();
			$tranmaster['user_id'] = Auth::id();
			$tranmaster['com_id'] = $com_id;
			$tranmaster['sh_id'] = '';
			$tranmaster['currency_id'] = '3';
			$tranmaster['tranwiths_id'] =  $request->get('acc_id');
			$tranmaster['vnumber'] =  $vnumber;
			$tranmaster['tmamount'] =  (integer)$request->get('eloan')+(integer)$request->get('asalary')+(integer)$request->get('esf');
			$tranmaster['ttype'] = 'Journal';
			$tranmaster['note'] = 'Adjusted with salary';
			Tranmasters::create($tranmaster);
		endif;
		$tm=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('vnumber',$vnumber)->first();
		isset($tm) && $tm->id >0 ? $tm_id=$tm->id : $tm_id='';
		// Transaction Details for Advance Salary
		if($request->get('asalary')>0):
			$trandetail = $request->all();
			$trandetail['user_id'] = Auth::id();
			$trandetail['com_id'] = $com_id;
			$trandetail['tranwiths_id'] =  $request->get('acc_id');
			$trandetail['acc_id'] =  $request->get('as_id');
			$trandetail['amount'] =  -$request->get('asalary');
			$trandetail['ttype'] = 'Journal';
			$trandetail['tm_id'] =  $tm_id;
        Trandetails::create($trandetail);	
		endif;	
		// Transaction Details for Employee Loan
		if($request->get('eloan')>0):
			$trandetail = $request->all();
			$trandetail['user_id'] = Auth::id();
			$trandetail['com_id'] = $com_id;
			$trandetail['tranwiths_id'] =  $request->get('acc_id');
			$trandetail['acc_id'] =  $request->get('el_id');
			$trandetail['amount'] =  -$request->get('eloan');
			$trandetail['ttype'] = 'Journal';
			$trandetail['tm_id'] =  $tm_id;
			Trandetails::create($trandetail);
		endif;

		// Transaction ESF
		if($request->get('esf')>0):
			$trandetail = $request->all();
			$trandetail['user_id'] = Auth::id();
			$trandetail['com_id'] = $com_id;
			$trandetail['tranwiths_id'] =  $request->get('acc_id');
			$trandetail['acc_id'] =  $request->get('esf_id');
			$trandetail['amount'] =  -$request->get('esf');
			$trandetail['ttype'] = 'Journal';
			$trandetail['tm_id'] =  $tm_id;
			Trandetails::create($trandetail);
		endif;

		if($request->get('eloan')>0 || $request->get('asalary')>0 || $request->get('esf')>0):
			$trandetail['user_id'] = Auth::id();
			$trandetail['com_id'] = $com_id;
			$trandetail['tranwiths_id'] =  $request->get('acc_id');
			$trandetail['acc_id'] =  $request->get('acc_id');
			$trandetail['amount'] =  (integer)$request->get('eloan')+(integer)$request->get('asalary')+(integer)$request->get('esf');
			$trandetail['tm_id'] =  $tm_id;
			$trandetail['flag'] =  1;
			Trandetails::create($trandetail);		
		endif;
		

		
		return redirect('empolyee/salary');

	}
	
	function createSalary($id, $m, $y, $asalary, $loan){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$salary=Salaries::where('emp_id',$id)->where('m_id',$m)->where('year',$y)->where('com_id',$com_id)->first();
			$flag=Empolyees::where('id',$id)->where('active','0')->first();
			if(isset($salary) && $salary->id>0 && isset($flag)):
			else:
			$salary=Empolyees::where('id',$id)->first();
				$data=array(
					'emp_id'=>$salary->id,
					'basic'=>$salary->bsalary,
					'hrent'=>$salary->hrent,
					'conv'=>$salary->conv,
					'mexp'=>$salary->mexp,
					'asalary'=>$asalary,
					'loan'=>$loan,
					'm_id'=>$m,
					'department_id'=>$salary->department_id,
					'year'=>$y,
					'user_id'=>Auth::id(),
					'com_id'=>$com_id,
				);
				$m>0 ? Salaries::create($data) : '';
			endif;
			}

		function asalary($id,$m_id, $year){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$as=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Advance Salary')->first(); 
			isset($as) && $as->id > 0 ? $as_id=$as->id : $as_id='';
			$period=array('m_id'=>$m_id, 'year'=>$year,'com_id'=> $com_id);
			$balance=DB::table('acc_trandetails')->where('amount', '>','0')->where('acc_id',$as_id)->where($period)->where('sh_id',$id)->sum('amount');
			return $balance;
		}

		function eloan($id, $m, $y){
			$dt=$y.'-'.$m.'-01';
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$el=DB::table('acc_coas')->where('com_id', $com_id)->where('name','Employee Loan')->first();
			isset($el) && $el->id>0 ? $el_id=$el->id : $el_id='';  
			$eloan=DB::table('acc_trandetails')->join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
			->where('acc_trandetails.com_id', $com_id)->where('acc_id',$el_id)
			->where('amount','>',0)
			->where('tdate','<', $dt)
			->where('acc_trandetails.sh_id',$id)->latest('acc_trandetails.created_at')->first();  

			$balance=DB::table('acc_trandetails')->join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
			->where('acc_trandetails.com_id', $com_id)->where('acc_id',$el->id)->where('tdate','<', $dt)->where('acc_trandetails.sh_id',$id)->sum('amount');
			if(isset($eloan) && $eloan->mdeduction>0 && $eloan->mdeduction < $balance):
					$result=$eloan->mdeduction;
			else:
				$result=$balance;
			endif;
			return $result;
		}
	
	public function salary_has($m_id, $year, $emp_id){
			$count=DB::table('acc_salaries')->where('m_id',$m_id)->where('year',$year)->where('emp_id',$emp_id)->count();
			if ($count>0){
					return false;
				}
			else {
					return true;
				}
			}
			
	public function create_salary()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

		Session::has('sm_id') ? $m_id=Session::get('sm_id') : $m_id=0;
		Session::has('syear') ? $year=Session::get('syear') : $year=2015 ;
		Session::has('sdeprt') ? $department_id=Session::get('sdeprt') : $department_id='' ;
		

		
        $employee=Empolyees::where('com_id',$com_id)->where('department_id',$department_id)->where('active',0)->get();
		foreach($employee as $data):
			$eloan=$this->eloan($data->sh_id, $m_id, $year);
			$asalry=$this->asalary($data->sh_id, $m_id, $year);
			if ($this->salary_has($m_id, $year, $data->id)):
				$this->createSalary($data->id, $m_id,$year,$asalry,$eloan);
			endif;
		endforeach;

		return redirect('empolyee/salary');
	}
	public function delete_salary()
	{
		Session::has('sm_id') ? $m_id=Session::get('sm_id') : $m_id=0;
		Session::has('syear') ? $year=Session::get('syear') : $year=2015 ;
		Session::has('sdeprt') ? $department_id=Session::get('sdeprt') : $department_id='' ;
		$data=array('m_id'=>$m_id,'year'=>$year,'department_id'=>$department_id);
		$affectedRows = Salaries::where($data)->delete();
		return redirect('empolyee/salary');
	}
	public function save_salary()
	{
		Session::has('sm_id') ? $m_id=Session::get('sm_id') : $m_id=0;
		Session::has('syear') ? $year=Session::get('syear') : $year=2015 ;
		Session::has('sdeprt') ? $department_id=Session::get('sdeprt') : $department_id='' ;
		$data=array('m_id'=>$m_id,'year'=>$year,'department_id'=>$department_id);
		$affectedRows = Salaries::where($data)->get();
		foreach( $affectedRows as $item):
			$salary = Salaries::findOrFail($item->id);
			$salary->update(array('save'=>1));
		endforeach;
		return redirect('empolyee/salary');
	}

}