<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Pplannings;
use App\Models\Acc\Projects;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class PplanningController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $project_data) {
            $projects[$project_data['id']] = $project_data['name'];
        }
		$pplannings = Pplannings::where('com_id',$com_id)->where('group_id','0')->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $pplannings = $pplannings->where('user_id',Auth::id());
        }
		return view('acc.pplanning.index', compact(['pplannings', 'langs', 'projects']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;
        
		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $project_data) {
            $projects[$project_data['id']] = $project_data['name'];
        }
		$group = Pplannings::where('com_id',$com_id)->latest()->get();
		$groups['']="Select ...";
        foreach($group as $group_data) {
            $groups[$group_data['id']] = $group_data['segment'];
        }
		$langs = $this->language();
		return view('acc.pplanning.create', compact('langs', 'projects', 'groups'));
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

	    $pplanning = $request->all();
        $pplanning['user_id'] = Auth::id();
		$pplanning['com_id'] = $com_id;
        Pplannings::create($pplanning);
		return redirect('pplanning');
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
		$pplanning = Pplannings::findOrFail($id);
		return view('acc.pplanning.show', compact(['pplanning', 'langs']));
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
		$com_id=Session::get('com_id') : $com_id='' ;

		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $project_data) {
            $projects[$project_data['id']] = $project_data['name'];
        }
		$group = Pplannings::where('com_id',$com_id)->latest()->get();
        $groups['']="Select ...";
        foreach($group as $group_data) {
            $groups[$group_data['id']] = $group_data['segment'];
        }
		
		$langs = $this->language();
		$pplanning = Pplannings::findOrFail($id);
		return view('acc.pplanning.edit', compact(['pplanning', 'langs', 'groups','projects']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$pplanning = Pplannings::findOrFail($id);
		$pplanning->update($request->all());
		return redirect('pplanning');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Pplannings::destroy($id);
		return redirect('pplanning');
	}
   
  public function help()
	{
		$acccoas = Pplannings::latest()->get();
        $langs = $this->language();
		return view('acc.acccoa.help', compact(['acccoas', 'langs']));
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
	public function filter(Request $request)
	{
		
		Session::put('pro_id', $request->get('pro_id'));
		
		return redirect('pplanning/report');
	}
	 public function report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $project_data) {
            $projects[$project_data['id']] = $project_data['name'];
        }
		$project = Projects::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.pplanning.report', compact(['project', 'langs','projects']));
	}
 	public function pplanning_print(){  
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $project_data) {
            $projects[$project_data['id']] = $project_data['name'];
        }
		$project = Projects::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.pplanning.print', compact(['project', 'langs','projects']))->setOption('minimum-font-size', 16);
        return $pdf->stream('Project Planning List.pdf');
    }
    
    public function pplanning_pdf(){  
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $project_data) {
            $projects[$project_data['id']] = $project_data['name'];
        }
		$project = Projects::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.pplanning.print', compact(['project', 'langs','projects']))->setOption('minimum-font-size', 16);
        return $pdf->stream('Project Planning List.pdf');
    }

	public function pplanning_word()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $project_data) {
            $projects[$project_data['id']] = $project_data['name'];
        }
		$project = Projects::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Project Planning Report.doc");

		return view('acc.pplanning.word', compact(['project', 'langs','projects']));
	}
    public function pplanning_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Project planning', function($excel) {

            	$excel->sheet('Project planning', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$project = Projects::where('com_id',$com_id)->latest()->get();
				$projects['']="Select ...";
				foreach($project as $project_data) {
					$projects[$project_data['id']] = $project_data['name'];
				}
				$project = Projects::where('com_id',$com_id)->latest()->get();
				$langs = $this->language();
                $sheet->loadView('acc.pplanning.excel', ['project' => $project->toArray(), 'langs' => $langs, 'projects'=>$projects ]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function pplanning_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Project planning', function($excel) {

            	$excel->sheet('Project planning', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$project = Projects::where('com_id',$com_id)->latest()->get();
				$projects['']="Select ...";
				foreach($project as $project_data) {
					$projects[$project_data['id']] = $project_data['name'];
				}
				$project = Projects::where('com_id',$com_id)->latest()->get();
				$langs = $this->language();
                $sheet->loadView('acc.pplanning.excel', ['project' => $project->toArray(), 'langs' => $langs, 'projects'=>$projects ]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }

}