<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Pages;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class PageController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $pages = Pages::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $pages = $pages->where('user_id',Auth::id());
        }
        $pages = $pages->get();
		return view('acc.page.index', compact(['langs', 'pages']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = Languages::lists('value', 'code');
		return view('acc.page.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $page = $request->all();
        $page['user_id'] = Auth::id();
        Pages::create($page);
		return redirect('page');
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
		$page = Pages::findOrFail($id);
		return view('acc.page.show', compact(['langs', 'page']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $langs = Languages::lists('value', 'code');
		$page = Pages::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $page->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.page.edit', compact(['langs', 'page']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$page = Pages::findOrFail($id);
		$page->update($request->all());
		return redirect('page');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Pages::destroy($id);
		return redirect('page');
	}

}