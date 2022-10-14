<?php namespace App\Http\Controllers\Lib;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Lib\Languages;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LanguageController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$langs = $this->language();
		$languages = Languages::latest()->get();
		return view('lib.language.index', compact('languages','langs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('lib.language.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
		Languages::create($request->all());
		return redirect('language');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$language = Languages::findOrFail($id);
		return view('lib.language.show', compact('language'));
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
		$language = Languages::findOrFail($id);
		return view('lib.language.edit', compact('language'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		//$this->validate($request, ['name' => 'required']); // Uncomment and modify if needed.
		$language = Languages::findOrFail($id);
		$language->update($request->all());
		return redirect('language');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Languages::destroy($id);
		return redirect('language');
	}
    public function language()
    {        
        $languages = Languages::latest()->get();
        foreach($languages as $lang) {
            $langs[$lang->code] = $lang->value;
        }
        return $langs;
    }

}