<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Conditions;
use App\Models\Acc\Topics;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class ConditionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $conditions = Conditions::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $conditions = $conditions->where('user_id',Auth::id());
        }
        $conditions = $conditions->get();
		return view('acc.condition.index', compact(['langs', 'conditions']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$topic=Topics::Latest()->get();
		$topics=array(''=>'Select ...');
		foreach($topic as $item):
			$topics[$item['id']]=$item['name'];
		endforeach;
        $langs = Languages::lists('value', 'code');
		return view('acc.condition.create', compact('langs','topics'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		
		$condition = $request->all();
        $condition['user_id'] = Auth::id();
        Conditions::create($condition);
		return redirect('condition');
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
		$condition = Conditions::findOrFail($id);
		return view('acc.condition.show', compact(['langs', 'condition']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$topic=Topics::Latest()->get();
		$topics=array(''=>'Select ...');
		foreach($topic as $item):
			$topics[$item['id']]=$item['name'];
		endforeach;
        $langs = Languages::lists('value', 'code');
		$condition = Conditions::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $condition->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.condition.edit', compact(['langs', 'condition','topics']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$condition = Conditions::findOrFail($id);
		$condition->update($request->all());
		return redirect('condition');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Conditions::destroy($id);
		return redirect('condition');
	}

}