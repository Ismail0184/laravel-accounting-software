<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Coaconditions;
use App\Models\Acc\Acccoas;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class CoaconditionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$coaconditions = Coaconditions::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $coaconditions = $coaconditions->where('user_id',Auth::id());
        }
		return view('acc.coacondition.index', compact(['coaconditions', 'langs']));
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

        $acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        }
		$langs = $this->language();
		return view('acc.coacondition.create', compact('langs','acccoa'));
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

	    $coacondition = $request->all();
        $coacondition['user_id'] = Auth::id();
		$coacondition['com_id'] = $com_id;
        Coaconditions::create($coacondition);
		return redirect('coacondition');
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
		$coacondition = Coaconditions::findOrFail($id);
		return view('acc.coacondition.show', compact(['coacondition', 'langs']));
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

        $acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        }
		$langs = $this->language();
		$coacondition = Coaconditions::findOrFail($id);
		return view('acc.coacondition.edit', compact(['coacondition', 'langs','acccoa']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$coacondition = Coaconditions::findOrFail($id);
		$coacondition->update($request->all());
		return redirect('coacondition');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Coaconditions::destroy($id);
		return redirect('coacondition');
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