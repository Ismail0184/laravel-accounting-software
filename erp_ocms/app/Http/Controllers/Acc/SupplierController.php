<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Suppliers;
use App\Models\Acc\Countries;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class SupplierController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
 		
		$countrys = Countries::latest()->get();
		$country['']='Select ...';
		foreach($countrys as $data){
			$country[$data['id']]=$data['name'];
		}
		$suppliers = Suppliers::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $suppliers = $suppliers->where('user_id',Auth::id());
        }
		return view('acc.supplier.index', compact(['suppliers', 'langs','country']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $countrys = Countries::latest()->get();
		$country['']='Select ...';
		foreach($countrys as $data){
			$country[$data['id']]=$data['name'];
		}

		$langs = $this->language();
		return view('acc.supplier.create', compact('langs', 'country'));
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

	    $supplier = $request->all();
        $supplier['user_id'] = Auth::id();
		$supplier['com_id'] =$com_id;
        Suppliers::create($supplier);
		return redirect('supplier');
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
		$supplier = Suppliers::findOrFail($id);
		return view('acc.supplier.show', compact(['supplier', 'langs']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $countrys = Countries::latest()->get();
		$country['']='Select ...';
		foreach($countrys as $data){
			$country[$data['id']]=$data['name'];
		}
        $langs = $this->language();
		$supplier = Suppliers::findOrFail($id);
		return view('acc.supplier.edit', compact(['supplier', 'langs','country']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$supplier = Suppliers::findOrFail($id);
		$supplier->update($request->all());
		return redirect('supplier');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Suppliers::destroy($id);
		return redirect('supplier');
	}
  public function help()
	{
		$suppliers = Suppliers::latest()->get();
        $langs = $this->language();
		return view('acc.supplier.help', compact(['suppliers', 'langs']));
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
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$supplier = Suppliers::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.supplier.report', compact(['supplier', 'langs']));
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
		
	public function report_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$supplier = Suppliers::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.supplier.print', compact(['supplier', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('Supplier.pdf');
    }
    
    public function report_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$supplier = Suppliers::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.supplier.print', compact(['supplier', 'langs', 'day']))->setOption('minimum-font-size', 16);
        return $pdf->download('Supplier.pdf');
    }

	public function report_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$supplier = Suppliers::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Supplier.doc");

		return view('acc.supplier.word', compact(['supplier', 'langs']));
	}
    public function report_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Supplier', function($excel) {

            	$excel->sheet('Supplier', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$supplier = Suppliers::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.supplier.excel', ['supplier' => $supplier->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function report_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('Supplier', function($excel) {

            	$excel->sheet('Supplier', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$supplier = Suppliers::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.supplier.excel', ['supplier' => $supplier->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }

}