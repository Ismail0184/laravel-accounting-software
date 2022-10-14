<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Models\Lib\Languages;

class ProfileController extends Controller {

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$profile = User::findOrFail($id);
        if($profile->id != Auth::id()) {
            abort(403);
        }
        $langs = $this->language();
		return view('users.profile.show', compact(['profile', 'langs']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$profile = User::findOrFail($id);
        if($profile->id != Auth::id()) {
            abort(403);
        }
        $langs = $this->language();
		return view('users.profile.edit', compact(['profile', 'langs']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$user = User::find($id);

        if($user->id != Auth::id()) {
            abort(403);
        }
        
		$user->name = $request->get('name');
		if($request->get('password'))
		{
			$user->password = $request->get('password');
		}
		$user->save();
        
		return redirect('/profile/'.$user->id);
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
