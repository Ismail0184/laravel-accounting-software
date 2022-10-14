<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Styles;
use App\Models\Acc\Orderinfos;
use App\Models\Acc\AccUnits;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class StyleController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$order = OrderInfos::where('com_id',$com_id)->latest()->get();
		$orders['']="Select ...";
		foreach($order as $order_data):
			$orders[$order_data['id']]=$order_data['ordernumber'];
		endforeach;
		$styles = Styles::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $styles = $styles->where('user_id',Auth::id());
        }
		return view('acc.style.index', compact(['styles', 'langs', 'orders']));
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
		
		$order = OrderInfos::where('com_id',$com_id)->latest()->get();
		$orders['']="Select ...";
		foreach($order as $order_data):
			$orders[$order_data['id']]=$order_data['ordernumber'];
		endforeach;
        $langs = $this->language();
		return view('acc.style.create', compact('langs', 'orders'));
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

	    $style = $request->all();
        $style['user_id'] = Auth::id();
		$style['com_id'] = $com_id;
		
        Styles::create($style);
		return redirect('style');
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
		$style = Styles::findOrFail($id);
		return view('acc.style.show', compact(['style', 'langs']));
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

		$orders=OrderInfos::where('com_id',$com_id)->lists('ordernumber', 'id');
        $langs = $this->language();
		$style = Styles::findOrFail($id);
		return view('acc.style.edit', compact(['style', 'langs','orders']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$style = Styles::findOrFail($id);
		$style->update($request->all());
		return redirect('style');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Styles::destroy($id);
		return redirect('style');
	}
 
 public function help()
	{
		$styles = Styles::latest()->get();
        $langs = $this->language();
		return view('acc.style.help', compact(['styles', 'langs']));
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
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$order = OrderInfos::where('com_id',$com_id)->latest()->get();
		$orders['']="Select ...";
		foreach($order as $order_data):
			$orders[$order_data['id']]=$order_data['ordernumber'];
		endforeach;
		$styles = Styles::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.style.report', compact(['styles', 'langs','orders']));
	}
		
	public function report_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$styles = Styles::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.style.print', compact(['styles', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('Style.pdf');
    }
    
    public function report_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$styles = Styles::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.style.print', compact(['styles', 'langs', 'day']))->setOption('minimum-font-size', 16);
        return $pdf->download('Style.pdf');
    }

	public function report_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$styles = Styles::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Style.doc");

		return view('acc.style.word', compact(['styles', 'langs']));
	}
    public function report_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Style', function($excel) {

            	$excel->sheet('Style', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$styles = Styles::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.style.excel', ['styles' => $styles->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function report_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('Style', function($excel) {

            	$excel->sheet('Style', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$styles = Styles::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.style.excel', ['styles' => $styles->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }

}