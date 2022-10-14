<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Projects;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Lcinfos;
use App\Models\Acc\Trandetails;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use App\User;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class ProjectController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$projects = Projects::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $projects = $projects->where('user_id',Auth::id());
        }
		return view('acc.project.index', compact(['projects', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('acc.project.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

	    $project = $request->all();
        $project['user_id'] = Auth::id();
		$project['com_id'] = $com_id;
        Projects::create($project);
		return redirect('acc-project');
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
		$project = Projects::findOrFail($id);
		return view('acc.project.show', compact(['project', 'langs']));
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
		$project = Projects::findOrFail($id);
		return view('acc.project.edit', compact(['project', 'langs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$project = Projects::findOrFail($id);
		$project->update($request->all());
		return redirect('acc-project');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Projects::destroy($id);
		return redirect('acc-project');
	}
  
  public function help()
	{
		$acccoas = Projects::latest()->get();
        $langs = $this->language();
		return view('acc.project.help', compact(['acccoas', 'langs']));
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
 public function report()
	{
		$projects = Projects::latest()->get();
        $langs = $this->language();
		return view('acc.project.report', compact(['projects', 'langs']));
	}
 	public function project_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$project = Projects::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.project.print', compact(['project', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('project List.pdf');
    }
    
    public function project_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$project = Projects::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.project.print', compact(['project', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('project List.pdf');
    }

	public function project_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$project = Projects::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Project List.doc");

		return view('acc.project.word', compact(['project', 'langs']));
	}
    public function project_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Projects', function($excel) {

            	$excel->sheet('Projects', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$project = Projects::where('com_id',$com_id)->latest()->get();
				$langs = $this->language();
                $sheet->loadView('acc.project.excel', ['project' => $project->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function project_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Projects', function($excel) {

            	$excel->sheet('Projects', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$project = Projects::where('com_id',$com_id)->latest()->get();
				$langs = $this->language();
                $sheet->loadView('acc.project.excel', ['project' => $project->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	
	public function ledger()
	{
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $data) {
            $projects[$data['id']] = $data['name'];
        } 
		$tran = array(); //Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
        $langs = $this->language();
		return view('acc.project.ledger', compact(['tran', 'langs', 'acccoa', 'users','projects']));
	}	
		public function prfilter(Request $request)
	{
		
		Session::put('pracc_id', $request->get('acc_id'));
		Session::put('prpro_id', $request->get('pro_id'));
		
		return redirect('acc-project/ledger');

	}
	
	public function ledger_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
		
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.project.ledger_print', compact(['tran', 'langs', 'acccoa', 'users']))->setOption('minimum-font-size', 16);
        return $pdf->stream('ledger.pdf');
    }
	 public function costsheet()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $data) {
            $projects[$data['id']] = $data['name'];
        } 
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$acccoas = Acccoas::where('com_id',$com_id)->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        } 
		$tran = Acccoas::where('group_id',0)->groupBy('id')->get();
        $langs = $this->language();
		return view('acc.project.costsheet', compact(['tran', 'langs', 'acccoa', 'users', 'projects']));
	}
		public function prjfilter(Request $request)
	{
		
		Session::put('prjpro_id', $request->get('pro_id'));
		
		return redirect('acc-project/costsheet');

	}
	 public function projectadvance()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		Session::has('paproj_id') ? $proj_id=Session::get('paproj_id') : $proj_id='' ;// echo $com_id.'osama';

		$afe=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Advance For Expenses')->first();
		$afe_id=''; isset($afe) && $afe->id >0 ? $afe_id=$afe->id : $afe_id='';

		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $data) {
            $projects[$data['id']] = $data['name'];
        } 

		$advance = Trandetails::join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
		->select(DB::raw('sum(amount) as amount, acc_trandetails.sh_id,acc_trandetails.pro_id'))
		->where('pro_id',$proj_id)->where('acc_id',$afe_id)
		->where('acc_trandetails.com_id',$com_id)->where('acc_trandetails.sh_id','>','0')->where('pro_id','>','0')->groupBy('sh_id')->get();

        $langs = $this->language();
		return view('acc.project.projectadvance', compact(['advance', 'langs','projects']));
	}
	public function pafilter(Request $request)
	{
		
		Session::put('paproj_id', $request->get('proj_id'));
		
		return redirect('acc-project/projectadvance');

	}

}