<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Mteams;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use App\User;

use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class MteamController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$mteams = Mteams::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $mteams = $mteams->where('user_id',Auth::id());
        }
		return view('acc.mteam.index', compact(['mteams', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
        $langs = $this->language();
		return view('acc.mteam.create', compact('langs','users'));
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

	    $mteam = $request->all();
        $mteam['user_id'] = Auth::id();
        $mteam['com_id'] = $com_id;
        Mteams::create($mteam);
		return redirect('mteam');
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
		$mteam = Mteams::findOrFail($id);
		return view('acc.mteam.show', compact(['mteam', 'langs']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
        $langs = $this->language();
		$mteam = Mteams::findOrFail($id);
		return view('acc.mteam.edit', compact(['mteam', 'langs','users']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$mteam = Mteams::findOrFail($id);
		$mteam->update($request->all());
		return redirect('mteam');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Mteams::destroy($id);
		return redirect('mteam');
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

		$mteam = Mteams::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		return view('acc.mteam.report', compact(['mteam', 'langs']));
	}

	public function report_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$mteam = Mteams::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.mteam.print', compact(['mteam', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('Mteams.pdf');
    }
    
    public function report_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$mteam = Mteams::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.outlet.print', compact(['mteam', 'langs', 'day']))->setOption('minimum-font-size', 16);
        return $pdf->download('Mteams.pdf');
    }

	public function report_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$mteam = Mteams::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Mteams.doc");

		return view('acc.mteam.word', compact(['mteam', 'langs']));
	}
    public function report_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Mteams', function($excel) {

            	$excel->sheet('Mteams', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$mteam = Mteams::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.mteam.excel', ['mteam' => $mteam->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function report_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('Mteams', function($excel) {

            	$excel->sheet('Mteams', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$mteam = Mteams::where('com_id',$com_id)->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.mteam.excel', ['mteam' => $mteam->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }

}