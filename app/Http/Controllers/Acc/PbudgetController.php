<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Pbudgets;
use App\Models\Acc\Pplannings;
use App\Models\Acc\Projects;
use App\Models\Acc\Products;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Currencies;

use Illuminate\Http\Request;
use Carbon\Carbon;

use DB;
use Response;
use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class PbudgetController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$currencys = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($currencys as $currencys_data) {
            $currency[$currencys_data['id']] = $currencys_data['name'];
        }
		$unit = AccUnits::latest()->get();
		$units['']="Select ...";
        foreach($unit as $unit_data) {
            $units[$unit_data['id']] = $unit_data['name'];
        }
		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $product_data) {
            $products[$product_data['id']] = $product_data['name'];
        }
		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $project_data) {
            $projects[$project_data['id']] = $project_data['name'];
        }
		$pplanning = Pplannings::where('com_id',$com_id)->latest()->get();
		$pplannings['']="Select ...";
        foreach($pplanning as $pplanning_data) {
            $pplannings[$pplanning_data['id']] = $pplanning_data['segment'];
        }
		$pbudgets = Pbudgets::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $pbudgets = $pbudgets->where('user_id',Auth::id());
        }
		return view('acc.pbudget.index', compact(['pbudgets', 'langs', 'projects', 'products', 'currency', 'units', 'pplannings']));
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

        $currencys = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($currencys as $currencys_data) {
            $currency[$currencys_data['id']] = $currencys_data['name'];
        }
		$unit = AccUnits::latest()->get();
		$units['']="Select ...";
        foreach($unit as $unit_data) {
            $units[$unit_data['id']] = $unit_data['name'];
        }
		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $product_data) {
            $products[$product_data['id']] = $product_data['name'];
        }
		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $project_data) {
            $projects[$project_data['id']] = $project_data['name'];
        }
		$pplanning = Pplannings::where('com_id',$com_id)->latest()->get();
		$pplannings['']="Select ...";
        foreach($pplanning as $pplanning_data) {
            $pplannings[$pplanning_data['id']] = $pplanning_data['segment'];
        }
		$langs = $this->language();
		return view('acc.pbudget.create', compact('langs', 'pplannings', 'projects', 'units', 'products', 'currency'));
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

	    $pbudget = $request->all();
        $pbudget['user_id'] = Auth::id();
		$pbudget['com_id'] = $com_id;
        Pbudgets::create($pbudget);
		return redirect('pbudget');
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
		$pbudget = Pbudgets::findOrFail($id);
		return view('acc.pbudget.show', compact(['pbudget', 'langs']));
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

        $currencys = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($currencys as $currencys_data) {
            $currency[$currencys_data['id']] = $currencys_data['name'];
        }
		$unit = AccUnits::latest()->get();
		$units['']="Select ...";
        foreach($unit as $unit_data) {
            $units[$unit_data['id']] = $unit_data['name'];
        }
		$product = Products::where('com_id',$com_id)->where('ptype','Product')->latest()->get();
		$products['']="Select ...";
        foreach($product as $product_data) {
            $products[$product_data['id']] = $product_data['name'];
        }
		$segments = Pplannings::where('com_id',$com_id)->latest()->get();
		$segment['']="Select ...";
        foreach($segments as $data) {
            $segment[$data['id']] = $data['segment'];
        }
		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
        foreach($project as $project_data) {
            $projects[$project_data['id']] = $project_data['name'];
        }
        $langs = $this->language();
		$pbudget = Pbudgets::findOrFail($id);
		return view('acc.pbudget.edit', compact(['pbudget', 'langs','projects', 'units', 'products', 'currency','segment']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$pbudget = Pbudgets::findOrFail($id);
		$pbudget->update($request->all());
		return redirect('pbudget');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Pbudgets::destroy($id);
		return redirect('pbudget');
	}
public function getSegment($id)
     {

    $courts = DB::table('acc_pplannings')->where('pro_id', $id)->get();
        $options = array();

        foreach ($courts as $court) {
            $options += array($court->id => $court->segment);
        }

        return Response::json($options);
     }
  
  public function help()
	{
		$acccoas = Pbudgets::latest()->get();
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
	public function report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;
		$project = Projects::where('com_id',$com_id)->latest()->get();
		$projects['']="Select ...";
		foreach($project as $project_data) {
			$projects[$project_data['id']] = $project_data['name'];
		}
		$project = Projects::where('com_id',$com_id)->get();
        $langs = $this->language();
		return view('acc.pbudget.report', compact(['project', 'langs','projects']));
	}
	public function filter(Request $request)
	{
		
		Session::put('bpro_id', $request->get('pro_id'));
		
		return redirect('pbudget/report');
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

}