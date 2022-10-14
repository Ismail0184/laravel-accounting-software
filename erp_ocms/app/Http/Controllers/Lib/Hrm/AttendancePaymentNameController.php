<?php namespace App\Http\Controllers\Lib\Hrm;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Lib\Hrm\AttendancePaymentNames;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class AttendancePaymentNameController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$attendance_payment_names = AttendancePaymentNames::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $attendance_payment_names = $attendance_payment_names->where('user_id',Auth::id());
        }
		return view('lib.hrm.attendance_payment_name.index', compact(['attendance_payment_names', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('lib.hrm.attendance_payment_name.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $attendance_payment_name = $request->all();
        $attendance_payment_name['user_id'] = Auth::id();
        AttendancePaymentNames::create($attendance_payment_name);
		return redirect('attendance-payment-name');
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
		$attendance_payment_name = AttendancePaymentNames::findOrFail($id);
		return view('lib.hrm.attendance_payment_name.edit', compact(['attendance_payment_name', 'langs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$attendance_payment_name = AttendancePaymentNames::findOrFail($id);
		$attendance_payment_name->update($request->all());
		return redirect('attendance-payment-name');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		AttendancePaymentNames::destroy($id);
		return redirect('attendance-payment-name');
	}

	/**
	 * Display a listing of the trashed resource.
	 *
	 * @return Response
	 */
	public function trashed()
	{
        $attendance_payment_names = AttendancePaymentNames::onlyTrashed()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $attendance_payment_names = $attendance_payment_names->where('user_id',Auth::id());
        }
		return view('lib.hrm.attendance_payment_name.trashed', compact(['attendance_payment_names', 'langs']));
	}

	/**
	 * Restore the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function restore($id)
	{
        AttendancePaymentNames::onlyTrashed()->where('id', $id)->restore();
		return redirect('attendance-payment-name');
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