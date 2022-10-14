<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Quotations;
use App\Models\Acc\Coverpages;
use App\Models\Acc\Fletters;
use App\Models\Acc\Topics;
use App\Models\Acc\Companies;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class QuotationController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		$company=Companies::where('id',$com_id)->first();	

		$topics= Topics::Latest()->get();
		$langs = Languages::lists('value', 'code');
        $quotations = Quotations::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $quotations = $quotations->where('user_id',Auth::id());
        }
        $quotations = $quotations->get();
		return view('acc.quotation.index', compact(['langs', 'quotations','topics','company']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$coverpage=Coverpages::Latest()->get();
		$coverpages=array(''=>'Select ...');
		foreach($coverpage as $item):
			$coverpages[$item['id']]=$item['name'];
		endforeach;
		$fletter=Fletters::Latest()->get();
		$fletters=array(''=>'Select ...');
		foreach($fletter as $item):
			$fletters[$item['id']]=$item['name'];
		endforeach;
		
        $langs = Languages::lists('value', 'code');
		return view('acc.quotation.create', compact('langs','fletters','coverpages'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $quotation = $request->all();
        $quotation['user_id'] = Auth::id();
        Quotations::create($quotation);
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
		$quotation = Quotations::findOrFail($id);
		return view('acc.quotation.show', compact(['langs', 'quotation']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$coverpage=Coverpages::Latest()->get();
		$coverpages=array(''=>'Select ...');
		foreach($coverpage as $item):
			$coverpages[$item['id']]=$item['name'];
		endforeach;
		$fletter=Fletters::Latest()->get();
		$fletters=array(''=>'Select ...');
		foreach($fletter as $item):
			$fletters[$item['id']]=$item['name'];
		endforeach;
        $langs = Languages::lists('value', 'code');
		$quotation = Quotations::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $quotation->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.quotation.edit', compact(['langs', 'quotation','coverpages','fletters']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$quotation = Quotations::findOrFail($id);
		$quotation->update($request->all());
		return redirect('quotation');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Quotations::destroy($id);
		return redirect('quotation');
	}

}