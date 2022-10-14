<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Warehouses;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class WarehouseController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$warehouses = Warehouses::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $warehouses = $warehouses->where('user_id',Auth::id());
        }
		return view('acc.warehouse.index', compact(['warehouses', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('acc.warehouse.create', compact('langs'));
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

	    $warehouse = $request->all();
        $warehouse['user_id'] = Auth::id();
		$warehouse['com_id'] = $com_id;
        Warehouses::create($warehouse);
		return redirect('warehouse');
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
		$warehouse = Warehouses::findOrFail($id);
		return view('acc.warehouse.show', compact(['warehouse', 'langs']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $langs = $this->language();
		$warehouse = Warehouses::findOrFail($id);
		return view('acc.warehouse.edit', compact(['warehouse', 'langs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$warehouse = Warehouses::findOrFail($id);
		$warehouse->update($request->all());
		return redirect('warehouse');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Warehouses::destroy($id);
		return redirect('warehouse');
	}
public function help()
	{
		$acccoas = Warehouses::latest()->get();
        $langs = $this->language();
		return view('acc.acccoa.help', compact(['acccoas', 'langs']));
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