<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Frequisitions;
use App\Models\Acc\Prequisitions;
use App\Models\Acc\Currencies;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class FrequisitionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$prequisitions = Prequisitions::lists('name', 'id');
		$prequisitiondes = Prequisitions::lists('description', 'id');
		$frequisitions = Frequisitions::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $frequisitions = $frequisitions->where('user_id',Auth::id());
        }
		return view('acc.frequisition.index', compact(['frequisitions', 'langs','prequisitions','prequisitiondes']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		$currencyz = Currencies::latest()->get();
		$currency['']='Select ...';
		foreach($currencyz as $data){
			$currency[$data['id']]=$data['name'];
		}

		$prequisition = Prequisitions::latest('name', 'id')->get();
		$prequisitions['']='Select ...';
		foreach($prequisition as $prequisition_data){
			$prequisitions[$prequisition_data['id']]=$prequisition_data['name'];
		}	
		$user = User::latest('name', 'id')->get();
		$users['']='Select ...';
		foreach($user as $user_data){
			$users[$user_data['id']]=$user_data['name'];
		}
        $langs = $this->language();
		return view('acc.frequisition.create', compact('langs','users','prequisitions','currency'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $frequisition = $request->all();
        $frequisition['user_id'] = Auth::id();
        Frequisitions::create($frequisition);
		return redirect('frequisition');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	$users = User::lists('name', 'id');
		$prequisitions = Prequisitions::lists('name', 'id');
        $langs = $this->language();
		$frequisition = Frequisitions::findOrFail($id);
		return view('acc.frequisition.show', compact(['frequisition', 'langs','prequisitions','users']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$currencyz = Currencies::latest()->get();
		$currency['']='Select ...';
		foreach($currencyz as $data){
			$currency[$data['id']]=$data['name'];
		}

       	$prequisition = Prequisitions::latest('name', 'id')->get();
		$prequisitions['']='Select ...';
		foreach($prequisition as $prequisition_data){
			$prequisitions[$prequisition_data['id']]=$prequisition_data['name'];
		}	
		$user = User::latest('name', 'id')->get();
		$users['']='Select ...';
		foreach($user as $user_data){
			$users[$user_data['id']]=$user_data['name'];
		}
		$langs = $this->language();
		$frequisition = Frequisitions::findOrFail($id);
		return view('acc.frequisition.edit', compact(['frequisition', 'langs','prequisitions','users','currency']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$frequisition = Frequisitions::findOrFail($id);
		$frequisition->update($request->all());
		return redirect('frequisition');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Frequisitions::destroy($id);
		return redirect('frequisition');
	}
  public function help()
	{
		$frequisitions = Frequisitions::latest()->get();
        $langs = $this->language();
		return view('acc.frequisition.help', compact(['frequisitions', 'langs']));
	}    

	/**
	 * to get report.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function report()
	{
		$requisition = Frequisitions::latest()->get();
        $langs = $this->language();
		return view('acc.frequisition.report', compact(['requisition', 'langs', 'clients', 'acccoa']));
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