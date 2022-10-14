<?php namespace App\Http\Controllers\Acc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Acc\B2bs;
use App\Models\Acc\Clients;
use App\Models\Acc\Lcinfos;
use App\Models\Acc\Countries;
use App\Models\Acc\Currencies;
use App\Models\Acc\AccUnits;
use App\Models\Acc\Acccoas;
use App\User;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use DB;
use Session;
use Laracasts\Flash\Flash;
use App\Models\Lib\Languages;

class BackupController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function backup()
	{
		Session::flash('success', 'Database Backup taken Successfully ');
		$langs = Languages::lists('value', 'code');
		return view('acc.backup.index', compact(['langs', 'b2bs']));
	}

	
}