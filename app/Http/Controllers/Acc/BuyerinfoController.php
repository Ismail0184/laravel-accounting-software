<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Buyerinfos;
use App\Models\Acc\Countries;
use Illuminate\Http\Request;
use Carbon\Carbon;

use DB;
use Auth;
use Session;

use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class BuyerinfoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$countrys = Countries::latest()->get();
		$country['']="Select ...";
        foreach($countrys as $data) {
            $country[$data['id']] = $data['name'];
        }
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$buyerinfos = Buyerinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
		
        if($user_only && !$admin_user) {
            $buyerinfos = $buyerinfos->where('user_id',Auth::id());
        }
		return view('acc.buyerinfo.index', compact(['buyerinfos', 'langs', 'country']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $countrys = Countries::latest()->get();
		$country['']="Select ...";
        foreach($countrys as $data) {
            $country[$data['id']] = $data['name'];
        }
		$langs = $this->language();
		return view('acc.buyerinfo.create', compact('langs', 'country'));
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

		$buyerinfo = $request->all();
        $buyerinfo['user_id'] = Auth::id();
		$buyerinfo['com_id'] = $com_id;
        Buyerinfos::create($buyerinfo);
		return redirect('buyerinfo');
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
		$buyerinfo = Buyerinfos::findOrFail($id);
		return view('acc.buyerinfo.show', compact(['buyerinfo', 'langs']));
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
		$country['']="Select ...";
        foreach($countrys as $data) {
            $country[$data['id']] = $data['name'];
        }
		$langs = $this->language();
		$buyerinfo = Buyerinfos::findOrFail($id);
		return view('acc.buyerinfo.edit', compact(['buyerinfo', 'langs', 'country']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$buyerinfo = Buyerinfos::findOrFail($id);
		$buyerinfo->update($request->all());
		return redirect('buyerinfo');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Buyerinfos::destroy($id);
		return redirect('buyerinfo');
	}

	/**
	 * to get help.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    
	public function help()
	{
		$buyerinfos = Buyerinfos::latest()->get();
        $langs = $this->language();
		return view('acc.buyerinfo.help', compact(['buyerinfos', 'langs']));
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

		$buyer = Buyerinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.buyerinfo.report', compact(['buyer', 'langs']));
	}
	
	
	public function report_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$buyer = Buyerinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.buyerinfo.print', compact(['buyer', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('BuyerList.pdf');
    }
    
    public function report_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$buyer = Buyerinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.buyerinfo.print', compact(['buyer', 'langs', 'day']))->setOption('minimum-font-size', 16);
        return $pdf->download('BuyerList.pdf');
    }

	public function report_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$buyer = Buyerinfos::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=BuyerList.doc");

		return view('acc.buyerinfo.word', compact(['buyer', 'langs']));
	}
    public function report_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('BuyerList', function($excel) {

            	$excel->sheet('BuyerList', function($sheet) {
				$buyer = Buyerinfos::latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.buyerinfo.excel', ['buyer' => $buyer->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function report_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('BuyerList', function($excel) {

            	$excel->sheet('BuyerList', function($sheet) {
				$buyer = Buyerinfos::latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.buyerinfo.excel', ['buyer' => $buyer->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
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

}