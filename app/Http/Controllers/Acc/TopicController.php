<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Topics;
use App\Models\Acc\Pages;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class TopicController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = Languages::lists('value', 'code');
        $topics = Topics::latest();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $topics = $topics->where('user_id',Auth::id());
        }
        $topics = $topics->get();
		return view('acc.topic.index', compact(['langs', 'topics']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$page=Pages::Latest()->get();
		$pages=array(''=>'Select ...');
		foreach($page as $item):
			$pages[$item['id']]=$item['name'];
		endforeach;

        $langs = Languages::lists('value', 'code');
		return view('acc.topic.create', compact('langs','pages'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $topic = $request->all();
        $topic['user_id'] = Auth::id();
        Topics::create($topic);
		return redirect('topic');
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
		$topic = Topics::findOrFail($id);
		return view('acc.topic.show', compact(['langs', 'topic']));
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
		$topic = Topics::findOrFail($id);
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user && $topic->user_id != Auth::id()) {
            abort(403);
        }
		return view('acc.topic.edit', compact(['langs', 'topic']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$topic = Topics::findOrFail($id);
		$topic->update($request->all());
		return redirect('topic');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Topics::destroy($id);
		return redirect('topic');
	}

}