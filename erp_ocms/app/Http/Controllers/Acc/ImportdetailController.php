<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Importdetails;
use App\Models\Acc\Products;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

use Auth;
use DB;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class ImportdetailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$importdetails = Importdetails::latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            $importdetails = $importdetails->where('user_id',Auth::id());
        }
		return view('acc.importdetail.index', compact(['importdetails', 'langs']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $langs = $this->language();
		return view('acc.importdetail.create', compact('langs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

	    $importdetail = $request->all();
        $importdetail['user_id'] = Auth::id();
		$importdetail['com_id'] = $com_id;
        Importdetails::create($importdetail);
		return redirect('importmaster/'.$request->get('im_id'));
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
		$importdetail = Importdetails::findOrFail($id);
		return view('acc.importdetail.show', compact(['importdetail', 'langs']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		$product = Products::where('com_id',$com_id)->latest()->get();
		$products['']="Select ...";
        foreach($product as $data) {
            $products[$data['id']] = $data['name'];
        }
        $langs = $this->language();
		$importdetail = Importdetails::findOrFail($id);
		return view('acc.importdetail.edit', compact(['importdetail', 'langs','products']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$importdetail = Importdetails::findOrFail($id);
		$importdetail->update($request->all());
		return redirect('importmaster/'.Session::get('im_id'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Importdetails::destroy($id);
		$im=DB::table('acc_importdetails')->where('id',$id)->first();
		isset($im) && $im->id>0 ? $im_id=$im->im_id : $im_id='';
		return redirect('importmaster/'.Session::get('im_id'));
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