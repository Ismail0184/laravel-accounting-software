<?php namespace App\Http\Controllers\Lib\Hrm;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Lib\Hrm\Units;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class UnitController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$units = Units::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $units = $units->where('user_id',Auth::id());
        }
		return view('lib.hrm.unit.index', compact(['units', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('lib.hrm.unit.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $unit = $request->all();
        $unit['user_id'] = Auth::id();
        Units::create($unit);
		return redirect('unit');
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
		$unit = Units::findOrFail($id);
		return view('lib.hrm.unit.edit', compact(['unit', 'langs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$unit = Units::findOrFail($id);
		$unit->update($request->all());
		return redirect('unit');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Units::destroy($id);
		return redirect('unit');
	}

	/**
	 * Display a listing of the trashed resource.
	 *
	 * @return Response
	 */
	public function trashed()
	{
        $units = Units::onlyTrashed()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $units = $units->where('user_id',Auth::id());
        }
		return view('lib.hrm.unit.trashed', compact(['units', 'langs']));
	}

	/**
	 * Restore the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function restore($id)
	{
        Units::onlyTrashed()->where('id', $id)->restore();
		return redirect('unit');
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