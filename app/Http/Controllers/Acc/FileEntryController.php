<?php namespace App\Http\Controllers\Acc;

use App\Http\Controllers\Controller;
use App\Models\Acc\Fileentry;
use App\Models\Acc\Clients;
use Request;
use DB;
use Session;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class FileEntryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($vnumber)
	{
		Session::has('m_name') ? $m_name=Session::get('m_name') : $m_name='' ;
		
		$entries = Fileentry::where('vnumber',$vnumber)->where('module',$m_name)->get();
		$vn=$vnumber;
		return view('acc.fileentries.index', compact('entries','vnumber','vn'));
	}

	public function add() {

		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
		Session::has('m_name') ? $m_name=Session::get('m_name') : $m_name='' ; 

		$file = Request::file('filefield');
		$extension = $file->getClientOriginalExtension();
		Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
		$entry = new Fileentry();
		$entry->mime = $file->getClientMimeType();
		$entry->original_filename = $file->getClientOriginalName();
		$entry->filename = $file->getFilename().'.'.$extension;
		$entry->vnumber = Request::input('vnumber');
		$entry->module = $m_name;
		$entry->com_id =  $com_id;

		$entry->save();
		$vnumber=Request::input('vnumber');
		return redirect('fileentry/'.$vnumber);
		
	}

	public function get($filename){


		$entry = Fileentry::where('filename', '=', $filename)->firstOrFail();
		$file = Storage::disk('local')->get($entry->filename);

		return (new Response($file, 200))
              ->header('Content-Type', $entry->mime);

	}
	
	public function delete($id){
		
		$file=DB::table('acc_fileentries')->where('id',$id)->first();
		isset($file) && $file->id > 0 ? $vnumber=$file->vnumber : $vnumber='';
		$file_name=''; isset($file) && $file->id > 0 ? $file_name=$file->filename : $file_name='';
		DB::delete('delete from acc_fileentries where id='.$id);

			Storage::Delete($file_name);
		
		return redirect('fileentry/'.$vnumber);
		
	}

}
