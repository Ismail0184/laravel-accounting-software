<?php namespace App\Http\Controllers\Lib\Hrm;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Lib\Hrm\StaffCategories;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class StaffCategoryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$staff_categories = StaffCategories::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $staff_categories = $staff_categories->where('user_id',Auth::id());
        }
		return view('lib.hrm.staff_category.index', compact(['staff_categories', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('lib.hrm.staff_category.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $staff_category = $request->all();
        $staff_category['user_id'] = Auth::id();
        StaffCategories::create($staff_category);
		return redirect('staff-category');
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
		$staff_category = StaffCategories::findOrFail($id);
		return view('lib.hrm.staff_category.edit', compact(['staff_category', 'langs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$staff_category = StaffCategories::findOrFail($id);
		$staff_category->update($request->all());
		return redirect('staff-category');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		StaffCategories::destroy($id);
		return redirect('staff-category');
	}

	/**
	 * Display a listing of the trashed resource.
	 *
	 * @return Response
	 */
	public function trashed()
	{
        $staff_categories = StaffCategories::onlyTrashed()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $staff_categories = $staff_categories->where('user_id',Auth::id());
        }
		return view('lib.hrm.staff_category.trashed', compact(['staff_categories', 'langs']));
	}

	/**
	 * Restore the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function restore($id)
	{
        StaffCategories::onlyTrashed()->where('id', $id)->restore();
		return redirect('staff-category');
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