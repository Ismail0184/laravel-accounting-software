<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Budgets;
use App\Models\Acc\Acccoas;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class BudgetController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;
		
		$budgets = Budgets::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $budgets = $budgets->where('user_id',Auth::id());
        }
		return view('acc.budget.index', compact(['budgets', 'langs']));
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

		$account = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$accounts['']="Select ...";
		foreach($account as $account_data):
			$accounts[$account_data['id']]=$account_data['name'];
		endforeach;
        $langs = $this->language();
		return view('acc.budget.create', compact('langs','accounts'));
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

	    $budget = $request->all();
        $budget['user_id'] = Auth::id();
		$budget['com_id'] = $com_id;
        Budgets::create($budget);
		return redirect('budget');
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
		$budget = Budgets::findOrFail($id);
		return view('acc.budget.show', compact(['budget', 'langs']));
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

		$account = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$accounts['']="Select ...";
		foreach($account as $account_data):
			$accounts[$account_data['id']]=$account_data['name'];
		endforeach;
        $langs = $this->language();
		$budget = Budgets::findOrFail($id);
		return view('acc.budget.edit', compact(['budget', 'langs','accounts']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$budget = Budgets::findOrFail($id);
		$budget->update($request->all());
		return redirect('budget');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Budgets::destroy($id);
		return redirect('budget');
	}
  public function help()
	{
		$budgets = Budgets::latest()->get();
        $langs = $this->language();
		return view('acc.budget.help', compact(['budgets', 'langs']));
	}    

	/**
	 * to get report.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$budgets = Budgets::where('com_id',$com_id)->groupBy('name')->get();
        $langs = $this->language();
		return view('acc.budget.report', compact(['budgets', 'langs']));
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
		
		Session::put('bname', $request->get('bname'));
		Session::put('btype', $request->get('btype'));
		Session::put('byear', $request->get('byear'));
		
		return redirect('budget/report');
	}
	public function budget_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$budgets = Budgets::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.budget.budget_print', compact(['budgets', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('budget.pdf');
    }
    
    public function budget_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$budgets = Budgets::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.budget.budget_print', compact(['budgets', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('budget.pdf');
    }

	public function budget_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$budgets = Budgets::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=budgets.doc");

		return view('acc.budget.budget_word', compact(['budgets', 'langs']));
	}
    public function budget_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Budgets', function($excel) {

            	$excel->sheet('Budgets', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$budgets = Budgets::where('com_id',$com_id)->latest()->get();
				$langs = $this->language();
                $sheet->loadView('acc.budget.budget_excel', ['budgets' => $budgets->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function budget_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('Budgets', function($excel) {

            	$excel->sheet('Budgets', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$budgets = Budgets::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.mteam.excel', ['budgets' => $budgets->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }
	public function compare()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;

		$budgets = Budgets::where('com_id',$com_id)->groupBy('name')->get();
        $langs = $this->language();
		return view('acc.budget.compare', compact(['budgets', 'langs']));
	}

}