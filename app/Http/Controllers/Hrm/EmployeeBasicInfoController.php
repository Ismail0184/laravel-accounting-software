<?php namespace App\Http\Controllers\Hrm;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Hrm\EmployeeBasicInfos;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;
use App\Models\Lib\Hrm\Religions;
use App\Models\Lib\Hrm\Districts;
use App\Models\Lib\Hrm\Divisions;

class EmployeeBasicInfoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$employee_basic_infos = EmployeeBasicInfos::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $employee_basic_infos = $employee_basic_infos->where('user_id',Auth::id());
        }
		return view('hrm.employee_basic_info.index', compact(['employee_basic_infos', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
        
        $religions = Religions::latest()->get();
        $religion[''] = 'Select...';
        foreach($religions as $religion_data){
            $religion[$religion_data['id']] = $religion_data['name'];
        }
        
        $districts = Districts::latest()->get();
        $district[''] = 'Select...';
        foreach($districts as $district_data){
            $district[$district_data['id']] = $district_data['name'];
        }
        
        $divisions = Divisions::latest()->get();
        $division[''] = 'Select...';
        foreach($divisions as $division_data){
            $division[$division_data['id']] = $division_data['name'];
        }
                
		return view('hrm.employee_basic_info.create', compact(['langs', 'religion', 'district', 'division']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $employee_basic_info = $request->all();
        $employee_basic_info['user_id'] = Auth::id();
        EmployeeBasicInfos::create($employee_basic_info);
		return redirect('employee-basic-info');
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
		$employee_basic_info = EmployeeBasicInfos::findOrFail($id);
		return view('hrm.employee_basic_info.show', compact(['employee-basic-info', 'langs']));
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
		$employee_basic_info = EmployeeBasicInfos::findOrFail($id);
		return view('hrm.employee_basic_info.edit', compact(['employee-basic-info', 'langs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$employee_basic_info = EmployeeBasicInfos::findOrFail($id);
		$employee_basic_info->update($request->all());
		return redirect('employee-basic-info');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		EmployeeBasicInfos::destroy($id);
		return redirect('employee-basic-info');
	}

	/**
	 * Display a listing of the trashed resource.
	 *
	 * @return Response
	 */
	public function trashed()
	{
        $employee_basic_infos = EmployeeBasicInfos::onlyTrashed()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $employee_basic_infos = $employee_basic_infos->where('user_id',Auth::id());
        }
		return view('hrm.employee_basic_info.trashed', compact(['employee_basic_infos', 'langs']));
	}

	/**
	 * Restore the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function restore($id)
	{
        EmployeeBasicInfos::onlyTrashed()->where('id', $id)->restore();
		return redirect('employee-basic-info');
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