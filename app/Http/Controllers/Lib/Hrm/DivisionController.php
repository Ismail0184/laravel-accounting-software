<?php namespace App\Http\Controllers\Lib\Hrm;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Lib\Hrm\Divisions;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class DivisionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$divisions = Divisions::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $divisions = $divisions->where('user_id',Auth::id());
        }
		return view('lib.hrm.division.index', compact(['divisions', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('lib.hrm.division.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $division = $request->all();
        $division['user_id'] = Auth::id();
        Divisions::create($division);
		return redirect('division');
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
		$division = Divisions::findOrFail($id);
		return view('lib.hrm.division.edit', compact(['division', 'langs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$division = Divisions::findOrFail($id);
		$division->update($request->all());
		return redirect('division');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Divisions::destroy($id);
		return redirect('division');
	}

	/**
	 * Display a listing of the trashed resource.
	 *
	 * @return Response
	 */
	public function trashed()
	{
        $divisions = Divisions::onlyTrashed()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $divisions = $divisions->where('user_id',Auth::id());
        }
		return view('lib.hrm.division.trashed', compact(['divisions', 'langs']));
	}

	/**
	 * Restore the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function restore($id)
	{
        Divisions::onlyTrashed()->where('id', $id)->restore();
		return redirect('division');
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