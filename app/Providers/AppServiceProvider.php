<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use DB;
use Session; 
use Auth;
use View;
use App\Models\Lib\Languages;



class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
/*		$com=DB::table('acc_usercompanies')
		->where('setting','Defauld')
		->where('users_id',Auth::id())
		->first(); //echo $com->id;
		//Config::set(['com' => ['id' => $com->id ]]);
		//Session::put('com_id', Auth::id());
		$com_id='';			
		Config::set(['com' => ['id' => Session::get('com_id') ]]); 
*/

        View::composer('*', function ($view) { 
            if(Auth::check())
            {                
                $user_companies = Auth::user()->companies->lists('name');
                if(Session::has('current_company') && !in_array(Session::get('current_company'), $user_companies)) {
                    Session::put('current_company', Auth::user()->company->name);
                    $view->with('current_company', Session::get('current_company'));
                    Session::put('current_company_id', Auth::user()->company->id);
                    $view->with('current_company_id', Session::get('current_company_id'));
                    Session::put('company_abbreviation', Auth::user()->company->abbreviation);
                    $view->with('company_abbreviation', Session::get('company_abbreviation'));
                } elseif(Session::has('current_company') && in_array(Session::get('current_company'), $user_companies)) {
                    $view->with('current_company', Session::get('current_company'));
                    $view->with('current_company_id', Session::get('current_company_id'));
                    $view->with('company_abbreviation', Session::get('company_abbreviation'));
                } else {
                    Session::put('current_company', Auth::user()->company->name);
                    $view->with('current_company', Session::get('current_company'));
                    Session::put('current_company_id', Auth::user()->company->id);
                    $view->with('current_company_id', Session::get('current_company_id'));
                    Session::put('company_abbreviation', Auth::user()->company->abbreviation);
                    $view->with('company_abbreviation', Session::get('company_abbreviation'));
                }
            }
            $view->with('com_id', Session::get('com_id'));
            $view->with('inven_auto_update', Session::get('inven_auto_update'));
            
/*            $tasks = TodoLists::where('assign_user_id',Auth::id())->where('completed','0')->take(5)->get();            
            $view->with('tasks_not', $tasks);
            
            $remaining_tasks = TodoLists::where('assign_user_id',Auth::id())->where('completed','0')->count();
            $view->with('remaining_tasks', $remaining_tasks);
*/        });

	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
