<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Options;
use App\Models\Acc\Currencies;
use App\Models\Acc\Acccoas;
use App\Models\Acc\Warehouses;

use Illuminate\Http\Request;
use App\User;

use Carbon\Carbon;

use Auth;
use DB;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class OptionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$options = Options::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $options = $options->where('user_id',Auth::id());
        }
		return view('acc.option.index', compact(['options', 'langs','users']));
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

		$coa = Acccoas::where('com_id',$com_id)->where('atype','Accont')->latest()->get();
		$coas['']="Select ...";
        foreach($coa as $data) {
            $coas[$data['id']] = $data['name'];
        }
        $cur = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($cur as $data) {
            $currency[$data['id']] = $data['name'];
        }
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		return view('acc.option.create', compact('langs', 'users','currency','coas'));
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

	    $option = $request->all();
        $option['user_id'] = Auth::id();
		$option['com_id'] = $com_id;
        Options::create($option);
		return redirect('option');
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
		$option = Options::findOrFail($id);
		return view('acc.option.show', compact(['option', 'langs']));
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

        $cur = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($cur as $data) {
            $currency[$data['id']] = $data['name'];
        }
        $warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }

		$coa = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$coas['']="Select ...";
        foreach($coa as $data) {
            $coas[$data['id']] = $data['name'];
        }
       	$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$option = Options::findOrFail($id);
		return view('acc.option.edit', compact(['option', 'langs','users','currency','coas','warehouses']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		//DB::table('acc_coas')->where('ids',$id)->first();
		$option = Options::findOrFail($id);
		$option->update($request->all());
		return redirect('option');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Options::destroy($id);
		return redirect('option');
	}
  public function help()
	{
		$acccoas = Options::latest()->get();
        $langs = $this->language();
		return view('acc.option.help', compact(['acccoas', 'langs']));
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
	public function inventory($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $cur = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($cur as $data) {
            $currency[$data['id']] = $data['name'];
        }
		$coa = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$coas['']="Select ...";
        foreach($coa as $data) {
            $coas[$data['id']] = $data['name'];
        }
        $warehouse = Warehouses::where('com_id',$com_id)->latest()->get();
		$warehouses['']="Select ...";
        foreach($warehouse as $data) {
            $warehouses[$data['id']] = $data['name'];
        }
       	$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$option = Options::findOrFail($id);
		return view('acc.option.inventory', compact(['option', 'langs','users','currency','coas','warehouses']));
	}
	public function export($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $cur = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($cur as $data) {
            $currency[$data['id']] = $data['name'];
        }
		$coa = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$coas['']="Select ...";
        foreach($coa as $data) {
            $coas[$data['id']] = $data['name'];
        }
       	$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$option = Options::findOrFail($id);
		return view('acc.option.export', compact(['option', 'langs','users','currency','coas']));
	}
	public function transaction($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $cur = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($cur as $data) {
            $currency[$data['id']] = $data['name'];
        }
		$coa = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$coas['']="Select ...";
        foreach($coa as $data) {
            $coas[$data['id']] = $data['name'];
        }
       	$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$option = Options::findOrFail($id);
		return view('acc.option.transaction', compact(['option', 'langs','users','currency','coas']));
	}
	public function audit($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $cur = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($cur as $data) {
            $currency[$data['id']] = $data['name'];
        }
		$coa = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$coas['']="Select ...";
        foreach($coa as $data) {
            $coas[$data['id']] = $data['name'];
        }
       	$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$option = Options::findOrFail($id);
		return view('acc.option.audit', compact(['option', 'langs','users','currency','coas']));
	}
	public function sale($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $cur = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($cur as $data) {
            $currency[$data['id']] = $data['name'];
        }
		$coa = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$coas['']="Select ...";
        foreach($coa as $data) {
            $coas[$data['id']] = $data['name'];
        }
       	$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$option = Options::findOrFail($id);
		return view('acc.option.sale', compact(['option', 'langs','users','currency','coas']));
	}
	public function purchase($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $cur = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($cur as $data) {
            $currency[$data['id']] = $data['name'];
        }
		$coa = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$coas['']="Select ...";
        foreach($coa as $data) {
            $coas[$data['id']] = $data['name'];
        }
       	$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$option = Options::findOrFail($id);
		return view('acc.option.purchase', compact(['option', 'langs','users','currency','coas']));
	}
	public function import($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $cur = Currencies::latest()->get();
		$currency['']="Select ...";
        foreach($cur as $data) {
            $currency[$data['id']] = $data['name'];
        }
		$coa = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$coas['']="Select ...";
        foreach($coa as $data) {
            $coas[$data['id']] = $data['name'];
        }
       	$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$option = Options::findOrFail($id);
		return view('acc.option.import', compact(['option', 'langs','users','currency','coas']));
	}


}