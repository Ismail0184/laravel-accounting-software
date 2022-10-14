<?php 


Route::get('aop/menu/{id}', 'merchandizing\AopController@menu');
Route::get('fabricmaster/find', 'merchandizing\FabricmasterController@find');
Route::get('pomaster/find', 'merchandizing\PomasterController@find');
Route::get('fabricmaster/booking', 'merchandizing\FabricmasterController@booking');


Route::group(['middleware' => ['auth', 'authorize']], function(){
		Route::resource('buyer', 'merchandizing\BuyerController');
		Route::resource('marketingteam', 'merchandizing\MarketingteamController');
		Route::resource('order', 'merchandizing\OrderController');
		Route::resource('lcmode', 'merchandizing\LcmodeController');
		Route::resource('incoterm', 'merchandizing\IncotermController');
		Route::resource('bdtype', 'merchandizing\BdtypeController');
		Route::resource('pomaster', 'merchandizing\PomasterController');
		Route::resource('podetails', 'merchandizing\PodetailsController');
		Route::resource('port', 'merchandizing\PortController');
		Route::resource('aop', 'merchandizing\AopController');
		Route::resource('ccuff', 'merchandizing\CcuffController');
		Route::resource('cdepth', 'merchandizing\CdepthController');
		Route::resource('depthtype', 'merchandizing\DepthtypeController');
		Route::resource('dia', 'merchandizing\DiaController');
		Route::resource('finishing', 'merchandizing\FinishingController');
		Route::resource('ftype', 'merchandizing\FtypeController');
		Route::resource('gsm', 'merchandizing\GsmController');
		Route::resource('gtype', 'merchandizing\GtypeController');
		Route::resource('lycraratio', 'merchandizing\LycraratioController');
		Route::resource('structure', 'merchandizing\StructureController');
		Route::resource('washing', 'merchandizing\WashingController');
		Route::resource('ydstripe', 'merchandizing\YdstripeController');
		Route::resource('pogarment', 'merchandizing\PogarmentController');
		Route::resource('ytype', 'merchandizing\YtypeController');
		Route::resource('ycount', 'merchandizing\YcountController');
		Route::resource('yconsumption', 'merchandizing\YconsumptionController');
		Route::resource('cprocess', 'merchandizing\CprocessController');
		Route::resource('fabricmaster', 'merchandizing\FabricmasterController');
		Route::resource('munit', 'merchandizing\MunitController');
		Route::resource('fabricdetail', 'merchandizing\FabricdetailController');
		Route::resource('diatype', 'merchandizing\DiatypeController');

	});


?>