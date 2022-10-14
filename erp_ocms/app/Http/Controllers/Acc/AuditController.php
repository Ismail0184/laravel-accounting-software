<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Audits;
use App\Models\Acc\Tranmasters;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;

use Auth;
use DB;
use Session; 
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class AuditController extends Controller {

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
		$audits = Audits::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $audits = $audits->where('user_id',Auth::id());
        }
		return view('acc.audit.index', compact(['audits', 'langs', 'users']));
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

        $vn = Tranmasters::where('com_id',$com_id)->where('audit_action',2)->groupBy('vnumber')->latest()->get();
		$vnumber['']="Select ...";
        foreach($vn as $data) {
			$find=DB::table('acc_audits')->where('com_id',$com_id)->where('vnumber',$data['vnumber'])->first();
			if (isset($find) && $find->id >0 ):
			else:
            	$vnumber[$data['id']] = 'VNo: '.$data['vnumber'].'('.$data['tdate'].'/'.$data['note'].')';
			endif;
        }
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		return view('acc.audit.create', compact('langs', 'users','vnumber'));
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

	    $audit = $request->all();
        $audit['user_id'] = Auth::id();
		$audit['com_id'] = $com_id;
        Audits::create($audit);
		return redirect('audit');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

        $user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$langs = $this->language();
		$audit = Audits::findOrFail($id);
		return view('acc.audit.show', compact(['audit', 'langs', 'users']));
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
		$audit = Audits::findOrFail($id);
		return view('acc.audit.edit', compact(['audit', 'langs', 'users']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$audit = Audits::findOrFail($id);
		if($request->get('flag')=='y'):
			$audit['reply_id'] = Auth::id();
		endif;
		if($request->get('flag')=='fa'):
			$audit['final_action'] = 'Checked and Found Correct';
		endif;
		$audit->update($request->all());
		if($request->get('flag')=='y'):
			return redirect('audit/reply');
		elseif($request->get('flag')=='fa'):
			return redirect('audit/final_action');
		else:
			return redirect('audit');
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
		Audits::destroy($id);
		return redirect('audit');
	}
  public function help()
	{
		$tranmasters = Audits::latest()->get();
        $langs = $this->language();
		return view('acc.audit.help', compact(['tranmasters', 'langs']));
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

	public function reply()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$audits = Audits::where('com_id',$com_id)->where('sendto',Auth::id())->where('reply_id',0)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $audits = $audits->where('user_id',Auth::id());
        }
		return view('acc.audit.replay', compact(['audits', 'langs', 'users']));
	}
	public function final_action()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$audits = Audits::where('com_id',$com_id)->where('sendto',Auth::id())->where('reply_id','>',0)->where('final_action','')->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $audits = $audits->where('user_id',Auth::id());
        }
		return view('acc.audit.final_action', compact(['audits', 'langs', 'users']));
	}
	public function internal_report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }
		$audits = Audits::where('com_id',$com_id)->where('sendto',Auth::id())->where('reply_id','>',0)->where('final_action','')->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $audits = $audits->where('user_id',Auth::id());
        }
		return view('acc.audit.internal_report', compact(['audits', 'langs', 'users']));
	}

}