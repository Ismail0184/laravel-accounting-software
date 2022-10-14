<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Lcimports;
use App\Models\Acc\Suppliers;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Currencies;
use App\Models\Acc\Countries;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class LcimportController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$countrys = Countries::latest()->get();
		$country['']='Select ...';
		foreach($countrys as $data){
			$country[$data['id']]=$data['name'];
		}

		$lcimports = Lcimports::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $lcimports = $lcimports->where('user_id',Auth::id());
        }
		return view('acc.lcimport.index', compact(['lcimports', 'langs','country']));
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

		$currencys=Currencies::latest('name', 'id')->get();
		$currency['']="Select ...";
		foreach($currencys as $data){
			$currency[$data['id']]=$data['name'];
			}
		$countrys=Countries::latest('name', 'id')->get();
		$country['']="Select ...";
		foreach($countrys as $data){
			$country[$data['id']]=$data['name'];
			}
		$suppliers=Suppliers::where('com_id',$com_id)->latest('name', 'id')->get();
		$supplier['']="Select ...";
		foreach($suppliers as $suppliers_data){
			$supplier[$suppliers_data['id']]=$suppliers_data['name'];
			}
		$unit=AccUnits::latest('name', 'id')->get();
		$units['']="Select ...";
		foreach($unit as $unit_data){
			$units[$unit_data['id']]=$unit_data['name'];
			}
        $langs = $this->language();
		return view('acc.lcimport.create', compact('langs','supplier', 'units','currency','country'));
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

	    $lcimport = $request->all();
        $lcimport['user_id'] = Auth::id();
		 $lcimport['com_id'] =$com_id;
        Lcimports::create($lcimport);
		return redirect('lcimport');
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
		$lcimport = Lcimports::findOrFail($id);
		return view('acc.lcimport.show', compact(['lcimport', 'langs']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
		$countrys=Countries::latest('name', 'id')->get();
		$country['']="Select ...";
		foreach($countrys as $data){
			$country[$data['id']]=$data['name'];
			}
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$currencys=Currencies::latest('name', 'id')->get();
		$currency['']="Select ...";
		foreach($currencys as $data){
			$currency[$data['id']]=$data['name'];
			}
		$unit=AccUnits::latest('name', 'id')->get();
		$units['']="Select ...";
		foreach($unit as $unit_data){
			$units[$unit_data['id']]=$unit_data['name'];
			}
		$suppliers=Suppliers::where('com_id',$com_id)->latest('name', 'id')->get();
		$supplier['']="Select ...";
		foreach($suppliers as $suppliers_data){
			$supplier[$suppliers_data['id']]=$suppliers_data['name'];
			}
        $langs = $this->language();
		$lcimport = Lcimports::findOrFail($id);
		return view('acc.lcimport.edit', compact(['lcimport', 'langs','supplier', 'units', 'currency','country']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$lcimport = Lcimports::findOrFail($id);
		$lcimport->update($request->all());
		return redirect('lcimport');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Lcimports::destroy($id);
		return redirect('lcimport');
	}
   public function help()
	{
		$Lcimports = Lcimports::latest()->get();
        $langs = $this->language();
		return view('acc.lcimport.help', compact(['Lcimports', 'langs']));
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

		$lcimport = Lcimports::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.lcimport.report', compact(['lcimport', 'langs']));
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

		$lcimport = Lcimports::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.lcimport.print', compact(['lcimport', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('Lcimport.pdf');
    }
    
    public function report_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$lcimport = Lcimports::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.lcimport.print', compact(['lcimport', 'langs', 'day']))->setOption('minimum-font-size', 16);
        return $pdf->download('Lcimport.pdf');
    }

	public function report_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$lcimport = Lcimports::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Lcimport.doc");

		return view('acc.lcimport.word', compact(['lcimport', 'langs']));
	}
    public function report_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Lcimport', function($excel) {

            	$excel->sheet('Lcimport', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$lcimport = Lcimports::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.lcimport.excel', ['lcimport' => $lcimport->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function report_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('Lcimport', function($excel) {

            	$excel->sheet('Lcimport', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$lcimport = Lcimports::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.lcimport.excel', ['lcimport' => $lcimport->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }

}