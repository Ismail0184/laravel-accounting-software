<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\Products;
use App\Models\Acc\AccUnits;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use Session;
use App\User;

use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class ProductController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		$user = User::latest()->get();
		$users['']="Select ...";
        foreach($user as $user_data) {
            $users[$user_data['id']] = $user_data['name'];
        }

		$products = Products::where('com_id',$com_id)->where('group_id',0)->orderby('sl')->latest()->get();
        $langs = $this->language();
        $user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
        if($user_only && !$admin_user) {
            //$products = $products->where('user_id',Auth::id());
        }
		return view('acc.product.index', compact(['products', 'langs','users']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$unit=AccUnits::latest()->get();
		$units['']="Select ...";
		foreach($unit as $data){
			$units[$data['id']]=$data['name'];
			}

		$topGroups=Products::where('com_id',$com_id)->where('ptype','Top Group')->latest()->get();
		$topGroup['']="Select ...";
		foreach($topGroups as $topGroup_data){
			$topGroup[$topGroup_data['id']]=$topGroup_data['name'];
			}

		$groups=Products::where('com_id',$com_id)->latest()->get();
		$group['']="Select ...";
		foreach($groups as $group_data){
			$group[$group_data['id']]=$group_data['name'];
			}
        $langs = $this->language();
		return view('acc.product.create', compact('langs','group','topGroup','units'));
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

	    $product = $request->all();
        $product['user_id'] = Auth::id();
		$product['com_id'] = $com_id;
        Products::create($product);
		return redirect('product');
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
		$product = Products::findOrFail($id);
		return view('acc.product.show', compact(['product', 'langs']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$unit=AccUnits::latest()->get();
		$units['']="Select ...";
		foreach($unit as $data){
			$units[$data['id']]=$data['name'];
			}

		$topGroups=Products::where('com_id',$com_id)->where('ptype','Top Group')->latest()->get();
		$topGroup['']="Select ...";
		foreach($topGroups as $topGroup_data){
			$topGroup[$topGroup_data['id']]=$topGroup_data['name'];
			}

		$groups=Products::where('com_id',$com_id)->where('ptype','<>','Product')->get();
		$group['']="Select ...";
		foreach($groups as $group_data){
			$group[$group_data['id']]=$group_data['name'];
			}
        $langs = $this->language();
		$product = Products::findOrFail($id);
		return view('acc.product.edit', compact(['product', 'langs','group','topGroup','units']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$product = Products::findOrFail($id);
		$product->update($request->all());
		return redirect('product');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Products::destroy($id);
		return redirect('product');
	}
  
  public function help()
	{
		$products = Products::latest()->get();
        $langs = $this->language();
		return view('acc.product.help', compact(['products', 'langs']));
	}    
    
		/**
	 * to get report.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function report()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$product = Products::where('com_id',$com_id)->where('topGroup_id','0')->latest()->get();
        $langs = $this->language();
		return view('acc.product.report', compact(['product', 'langs']));
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
	public function report_print(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$product = Products::where('com_id',$com_id)->where('topGroup_id','0')->latest()->get();
        $langs = $this->language();
		
        $pdf = \PDF::loadView('acc.product.print', compact(['product', 'langs',]))->setOption('minimum-font-size', 16);
        return $pdf->stream('Product.pdf');
    }
    
    public function report_pdf(){  
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$product = Products::where('com_id',$com_id)->where('topGroup_id','0')->latest()->get();
        $langs = $this->language();
        $pdf = \PDF::loadView('acc.product.print', compact(['product', 'langs', 'day']))->setOption('minimum-font-size', 16);
        return $pdf->download('Product.pdf');
    }

	public function report_word()
	{
        ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
	   	Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$product = Products::where('com_id',$com_id)->latest()->get();
        $langs = $this->language();
		
		header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Product.doc");

		return view('acc.product.word', compact(['product', 'langs']));
	}
    public function report_excel(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
				\Excel::create('Product', function($excel) {

            	$excel->sheet('Product', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$product = Products::where('com_id',$com_id)->where('topGroup_id','0')->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.product.excel', ['product' => $product->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('xlsx');
    }
    public function report_csv(){
				ini_set('max_execution_time', 0);  set_time_limit(0); ignore_user_abort(true);
			   \Excel::create('Product', function($excel) {

            	$excel->sheet('Product', function($sheet) {
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
				$product = Products::where('com_id',$com_id)->where('topGroup_id','0')->latest()->get();
		        $langs = $this->language();
                $sheet->loadView('acc.product.excel', ['product' => $product->toArray(), 'langs' => $langs]);
                $sheet->protect('ocmsacc');
            });
        
        })->export('csv');
    }

}