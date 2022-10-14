<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Fletters;
use App\Models\Acc\Companies;
use App\Models\Acc\Signatures;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class FletterController extends Controller {

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
        $fletters = Fletters::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $fletters = $fletters->where('user_id',Auth::id());
        }
        $fletters = $fletters->get();
		return view('acc.fletter.index', compact(['langs', 'fletters','company']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$signature=Signatures::Latest()->get();
		$signatures=array(''=>'Select ...');
		foreach($signature as $item):
			$signatures[$item['id']]=$item['name'];
		endforeach;
        $langs = Languages::lists('value', 'code');
		return view('acc.fletter.create', compact('langs','signatures'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $fletter = $request->all();
        $fletter['user_id'] = Auth::id();
        Fletters::create($fletter);
		return redirect('fletter');
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
		$fletter = Fletters::findOrFail($id);
		return view('acc.fletter.show', compact(['langs', 'fletter']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$signature=Signatures::Latest()->get();
		$signatures=array(''=>'Select ...');
		foreach($signature as $item):
			$signatures[$item['id']]=$item['name'];
		endforeach;

        $langs = Languages::lists('value', 'code');
		$fletter = Fletters::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $fletter->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.fletter.edit', compact(['langs', 'fletter','signatures']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$fletter = Fletters::findOrFail($id);
		$fletter->update($request->all());
		return redirect('fletter');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Fletters::destroy($id);
		return redirect('fletter');
	}

}