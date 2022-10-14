<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Termconditions;
use App\Models\Acc\Companies;
use App\Models\Acc\Quotations;
use App\Models\Acc\Topics;
use App\Models\Acc\Conditions;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class TermconditionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$company=Companies::where('id',$com_id)->first();	

		$langs = Languages::lists('value', 'code');
        $termconditions = Termconditions::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $termconditions = $termconditions->where('user_id',Auth::id());
        }
        $termconditions = $termconditions->get();
		return view('acc.termcondition.index', compact(['langs', 'termconditions','company']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$condition=Conditions::Latest()->get();
		$conditions=array(''=>'Select ...');
		foreach($condition as $item):
			$conditions[$item['id']]=$item['name'];
		endforeach;

		$topic=Topics::Latest()->get();
		$topics=array(''=>'Select ...');
		foreach($topic as $item):
			$topics[$item['id']]=$item['name'];
		endforeach;

		$quotation=Quotations::Latest()->get();
		$quotations=array(''=>'Select ...');
		foreach($quotation as $item):
			$quotations[$item['id']]=$item['name'];
		endforeach;

        $langs = Languages::lists('value', 'code');
		return view('acc.termcondition.create', compact('langs','conditions','topics','quotations'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    if($request->get('flag')=='modal'):
			$condition=$request->get('condition');
			//DB::table(count($condition))->get();
			foreach($condition as $key => $val):
				$data=array(
					'quotation_id'=>$request->get('quotation_id'),
					'condition_id'=>$val,
					'user_id'=>Auth::id()
				);
				//DB::table($val)->get();
			Termconditions::create($data);
			endforeach;
		else:
			$termcondition = $request->all();
			$termcondition['user_id'] = Auth::id();
			Termconditions::create($termcondition);
		endif;
		return redirect('quotation');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $langs = Languages::lists('value', 'code');
		$termcondition = Termconditions::findOrFail($id);
		return view('acc.termcondition.show', compact(['langs', 'termcondition']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $langs = Languages::lists('value', 'code');
		$termcondition = Termconditions::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $termcondition->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.termcondition.edit', compact(['langs', 'termcondition']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$termcondition = Termconditions::findOrFail($id);
		$termcondition->update($request->all());
		return redirect('termcondition');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Termconditions::destroy($id);
		return redirect('termcondition');
	}

}