<?php namespace App\Http\Controllers\Lib\Hrm;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Lib\Hrm\Lineinfos;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class LineinfoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$lineinfos = Lineinfos::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $lineinfos = $lineinfos->where('user_id',Auth::id());
        }
		return view('lib.hrm.line_info.index', compact(['lineinfos', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('lib.hrm.line_info.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $lineinfo = $request->all();
        $lineinfo['user_id'] = Auth::id();
        Lineinfos::create($lineinfo);
		return redirect('lineinfo');
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
		$lineinfo = Lineinfos::findOrFail($id);
		return view('lib.hrm.line_info.edit', compact(['lineinfo', 'langs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$lineinfo = Lineinfos::findOrFail($id);
		$lineinfo->update($request->all());
		return redirect('lineinfo');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Lineinfos::destroy($id);
		return redirect('lineinfo');
	}

	/**
	 * Display a listing of the trashed resource.
	 *
	 * @return Response
	 */
	public function trashed()
	{
        $lineinfos = Lineinfos::onlyTrashed()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $lineinfos = $lineinfos->where('user_id',Auth::id());
        }
		return view('lib.hrm.line_info.trashed', compact(['lineinfos', 'langs']));
	}

	/**
	 * Restore the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function restore($id)
	{
        Lineinfos::onlyTrashed()->where('id', $id)->restore();
		return redirect('lineinfo');
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