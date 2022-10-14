<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Coadetails;
use App\Models\Acc\Acccoas;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class CoadetailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$coadetails = Coadetails::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $coadetails = $coadetails->where('user_id',Auth::id());
        }
		return view('acc.coadetail.index', compact(['coadetails', 'langs']));
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

		$coa = Acccoas::where('com_id',$com_id)->where('atype','Account')->latest()->get();
		$coas['']="Select ...";
        foreach($coa as $data) {
            $coas[$data['id']] = $data['name'];
        }
		$coa_groups = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$coa_group['']="Select ...";
        foreach($coa_groups as $data) {
            $coa_group[$data['id']] = $data['name'];
        }
        $langs = $this->language();
		return view('acc.coadetail.create', compact('langs', 'coas','coa_group'));
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

	    $coadetail = $request->all();
        $coadetail['user_id'] = Auth::id();
		$coadetail['com_id'] =$com_id;
        Coadetails::create($coadetail);
		return redirect('coadetail');
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
		$coadetail = Coadetails::findOrFail($id);
		return view('acc.coadetail.show', compact(['coadetail', 'langs']));
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
	
		$coa_groups = Acccoas::where('com_id',$com_id)->where('atype','Group')->latest()->get();
		$coa_group['']="Select ...";
        foreach($coa_groups as $data) {
            $coa_group[$data['id']] = $data['name'];
        }
		$coas=Acccoas::where('com_id',$com_id)->where('atype','Account')->lists('name','id');
        $langs = $this->language();
		$coadetail = Coadetails::findOrFail($id);
		return view('acc.coadetail.edit', compact(['coadetail', 'langs','coas','coa_group']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$coadetail = Coadetails::findOrFail($id);
		$coadetail->update($request->all());
		return redirect('coadetail');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Coadetails::destroy($id);
		return redirect('coadetail');
	}
    
	  public function help()
	{
		$acccoas = Coadetails::latest()->get();
        $langs = $this->language();
		return view('acc.coadetail.help', compact(['Coadetails', 'langs']));
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