<?php namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use DB; 
use Session;
trait AuthenticateAndRegisterUsers {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * The registrar implementation.
	 *
	 * @var Registrar
	 */
	protected $registrar;

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		return view('auth.register');
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$this->auth->login($this->registrar->create($request->all()));

		return redirect($this->redirectPath());
	}

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogin()
	{
		return view('auth.login');
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		$this->company($request->get('email'));
		
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			return redirect()->intended($this->redirectPath());
		}

		return redirect($this->loginPath())
			->withInput($request->only('email', 'remember'))
			->withErrors([
				'email' => $this->getFailedLoginMessage(),
			]);
	}

	/**
	 * Get the failed login message.
	 *
	 * @return string
	 */
	protected function getFailedLoginMessage()
	{
		return 'These credentials do not match our records.';
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogout()
	{
		$this->auth->logout();

		return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
	}

	/**
	 * Get the post register / login redirect path.
	 *
	 * @return string
	 */
	public function redirectPath()
	{
		if (property_exists($this, 'redirectPath'))
		{
			return $this->redirectPath;
		}

		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/dashboard';
	}

	/**
	 * Get the path to the login route.
	 *
	 * @return string
	 */
	public function loginPath()
	{
		return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
	}
	
	public function company($email)
	{	
		// collect user id
		$user=DB::table('users')->where('email',$email)->first();
		$user_id=''; isset($user) && $user->id>0 ? $user_id=$user->id : $user_id='';
		$user_name=''; isset($user) && $user->id>0 ? $user_name=$user->name : $user_name='';
		//collect company id
		$com=DB::table('acc_usercompanies')->where('setting','Defauld')->where('users_id',$user_id)->first();
		$com_id=''; isset($com) && $com->id > 0 ? $com_id=$com->com_id : $com_id='';
		$techeck_id=''; isset($com) && $com->id > 0 ? $techeck_id=$com->techeck_id : $techeck_id=''; //echo  $techeck_id.'osama';
		$pettycash_id=''; isset($com) && $com->id > 0 ? $pettycash_id=$com->pettycash_id : $pettycash_id=''; //echo  $techeck_id.'osama';
		$topsheet=''; isset($com) && $com->id > 0 ? $topsheet=$com->topsheet : $topsheet=''; //echo  $topsheet.'osama';
		//collect outlet
		$olt=DB::table('acc_uoutlets')->where('setting','Defauld')->where('users_id',$user_id)->first();
		$olt_id=''; isset($olt) && $olt->id > 0 ? $olt_id=$olt->com_id : $olt_id='';

		//collect Option
		$option=DB::table('acc_options')->where('com_id',$com_id)->first();
		$inven_auto_update=''; isset($option) && $option->inven_auto_update > 0 ? $inven_auto_update=$option->inven_auto_update : $inven_auto_update=0;

		// set comId in session
		Session::put('com_id', $com_id); //echo $com_id.'ekrama'; exit;
		Session::put('id_com', $com_id); //echo $com_id.'ekrama'; exit;
		Session::put('tmdfrom', date('Y-m-d'));
		Session::put('tmdto', date('Y-m-d'));
		Session::put('user_name', $user_name);
		Session::put('olt_id', $olt_id);
		Session::put('techeck_id', $techeck_id);
		Session::put('pettycash_id', $pettycash_id);
		Session::put('topsheet', $topsheet);
		Session::put('inven_auto_update', $inven_auto_update);

	}


}
