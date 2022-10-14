<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Usercompanies;
use App\Models\Acc\Companies;
use App\Models\Acc\Departments;
use App\Models\Acc\Acccoas;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use DB;
use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class UsercompanyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$usercompanies = Usercompanies::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $usercompanies = $usercompanies->where('user_id',Auth::id());
        }
		return view('acc.usercompany.index', compact(['usercompanies', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

        $user = User::latest()->get();
		$users['']='Select ...';
		foreach($user as $data){
			$users[$data['id']]=$data['name'];
		}
		$com = Companies::latest()->get();
		$coms['']='Select ...';
		foreach($com as $data){
			$coms[$data['id']]=$data['name'];
		}
		$acc='';
		$acc = Acccoas::where('com_id',$com_id)->where('name','Cash and Bank')->first();
    	isset($acc->id) && $acc->id>0 ? $coas = DB::table('acc_coas')->where('id', $acc->id)->get() : 
		$coas = DB::table('acc_coas')->where('com_id',$com_id)->get();
        $coa = array(''=>'Select ...');		
        foreach ($coas as $data) {
			$coas = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $data->id)->get() ;
            foreach($coas as $data):
				if ($data->atype=='Account'):
					$coa += array($data->id => $data->name);
				endif;
				$coas = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $data->id)->get(); 
				foreach($coas as $data):
					if ($data->atype=='Account'):
						$coa += array($data->id => $data->name);
					endif;
				endforeach;			
			endforeach;
			
        }

        $department=Departments::where('com_id',$com_id)->get();
 	 	$departments=array(''=>'Select ...');
		foreach($department as $data):
			$departments[$data['id']]=$data['name'];
		endforeach;

		$langs = $this->language();
		return view('acc.usercompany.create', compact('langs', 'users','coms','departments','coa'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$find=DB::table('acc_usercompanies')->where('users_id',$request->get('users_id'))
		->where('com_id',$request->get('com_id'))->first();
		if(isset($find) && $find->id > 0):
		Flash::success('Duplicate Connection');
		else:
			$usercompany = $request->all();
			$usercompany['user_id'] = Auth::id();
			Usercompanies::create($usercompany);
		endif;
		return redirect('usercompany');
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
		foreach($user as $data){
			$users[$data['id']]=$data['name'];
		}
		$com = Companies::latest()->get();
		$coms['']='Select ...';
		foreach($com as $data){
			$coms[$data['id']]=$data['name'];
		}
        $department=Departments::where('com_id',$com_id)->get();
 	 	$departments=array(''=>'Select ...');
		foreach($department as $data):
			$departments[$data['id']]=$data['name'];
		endforeach;

		$langs = $this->language();
		$usercompany = Usercompanies::findOrFail($id);
		return view('acc.usercompany.show', compact(['usercompany', 'langs', 'users','coms','departments']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

		$user = User::latest()->get();
		$users['']='Select ...';
		foreach($user as $data){
			$users[$data['id']]=$data['name'];
		}
		$com = Companies::latest()->get();
		$coms['']='Select ...';
		foreach($com as $data){
			$coms[$data['id']]=$data['name'];
		}
        $department=Departments::where('com_id',$com_id)->get();
 	 	$departments=array(''=>'Select ...');
		foreach($department as $data):
			$departments[$data['id']]=$data['name'];
		endforeach;
		$acc='';
		$acc = Acccoas::where('com_id',$com_id)->where('name','Cash and Bank')->first();
    	isset($acc->id) && $acc->id>0 ? $coas = DB::table('acc_coas')->where('id', $acc->id)->get() : 
		$coas = DB::table('acc_coas')->where('com_id',$com_id)->get();
        $coa = array(''=>'Select ...');		
        foreach ($coas as $data) {
			$coas = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $data->id)->get() ;
            foreach($coas as $data):
				if ($data->atype=='Account'):
					$coa += array($data->id => $data->name);
				endif;
				$coas = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $data->id)->get(); 
				foreach($coas as $data):
					if ($data->atype=='Account'):
						$coa += array($data->id => $data->name);
					endif;
				endforeach;			
			endforeach;
			
        }

        $langs = $this->language();
		$usercompany = Usercompanies::findOrFail($id);
		return view('acc.usercompany.edit', compact(['usercompany', 'langs', 'users','coms','departments','coa']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$usercompany = Usercompanies::findOrFail($id);
		$usercompany->update($request->all());
		return redirect('usercompany');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Usercompanies::destroy($id);
		return redirect('usercompany');
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