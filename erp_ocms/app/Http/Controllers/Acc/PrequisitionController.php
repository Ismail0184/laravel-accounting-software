<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Prequisitions;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Currencies;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class PrequisitionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$users = User::lists('name', 'id');
		$prequisitions = Prequisitions::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $prequisitions = $prequisitions->where('user_id',Auth::id());
        }
		return view('acc.prequisition.index', compact(['prequisitions', 'langs','users']));
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
		$user = User::latest()->get();
		$users['']='Select ...';
		foreach($user as $user_data){
			$users[$user_data['id']]=$user_data['name'];
		}
		$currencyz = Currencies::latest()->get();
		$currency['']='Select ...';
		foreach($currencyz as $data){
			$currency[$data['id']]=$data['name'];
		}
		$langs = $this->language();
		return view('acc.prequisition.create', compact('langs','users', 'acccoa', 'currency'));
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

	    $prequisition = $request->all();
        $prequisition['user_id'] = Auth::id();
		$prequisition['com_id'] = $com_id;
        Prequisitions::create($prequisition);
		return redirect('prequisition');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	
		$user = User::latest()->get();
		$users['']='Select ...';
		foreach($user as $user_data){
			$users[$user_data['id']]=$user_data['name'];
		}
        $langs = $this->language();
		$prequisition = Prequisitions::findOrFail($id);
		return view('acc.prequisition.show', compact(['prequisition', 'langs','users']));
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

		$currencyz = Currencies::latest()->get();
		$currency['']='Select ...';
		foreach($currencyz as $data){
			$currency[$data['id']]=$data['name'];
		}

		$acccoas = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$acccoa['']="Select ...";
        foreach($acccoas as $acccoas_data) {
            $acccoa[$acccoas_data['id']] = $acccoas_data['name'];
        }
		$user = User::latest()->get();
		$users['']='Select ...';
		foreach($user as $user_data){
			$users[$user_data['id']]=$user_data['name'];
		}	
        $langs = $this->language();
		$prequisition = Prequisitions::findOrFail($id);
		return view('acc.prequisition.edit', compact(['prequisition', 'langs','users', 'acccoa','currency']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$prequisition = Prequisitions::findOrFail($id);
		$prequisition->update($request->all());
		if ($request->get('check_action')==0):
			return redirect('prequisition');
		else:
			return redirect('prequisition/check');
		endif;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Prequisitions::destroy($id);
		return redirect('prequisition');
	}
  public function help()
	{
		$prequisitions = Prequisitions::latest()->get();
        $langs = $this->language();
		return view('acc.prequisition.help', compact(['prequisitions', 'langs']));
	}   
	/**
	 * to get report.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function report()
	{
		$requisition = Prequisitions::groupBy('name')->get();
        $langs = $this->language();
		return view('acc.prequisition.report', compact(['requisition', 'langs', 'clients', 'acccoa']));
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
	public function check()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$users = User::lists('name', 'id');
		$prequisitions = Prequisitions::where('com_id',$com_id)->where('check_action',0)->where('check_id',Auth::id())->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $prequisitions = $prequisitions->where('user_id',Auth::id());
        }
		return view('acc.prequisition.check', compact(['prequisitions', 'langs','users']));
	}

}