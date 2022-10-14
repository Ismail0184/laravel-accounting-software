<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Session;
use Auth;

class ConfigServiceProvider extends ServiceProvider {

	/**
	 * Overwrite any vendor / package configuration.
	 *
	 * This service provider is intended to provide a convenient location for you
	 * to overwrite any "vendor" or package configuration that you may want to
	 * modify before the application handles the incoming request / command.
	 *
	 * @return void
	 */
	public function register()
	{
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 
		isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 

		$scheck_id='';$currency_id=''; //echo Auth::id();
		$option=DB::table('acc_options')->where('com_id',$com_id)->first();
		if(isset($option) && $option->id>0 ):
			$currency_id=$option->currency_id;
			$scheck_id=$option->scheck_id;
		endif;
		config([
			//
			'currency_id'=>$currency_id,
			'com_id'=>$com_id,
			'com_name'=>$com_name,
			'scheck_id'=>$scheck_id,
		]);
	}

}
