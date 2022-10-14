<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Models\Acc\Options;

Route::get('/', [
	'as' => 'dashboard',
	'uses' => 'DashboardController@index',
	'middleware' => 'auth'
]);

Route::get('/dashboard', [
	'as' => 'dashboard',
	'uses' => 'DashboardController@index',
	'middleware' => 'auth'
]);
Route::get('dashboard/coming','DashboardController@coming');
Route::get('dashboard/ajaxsample','DashboardController@ajaxsample');
Route::get('dashboard/topsheet','DashboardController@topsheet');
Route::get('dashboard/display','DashboardController@display');

Route::get('dashboard/coming/get','DashboardController@get');

/*Route::get('sendemail', function () {

    $data = array(
        'name' => "Learning Laravel",
    );

    Mail::send('emails.welcome', $data, function ($message) {

        $message->from('hasanhabib2009@gmail.com', 'Learning Laravel');

        $message->to('hasan@ocmsbd.com')->subject('Learning Laravel test email');

    });

    return "Your email has been sent successfully";

});*/
// file uploader
	Route::get('fileentry/{vnumber}', 'Acc\FileEntryController@index');
	Route::get('fileentry/get/{filename}', [
			'as' => 'getentry', 'uses' => 'Acc\FileEntryController@get']);
	Route::post('fileentry/add', [ 
		    'as' => 'addentry', 'uses' => 'Acc\FileEntryController@add']);
	Route::get('fileentry/delete/{id}', 'Acc\FileEntryController@delete');
	
// close uploader


// for help files of Accounts
Route::get('buyerinfo/buyerhelp','Acc\BuyerinfoController@help');
Route::get('acccoa/acchelp','Acc\AcccoaController@help');
Route::get('lcinfo/lchelp','Acc\LcinfoController@help');
Route::get('coadetail/coadetailhelp','Acc\LcinfoController@help');
Route::get('client/clienthelp','Acc\ClientController@help');
Route::get('orderinfo/orderinfohelp','Acc\OrderinfoController@help');
Route::get('style/stylehelp','Acc\StyleController@help');
Route::get('supplier/supplierhelp','Acc\SupplierController@help');
Route::get('product/producthelp','Acc\ProductController@help');
Route::get('budget/budgethelp','Acc\budgetController@help');
Route::get('lcimport/lcimporthelp','Acc\LcimportController@help');
Route::get('importmaster/importmasterhelp','Acc\ImportmasterController@help');
Route::get('purchasemaster/purchasemasterhelp','Acc\PurchasemasterController@help');
Route::get('outlet/outlethelp','Acc\OutletController@help');
Route::get('prequisition/prequisitionhelp','Acc\PrequisitionController@help');
Route::get('frequisition/frequisitionhelp','Acc\FrequisitionController@help');
Route::get('tranmaster/tranmasterhelp','Acc\TranmasterController@help');
Route::get('tranmaster/tbalance','Acc\TranmasterController@tbalance');
Route::get('company/companyhelp','Acc\CompanyController@help');
Route::get('option/optionhelp','Acc\OptionController@help');
Route::get('setting/settinghelp','Acc\SettingController@help');
Route::get('warehouse/warehousehelp','Acc\WarehouseController@help');
Route::get('audit/audithelp','Acc\AuditController@help');
Route::get('invenmaster/invenhelp','Acc\InvenmasterController@help');
Route::get('acc-project/projecthelp','Acc\ProjectController@help');
Route::get('acc-project/costsheet','Acc\ProjectController@costsheet');
Route::get('acc-project/report','Acc\ProjectController@report');
Route::get('acc-project/projectadvance','Acc\ProjectController@projectadvance');
Route::get('pplanning/pplanninghelp','Acc\PplanningController@help');
Route::get('pbudget/pbudgethelp','Acc\PbudgetController@help');
Route::get('buyerinfo/report','Acc\BuyerinfoController@report');
Route::get('orderinfo/report','Acc\OrderinfoController@report');
Route::get('lcinfo/report','Acc\LcinfoController@report');
Route::get('supplier/report','Acc\SupplierController@report');
Route::get('lcimport/report','Acc\LCimportController@report');
Route::get('product/report','Acc\ProductController@report');
Route::get('importmaster/report','Acc\ImportmasterController@report');
Route::get('client/report','Acc\ClientController@report');
Route::get('purchasemaster/report','Acc\PurchasemasterController@report');
Route::get('salemaster/report','Acc\SalemasterController@report');
Route::get('outlet/report','Acc\OutletController@report');
Route::get('budget/report','Acc\BudgetController@report');
Route::get('prequisition/report','Acc\PrequisitionController@report');
Route::get('frequisition/report','Acc\FrequisitionController@report');
Route::get('acccoa/report','Acc\AcccoaController@report');
Route::get('tranmaster/ledger','Acc\TranmasterController@ledger');
Route::get('tranmaster/trialbalance','Acc\TranmasterController@trialbalance');
Route::get('tranmaster/balancesheet','Acc\TranmasterController@balancesheet');
Route::get('tranmaster/profitloss','Acc\TranmasterController@profitloss');
Route::get('tranmaster/manufacturing','Acc\TranmasterController@manufacturing');
Route::get('tranmaster/pldistribution','Acc\TranmasterController@pldistribution');
Route::get('tranmaster/receiptpayment','Acc\TranmasterController@receiptpayment');
Route::get('tranmaster/voucher/{id}','Acc\TranmasterController@voucher');
Route::get('tranmaster/cheqregister','Acc\TranmasterController@cheqregister');
Route::get('lcinfo/costsheet','Acc\LcinfoController@costsheet');
Route::get('orderinfo/costsheet','Acc\OrderinfoController@costsheet');
Route::get('tranmaster/department','Acc\TranmasterController@department');
Route::get('tranmaster/subhead','Acc\TranmasterController@subhead');
Route::get('importmaster/costsheet','Acc\ImportmasterController@costsheet');
Route::get('invenmaster/report','Acc\InvenmasterController@report');
Route::get('invenmaster/rcvdissue','Acc\InvenmasterController@rcvdissue');
Route::get('salemaster/invoice','Acc\SalemasterController@invoice');
Route::get('salemaster/challan','Acc\SalemasterController@challan');
Route::get('invenmaster/invoice','Acc\InvenmasterController@invoice');
Route::get('invenmaster/invoice_print','Acc\InvenmasterController@invoice_print');
Route::get('invenmaster/challan','Acc\InvenmasterController@challan');
Route::get('invenmaster/challan_print','Acc\InvenmasterController@challan_print');
Route::get('invenmaster/sbalance','Acc\InvenmasterController@sbalance');
Route::get('salemaster/teamsale','Acc\SalemasterController@teamsale');
Route::get('salemaster/stock','Acc\SalemasterController@stock');
Route::get('invenmaster/stock','Acc\InvenmasterController@stock');
Route::get('invenmaster/stock_value','Acc\InvenmasterController@stock_value');
Route::get('style/report','Acc\StyleController@report');
Route::get('importmaster/imdetails','Acc\ImportmasterController@imdetails');
Route::get('purchasemaster/pmdetails','Acc\PurchasemasterController@pmdetails');
Route::get('mteam/report','Acc\MteamController@report');
Route::get('pplanning/report','Acc\PplanningController@report');
Route::get('pbudget/report','Acc\PbudgetController@report');
Route::get('tranmaster/trading','Acc\TranmasterController@trading');
Route::get('tranmaster/clear_data','Acc\TranmasterController@clear_data');
Route::get('b2b/report','Acc\B2bController@report');
Route::get('lctransfer/report','Acc\LctransferController@report');
Route::get('lcinfo/ledger','Acc\LcinfoController@ledger');
Route::get('prequisition/check','Acc\PrequisitionController@check');
Route::get('importmaster/ledger','Acc\ImportmasterController@ledger');
Route::get('acc-project/ledger','Acc\ProjectController@ledger');
Route::get('tranmaster/sister','Acc\TranmasterController@sister');
Route::get('reconciliation/report','Acc\ReconciliationController@report');
Route::get('tranmaster/depreciation','Acc\TranmasterController@depreciation');
Route::get('budget/compare','Acc\BudgetController@compare');
Route::get('tranmaster/opening','Acc\TranmasterController@opening');
Route::get('audit/reply','Acc\AuditController@reply');
Route::get('audit/final_action','Acc\AuditController@final_action');
Route::get('audit/internal_report','Acc\AuditController@internal_report');
Route::get('option/inventory/{id}','Acc\OptionController@inventory');
Route::get('option/export/{id}','Acc\OptionController@export');
Route::get('option/transaction/{id}','Acc\OptionController@transaction');
Route::get('option/audit/{id}','Acc\OptionController@audit');
Route::get('option/sale/{id}','Acc\OptionController@sale');
Route::get('invenmaster/ledger','Acc\InvenmasterController@ledger');
Route::get('salemaster/check','Acc\SalemasterController@check');
Route::get('salemaster/mteam','Acc\SalemasterController@mteam');
Route::get('salemaster/client','Acc\SalemasterController@client');
Route::get('salemaster/product','Acc\SalemasterController@product');
Route::get('option/purchase/{id}','Acc\OptionController@purchase');
Route::get('purchasemaster/check','Acc\PurchasemasterController@check');
Route::get('purchasemaster/product','Acc\PurchasemasterController@product');
Route::get('purchasemaster/client','Acc\PurchasemasterController@client');
Route::get('salemaster/outlet','Acc\SalemasterController@outlet');
Route::get('option/import/{id}','Acc\OptionController@import');
Route::get('importmaster/product','Acc\ImportmasterController@product');
Route::get('importmaster/supplier','Acc\ImportmasterController@supplier');
Route::get('trandetail/reminder','Acc\TrandetailController@reminder');
Route::get('empolyee/salary','Acc\EmpolyeeController@salary');
Route::get('salary/create_salary','Acc\SalaryController@create_salary');
Route::get('salary/delete_salary','Acc\SalaryController@delete_salary');
Route::get('salary/save_salary','Acc\SalaryController@save_salary');
Route::get('salemaster/collection','Acc\SalemasterController@collection');
Route::get('purchasemaster/payment','Acc\PurchasemasterController@payment');
Route::get('invenmaster/checkby','Acc\InvenmasterController@checkby');
Route::post('invenmaster/checked/{id}', 'Acc\InvenmasterController@checked');
Route::get('empolyee/payslip/{id}','Acc\EmpolyeeController@payslip');
Route::get('empolyee/payslip_print/{id}','Acc\EmpolyeeController@payslip_print');
Route::get('trandetail/cashflowd','Acc\TrandetailController@cashflowd');
Route::get('trandetail/cashflowid','Acc\TrandetailController@cashflowid');
Route::get('trandetail/ioslip','Acc\TrandetailController@ioslip');
Route::get('trandetail/afexpense','Acc\TrandetailController@afexpense');
Route::get('invenmaster/client','Acc\InvenmasterController@client');
Route::get('invenmaster/client_ref','Acc\InvenmasterController@client_ref');
Route::get('backup','Acc\BackupController@backup');

// buyer report
Route::get('buyerinfo/print','Acc\BuyerinfoController@report_print');
Route::get('buyerinfo/word','Acc\BuyerinfoController@report_word');
Route::get('buyerinfo/excel','Acc\BuyerinfoController@report_excel');
Route::get('buyerinfo/pdf','Acc\BuyerinfoController@report_pdf');
Route::get('buyerinfo/csv','Acc\BuyerinfoController@report_csv');
// lcinfo report
Route::get('lcinfo/print','Acc\LcinfoController@report_print');
Route::get('lcinfo/word','Acc\LcinfoController@report_word');
Route::get('lcinfo/excel','Acc\LcinfoController@report_excel');
Route::get('lcinfo/pdf','Acc\LcinfoController@report_pdf');
Route::get('lcinfo/csv','Acc\LcinfoController@report_csv');
// order report
Route::get('orderinfo/print','Acc\OrderinfoController@report_print');
Route::get('orderinfo/word','Acc\OrderinfoController@report_word');
Route::get('orderinfo/excel','Acc\OrderinfoController@report_excel');
Route::get('orderinfo/pdf','Acc\OrderinfoController@report_pdf');
Route::get('orderinfo/csv','Acc\OrderinfoController@report_csv');
// style report
Route::get('style/print','Acc\StyleController@report_print');
Route::get('style/word','Acc\StyleController@report_word');
Route::get('style/excel','Acc\StyleController@report_excel');
Route::get('style/pdf','Acc\StyleController@report_pdf');
Route::get('style/csv','Acc\StyleController@report_csv');
// supplier report
Route::get('supplier/print','Acc\SupplierController@report_print');
Route::get('supplier/word','Acc\SupplierController@report_word');
Route::get('supplier/excel','Acc\SupplierController@report_excel');
Route::get('supplier/pdf','Acc\SupplierController@report_pdf');
Route::get('supplier/csv','Acc\SupplierController@report_csv');
// LC Import report
Route::get('lcimport/print','Acc\LcimportController@report_print');
Route::get('lcimport/word','Acc\LcimportController@report_word');
Route::get('lcimport/excel','Acc\LcimportController@report_excel');
Route::get('lcimport/pdf','Acc\LcimportController@report_pdf');
Route::get('lcimport/csv','Acc\LcimportController@report_csv');
// Product report
Route::get('product/print','Acc\ProductController@report_print');
Route::get('product/word','Acc\ProductController@report_word');
Route::get('product/excel','Acc\ProductController@report_excel');
Route::get('product/pdf','Acc\ProductController@report_pdf');
Route::get('product/csv','Acc\ProductController@report_csv');
// importmaster details
Route::get('importmaster/print','Acc\ImportmasterController@report_print');
Route::get('importmaster/word','Acc\ImportmasterController@report_word');
Route::get('importmaster/excel','Acc\ImportmasterController@report_excel');
Route::get('importmaster/pdf','Acc\ImportmasterController@report_pdf');
Route::get('importmaster/csv','Acc\ImportmasterController@report_csv');
// Client details
Route::get('client/print','Acc\ClientController@report_print');
Route::get('client/word','Acc\ClientController@report_word');
Route::get('client/excel','Acc\ClientController@report_excel');
Route::get('client/pdf','Acc\ClientController@report_pdf');
Route::get('client/csv','Acc\ClientController@report_csv');
// purchase details
Route::get('purchasemaster/print','Acc\PurchasemasterController@report_print');
Route::get('purchasemaster/word','Acc\PurchasemasterController@report_word');
Route::get('purchasemaster/excel','Acc\PurchasemasterController@report_excel');
Route::get('purchasemaster/pdf','Acc\PurchasemasterController@report_pdf');
Route::get('purchasemaster/csv','Acc\PurchasemasterController@report_csv');
// outlet details
Route::get('outlet/print','Acc\OutletController@report_print');
Route::get('outlet/word','Acc\OutletController@report_word');
Route::get('outlet/excel','Acc\OutletController@report_excel');
Route::get('outlet/pdf','Acc\OutletController@report_pdf');
Route::get('outlet/csv','Acc\OutletController@report_csv');
// outlet details
Route::get('mteam/print','Acc\MteamController@report_print');
Route::get('mteam/word','Acc\MteamController@report_word');
Route::get('mteam/excel','Acc\MteamController@report_excel');
Route::get('mteam/pdf','Acc\MteamController@report_pdf');
Route::get('mteam/csv','Acc\MteamController@report_csv');
// Sale invoice details
Route::get('salemaster/invoice_print','Acc\SalemasterController@invoice_print');
Route::get('salemaster/invoice_word','Acc\SalemasterController@invoice_word');
Route::get('salemaster/invoice_excel','Acc\SalemasterController@invoice_excel');
Route::get('salemaster/invoice_pdf','Acc\SalemasterController@invoice_pdf');
Route::get('salemaster/invoice_csv','Acc\SalemasterController@invoice_csv');

Route::get('salemaster/challan_print','Acc\SalemasterController@challan_print');
Route::get('salemaster/challan_word','Acc\SalemasterController@challan_word');
Route::get('salemaster/challan_excel','Acc\SalemasterController@challan_excel');
Route::get('salemaster/challan_pdf','Acc\SalemasterController@challan_pdf');
Route::get('salemaster/challan_csv','Acc\SalemasterController@challan_csv');

Route::get('salemaster/stock_print','Acc\SalemasterController@stock_print');
Route::get('salemaster/stock_word','Acc\SalemasterController@stock_word');
Route::get('salemaster/stock_excel','Acc\SalemasterController@stock_excel');
Route::get('salemaster/stock_pdf','Acc\SalemasterController@stock_pdf');
Route::get('salemaster/stock_csv','Acc\SalemasterController@stock_csv');
// invenmaster stock
Route::get('invenmaster/stock_print','Acc\InvenmasterController@stock_print');
Route::get('invenmaster/stock_word','Acc\InvenmasterController@stock_word');
Route::get('invenmaster/stock_excel','Acc\InvenmasterController@stock_excel');
Route::get('invenmaster/stock_pdf','Acc\InvenmasterController@stock_pdf');
Route::get('invenmaster/stock_csv','Acc\InvenmasterController@stock_csv');
// invenmaster ledger
Route::get('invenmaster/ledger_print','Acc\InvenmasterController@ledger_print');
Route::get('invenmaster/ledger_word','Acc\InvenmasterController@ledger_word');
Route::get('invenmaster/ledger_excel','Acc\InvenmasterController@ledger_excel');
Route::get('invenmaster/ledger_pdf','Acc\InvenmasterController@ledger_pdf');
Route::get('invenmaster/ledger_csv','Acc\InvenmasterController@ledger_csv');

Route::get('invenmaster/client_print','Acc\InvenmasterController@client_print');
Route::get('invenmaster/report_print','Acc\InvenmasterController@report_print');
Route::get('invenmaster/sbalance_print','Acc\InvenmasterController@sbalance_print');

// Budget Print
Route::get('budget/budget_print','Acc\BudgetController@budget_print');
Route::get('budget/budget_word','Acc\BudgetController@budget_word');
Route::get('budget/budget_excel','Acc\BudgetController@budget_excel');
Route::get('budget/budget_pdf','Acc\BudgetController@budget_pdf');
Route::get('budget/budget_csv','Acc\BudgetController@budget_csv');

// Project Print
Route::get('acc-project/print','Acc\ProjectController@project_print');
Route::get('acc-project/word','Acc\ProjectController@project_word');
Route::get('acc-project/excel','Acc\ProjectController@project_excel');
Route::get('acc-project/pdf','Acc\ProjectController@project_pdf');
Route::get('acc-project/csv','Acc\ProjectController@project_csv');
// project planning Print
Route::get('pplanning/print','Acc\PplanningController@pplanning_print');
Route::get('pplanning/word','Acc\PplanningController@pplanning_word');
Route::get('pplanning/excel','Acc\PplanningController@pplanning_excel');
Route::get('pplanning/pdf','Acc\PplanningController@pplanning_pdf');
Route::get('pplanning/csv','Acc\PplanningController@pplanning_csv');
// COA  Print
Route::get('acccoa/print','Acc\AcccoaController@coa_print');
Route::get('acccoa/word','Acc\AcccoaController@coa_word');
Route::get('acccoa/excel','Acc\AcccoaController@coa_excel');
Route::get('acccoa/pdf','Acc\AcccoaController@coa_pdf');
Route::get('acccoa/csv','Acc\AcccoaController@coa_csv');
// Voucher  Print
Route::get('tranmaster/voucher_print/{id}','Acc\TranmasterController@voucher_print');
Route::get('tranmaster/voucher_word/{id}','Acc\TranmasterController@voucher_word');
Route::get('tranmaster/voucher_excel/{id}','Acc\TranmasterController@voucher_excel');
Route::get('tranmaster/voucher_pdf/{id}','Acc\TranmasterController@voucher_pdf');
Route::get('tranmaster/voucher_csv/{id}','Acc\TranmasterController@voucher_csv');
// ledger  Print
Route::get('tranmaster/ledger_print','Acc\TranmasterController@ledger_print');
Route::get('tranmaster/ledger_word','Acc\TranmasterController@ledger_word');
Route::get('tranmaster/ledger_excel','Acc\TranmasterController@ledger_excel');
Route::get('tranmaster/ledger_pdf','Acc\TranmasterController@ledger_pdf');
Route::get('tranmaster/ledger_csv','Acc\TranmasterController@ledger_csv');
// subhead  Print
Route::get('tranmaster/subhead_print','Acc\TranmasterController@subhead_print');
Route::get('tranmaster/subhead_word','Acc\TranmasterController@subhead_word');
Route::get('tranmaster/subhead_excel','Acc\TranmasterController@subhead_excel');
Route::get('tranmaster/subhead_pdf','Acc\TranmasterController@subhead_pdf');
Route::get('tranmaster/subhead_csv','Acc\TranmasterController@subhead_csv');
// department  Print
Route::get('tranmaster/department_print','Acc\TranmasterController@department_print');
Route::get('tranmaster/department_word','Acc\TranmasterController@department_word');
Route::get('tranmaster/department_excel','Acc\TranmasterController@department_excel');
Route::get('tranmaster/department_pdf','Acc\TranmasterController@department_pdf');
Route::get('tranmaster/department_csv','Acc\TranmasterController@department_csv');
// receivpt and payment  Print
Route::get('tranmaster/receiptpayment_print','Acc\TranmasterController@receiptpayment_print');
Route::get('tranmaster/receiptpayment_word','Acc\TranmasterController@receiptpayment_word');
Route::get('tranmaster/receiptpayment_excel','Acc\TranmasterController@receiptpayment_excel');
Route::get('tranmaster/receiptpayment_pdf','Acc\TranmasterController@receiptpayment_pdf');
Route::get('tranmaster/receiptpayment_csv','Acc\TranmasterController@receiptpayment_csv');

// Balancesheet  Print
Route::get('tranmaster/balancesheet_print','Acc\TranmasterController@balancesheet_print');
Route::get('tranmaster/balancesheet_word','Acc\TranmasterController@balancesheet_word');
Route::get('tranmaster/balancesheet_excel','Acc\TranmasterController@balancesheet_excel');
Route::get('tranmaster/balancesheet_pdf','Acc\TranmasterController@balancesheet_pdf');
Route::get('tranmaster/balancesheet_csv','Acc\TranmasterController@balancesheet_csv');
// profit  Print
Route::get('tranmaster/profitloss_print','Acc\TranmasterController@profitloss_print');
Route::get('tranmaster/profitloss_word','Acc\TranmasterController@profitloss_word');
Route::get('tranmaster/profitloss_excel','Acc\TranmasterController@profitloss_excel');
Route::get('tranmaster/profitloss_pdf','Acc\TranmasterController@profitloss_pdf');
Route::get('tranmaster/profitloss_csv','Acc\TranmasterController@profitloss_csv');
// Trial  Balance
Route::get('tranmaster/trialbalance_print','Acc\TranmasterController@trialbalance_print');
Route::get('tranmaster/trialbalance_word','Acc\TranmasterController@trialbalance_word');
Route::get('tranmaster/trialbalance_excel','Acc\TranmasterController@trialbalance_excel');
Route::get('tranmaster/trialbalance_pdf','Acc\TranmasterController@trialbalance_pdf');
Route::get('tranmaster/trialbalance_csv','Acc\TranmasterController@trialbalance_csv');

// manufacturing  Print 
Route::get('tranmaster/manufacturing_print','Acc\TranmasterController@manufacturing_print');
Route::get('tranmaster/manufacturing_word','Acc\TranmasterController@manufacturing_word');
Route::get('tranmaster/manufacturing_excel','Acc\TranmasterController@manufacturing_excel');
Route::get('tranmaster/manufacturing_pdf','Acc\TranmasterController@manufacturing_pdf');
Route::get('tranmaster/manufacturing_csv','Acc\TranmasterController@manufacturing_csv');
// pldistribution  Print pldistribution
Route::get('tranmaster/pldistribution_print','Acc\TranmasterController@pldistribution_print');
Route::get('tranmaster/pldistribution_word','Acc\TranmasterController@pldistribution_word');
Route::get('tranmaster/pldistribution_excel','Acc\TranmasterController@pldistribution_excel');
Route::get('tranmaster/pldistribution_pdf','Acc\TranmasterController@pldistribution_pdf');
Route::get('tranmaster/pldistribution_csv','Acc\TranmasterController@pldistribution_csv');
// Trading  Print 
Route::get('tranmaster/trading_print','Acc\TranmasterController@trading_print');
Route::get('tranmaster/trading_word','Acc\TranmasterController@trading_word');
Route::get('tranmaster/trading_excel','Acc\TranmasterController@trading_excel');
Route::get('tranmaster/trading_pdf','Acc\TranmasterController@trading_pdf');
Route::get('tranmaster/trading_csv','Acc\TranmasterController@trading_csv');
// lcinfo ledger  Print 
Route::get('lcinfo/ledger_print','Acc\LcinfoController@ledger_print');
Route::get('tranmaster/trading_word','Acc\TranmasterController@trading_word');
Route::get('tranmaster/trading_excel','Acc\TranmasterController@trading_excel');
Route::get('tranmaster/trading_pdf','Acc\TranmasterController@trading_pdf');
Route::get('tranmaster/trading_csv','Acc\TranmasterController@trading_csv');
// project ledger  Print 
Route::get('acc-project/ledger_print','Acc\ProjectController@ledger_print');
Route::get('acc-project/trading_word','Acc\TranmasterController@trading_word');
Route::get('acc-project/trading_excel','Acc\TranmasterController@trading_excel');
Route::get('acc-project/trading_pdf','Acc\TranmasterController@trading_pdf');
Route::get('acc-project/trading_csv','Acc\TranmasterController@trading_csv');
// Reconciliation ledger  Print 
Route::get('reconciliation/report_print','Acc\ReconciliationController@report_print');
Route::get('reconciliation/report_word','Acc\ReconciliationController@report_word');
Route::get('reconciliation/report_excel','Acc\ReconciliationController@report_excel');
Route::get('reconciliation/report_pdf','Acc\ReconciliationController@report_pdf');
Route::get('reconciliation/report_csv','Acc\ReconciliationController@report_csv');

// salary sheet  Print 
Route::get('empolyee/salary_print','Acc\EmpolyeeController@salary_print');
Route::get('empolyee/salary_word','Acc\EmpolyeeController@salary_word');
Route::get('empolyee/salary_excel','Acc\EmpolyeeController@salary_excel');
Route::get('empolyee/salary_pdf','Acc\EmpolyeeController@salary_pdf');
Route::get('empolyee/salary_csv','Acc\EmpolyeeController@salary_csv');
// party collectio
Route::get('salemaster/collection_print','Acc\SalemasterController@collection_print');
Route::get('salemaster/collection_word','Acc\SalemasterController@collection_word');
Route::get('salemaster/collection_excel','Acc\SalemasterController@collection_excel');
Route::get('salemaster/collection_pdf','Acc\SalemasterController@collection_pdf');
Route::get('salemaster/collection_csv','Acc\SalemasterController@collection_csv');
// party payment
Route::get('purchasemaster/collection_print','Acc\PurchasemasterController@collection_print');
Route::get('purchasemaster/collection_word','Acc\PurchasemasterController@collection_word');
Route::get('purchasemaster/collection_excel','Acc\PurchasemasterController@collection_excel');
Route::get('purchasemaster/collection_pdf','Acc\PurchasemasterController@collection_pdf');
Route::get('purchasemaster/collection_csv','Acc\PurchasemasterController@collection_csv');


// jeson Data
Route::get('pbudget/segment/{id}', 'Acc\PbudgetController@getSegment');
Route::get('tranmaster/bankcash/{id}', 'Acc\TranmasterController@bankcash');
Route::get('tranmaster/coacon/{id}', 'Acc\TranmasterController@coacon');
Route::get('tranmaster/segment/{id}', 'Acc\TranmasterController@getSegment');
Route::get('tranmaster/order/{id}', 'Acc\TranmasterController@getOrder');
Route::get('tranmaster/style/{id}', 'Acc\TranmasterController@getStyle');
Route::get('tranmaster/sis_acc/{id}', 'Acc\TranmasterController@sis_acc');
Route::get('dashboard/tdayex/{id}', 'DashboardController@tdayex');
Route::any('dashboard/display/','DashboardController@display');
Route::any('dashboard/stock/','DashboardController@stock');

	// Account
	Route::get('tranmaster/checkby','Acc\TranmasterController@checkby');
	Route::get('tranmaster/techeckby','Acc\TranmasterController@techeckby');
	Route::post('tranmaster/checked/{id}', 'Acc\TranmasterController@checked');
	Route::post('tranmaster/techecked/{id}', 'Acc\TranmasterController@techecked');
	Route::get('tranmaster/approveby','Acc\TranmasterController@approveby');
	Route::post('tranmaster/approved/{id}', 'Acc\TranmasterController@approved');
	Route::get('tranmaster/auditby','Acc\TranmasterController@auditby');
	Route::post('tranmaster/audited/{id}', 'Acc\TranmasterController@audited');
	Route::post('tranmaster/filter', 'Acc\TranmasterController@filter');
	Route::post('trandetail/filterd', 'Acc\TrandetailController@filterd');
	Route::post('trandetail/filterid', 'Acc\TrandetailController@filterid');
	Route::post('trandetail/iofilter', 'Acc\TrandetailController@iofilter');
	Route::post('trandetail/affilter', 'Acc\TrandetailController@affilter');
	Route::post('invenmaster/clfilter', 'Acc\InvenmasterController@clfilter');
	Route::post('invenmaster/rtfilter', 'Acc\InvenmasterController@rtfilter');
	Route::post('invenmaster/irfilter', 'Acc\InvenmasterController@irfilter');
	Route::post('invenmaster/sfilter', 'Acc\InvenmasterController@sfilter');

	Route::post('tranmaster/tfilter', 'Acc\TranmasterController@tfilter');
	Route::post('tranmaster/bfilter', 'Acc\TranmasterController@bfilter');
	Route::post('tranmaster/pfilter', 'Acc\TranmasterController@pfilter');
	Route::post('tranmaster/mfilter', 'Acc\TranmasterController@mfilter');
	Route::post('tranmaster/plfilter', 'Acc\TranmasterController@plfilter');
	Route::post('tranmaster/rfilter', 'Acc\TranmasterController@rfilter');
	Route::post('tranmaster/tmfilter', 'Acc\TranmasterController@tmfilter');
	Route::post('tranmaster/crfilter', 'Acc\TranmasterController@crfilter');
	Route::post('lcinfo/filter', 'Acc\LcinfoController@filter');
	Route::post('orderinfo/filter', 'Acc\OrderinfoController@filter');
	Route::post('tranmaster/depfilter', 'Acc\TranmasterController@depfilter');
	Route::post('tranmaster/subfilter', 'Acc\TranmasterController@subfilter');
	Route::post('importmaster/filter', 'Acc\ImportmasterController@filter');
	Route::post('importmaster/csfilter', 'Acc\ImportmasterController@csfilter');
	Route::post('purchasemaster/filter', 'Acc\PurchasemasterController@filter');
	Route::post('salemaster/filter', 'Acc\SalemasterController@filter');
	Route::post('salemaster/sifilter', 'Acc\SalemasterController@sifilter');
	Route::post('invenmaster/inifilter', 'Acc\InvenmasterController@inifilter');
	Route::post('invenmaster/chfilter', 'Acc\InvenmasterController@chfilter');
	Route::post('salemaster/tsfilter', 'Acc\SalemasterController@tsfilter');
	Route::post('salemaster/sbfilter', 'Acc\SalemasterController@sbfilter');
	Route::post('invenmaster/sbfilter', 'Acc\InvenmasterController@sbfilter');
	Route::post('company/filter', 'Acc\CompanyController@filter');
	Route::post('budget/filter', 'Acc\BudgetController@filter');
	Route::post('pplanning/filter', 'Acc\PplanningController@filter');
	Route::post('pbudget/filter', 'Acc\PbudgetController@filter');
	Route::get('acccoa/root321', 'Acc\AcccoaController@add_coa');
	Route::get('acccoa/manu321', 'Acc\AcccoaController@add_coa_manu');
	Route::get('acccoa/trad321', 'Acc\AcccoaController@add_coa_trading');
	Route::get('acccoa/pldis321', 'Acc\AcccoaController@add_coa_pldistribution');
	Route::get('acccoa/clear321', 'Acc\AcccoaController@clear_all');
	Route::post('tranmaster/trfilter', 'Acc\TranmasterController@trfilter');
	Route::post('lcinfo/lcfilter', 'Acc\LcinfoController@lcfilter');
	Route::post('importmaster/ilcfilter', 'Acc\ImportmasterController@ilcfilter');
	Route::post('acc-project/prfilter', 'Acc\ProjectController@prfilter');
	Route::post('acc-project/prjfilter', 'Acc\ProjectController@prjfilter');
	Route::post('acc-project/pafilter', 'Acc\ProjectController@pafilter');
	Route::post('reconciliation/recfilter', 'Acc\ReconciliationController@recfilter');
	Route::post('lcinfo/byrfilter', 'Acc\LcinfoController@byrfilter');
	Route::post('lctransfer/tranfilter', 'Acc\LctransferController@tranfilter');
	Route::post('reconciliation/rdatefilter', 'Acc\ReconciliationController@rdatefilter');
	Route::post('tranmaster/deprefilter', 'Acc\TranmasterController@deprefilter');
	Route::post('invenmaster/invfilter', 'Acc\InvenmasterController@invfilter');
	Route::post('invenmaster/lgfilter', 'Acc\InvenmasterController@lgfilter');
	Route::post('outlet/filter', 'Acc\OutletController@filter');
	Route::post('salemaster/checked/{id}', 'Acc\SalemasterController@checked');
	Route::post('salemaster/mfilter', 'Acc\SalemasterController@mfilter');
	Route::post('salemaster/clfilter', 'Acc\SalemasterController@clfilter');
	Route::post('salemaster/ifilter', 'Acc\SalemasterController@ifilter');
	Route::post('salemaster/pfilter', 'Acc\SalemasterController@pfilter');
	Route::post('purchasemaster/checked/{id}', 'Acc\PurchasemasterController@checked');
	Route::post('purchasemaster/pfilter', 'Acc\PurchasemasterController@pfilter');
	Route::post('purchasemaster/clfilter', 'Acc\PurchasemasterController@clfilter');
	Route::post('salemaster/ofilter', 'Acc\SalemasterController@ofilter');
	Route::post('salemaster/ofilter', 'Acc\SalemasterController@ofilter');
	Route::post('importmaster/pfilter', 'Acc\ImportmasterController@pfilter');
	Route::post('importmaster/sfilter', 'Acc\ImportmasterController@sfilter');
	Route::post('lcinfo/csfilter', 'Acc\LcinfoController@csfilter');
	Route::post('b2b/b2bfilter', 'Acc\B2bController@b2bfilter');
	Route::post('orderinfo/orfilter', 'Acc\OrderinfoController@orfilter');
	Route::post('importmaster/idfilter', 'Acc\ImportmasterController@idfilter');
	Route::post('salary/pay/{id}', 'Acc\SalaryController@pay');
	Route::post('salary/filter', 'Acc\SalaryController@filter');
	Route::post('salemaster/cfilter', 'Acc\SalemasterController@cfilter');
	Route::post('purchasemaster/payfilter', 'Acc\PurchasemasterController@payfilter');
	
	Route::get('qproduct/price/{id}', 'Acc\QproductController@getPrice');
	Route::get('invenmaster/price/{id}', 'Acc\InvenmasterController@getPrice');
	Route::get('invenmaster/qty/{id}', 'Acc\InvenmasterController@getQTY');

Route::group(['middleware' => ['auth', 'authorize']], function(){
    Route::get('project/trashed', 'Lib\Hrm\ProjectController@trashed');
	Route::post('project/trashed/{id}', 'Lib\Hrm\ProjectController@restore');
    Route::get('dept/trashed', 'Lib\Hrm\DeptController@trashed');
	Route::post('dept/trashed/{id}', 'Lib\Hrm\DeptController@restore');
    Route::get('designation/trashed', 'Lib\Hrm\DesignationController@trashed');
	Route::post('designation/trashed/{id}', 'Lib\Hrm\DesignationController@restore');
    Route::get('religion/trashed', 'Lib\Hrm\ReligionController@trashed');
	Route::post('religion/trashed/{id}', 'Lib\Hrm\ReligionController@restore');
    Route::get('district/trashed', 'Lib\Hrm\DistrictController@trashed');
	Route::post('district/trashed/{id}', 'Lib\Hrm\DistrictController@restore');
    Route::get('division/trashed', 'Lib\Hrm\DivisionController@trashed');
	Route::post('division/trashed/{id}', 'Lib\Hrm\DivisionController@restore');
    Route::get('unit/trashed', 'Lib\Hrm\UnitController@trashed');
	Route::post('unit/trashed/{id}', 'Lib\Hrm\UnitController@restore');
    Route::get('section/trashed', 'Lib\Hrm\SectionController@trashed');
	Route::post('section/trashed/{id}', 'Lib\Hrm\SectionController@restore');
    Route::get('sub-section/trashed', 'Lib\Hrm\SubSectionController@trashed');
	Route::post('sub-section/trashed/{id}', 'Lib\Hrm\SubSectionController@restore');
    Route::get('staff-category/trashed', 'Lib\Hrm\StaffCategoryController@trashed');
	Route::post('staff-category/trashed/{id}', 'Lib\Hrm\StaffCategoryController@restore');
    Route::get('govt-salary/trashed', 'Lib\Hrm\GovtSalaryController@trashed');
	Route::post('govt-salary/trashed/{id}', 'Lib\Hrm\GovtSalaryController@restore');
    Route::get('lineinfo/trashed', 'Lib\Hrm\LineinfoController@trashed');
	Route::post('lineinfo/trashed/{id}', 'Lib\Hrm\LineinfoController@restore');
    Route::get('grade/trashed', 'Lib\Hrm\GradeController@trashed');
	Route::post('grade/trashed/{id}', 'Lib\Hrm\GradeController@restore');
    Route::get('other-salary/trashed', 'Lib\Hrm\OtherSalaryController@trashed');
	Route::post('other-salary/trashed/{id}', 'Lib\Hrm\OtherSalaryController@restore');
    Route::get('attendance-payment-name/trashed', 'Lib\Hrm\AttendancePaymentNameController@trashed');
	Route::post('attendance-payment-name/trashed/{id}', 'Lib\Hrm\AttendancePaymentNameController@restore');
    
    Route::get('employee-basic-info/trashed', 'Lib\Hrm\EmployeeBasicInfoController@trashed');
	Route::post('employee-basic-info/trashed/{id}', 'Lib\Hrm\EmployeeBasicInfoController@restore');
	

   
	Route::resource('users', 'UsersController');
	Route::resource('roles', 'Access\RolesController');
	Route::resource('permissions', 'Access\PermissionsController');
	Route::resource('profile', 'ProfileController');
	Route::resource('language', 'Lib\LanguageController');
	Route::resource('project', 'Lib\Hrm\ProjectController');
	Route::resource('dept', 'Lib\Hrm\DeptController');
	Route::resource('designation', 'Lib\Hrm\DesignationController');
	Route::resource('religion', 'Lib\Hrm\ReligionController');
	Route::resource('district', 'Lib\Hrm\DistrictController');
	Route::resource('division', 'Lib\Hrm\DivisionController');
	Route::resource('unit', 'Lib\Hrm\UnitController');
	Route::resource('section', 'Lib\Hrm\SectionController');
	Route::resource('sub-section', 'Lib\Hrm\SubSectionController');
	Route::resource('staff-category', 'Lib\Hrm\StaffCategoryController');
	Route::resource('govt-salary', 'Lib\Hrm\GovtSalaryController');
	Route::resource('lineinfo', 'Lib\Hrm\LineinfoController');
	Route::resource('grade', 'Lib\Hrm\GradeController');
	Route::resource('other-salary', 'Lib\Hrm\OtherSalaryController');
	Route::resource('attendance-payment-name', 'Lib\Hrm\AttendancePaymentNameController');
    
	Route::resource('employee-basic-info', 'Hrm\EmployeeBasicInfoController');
	
	// Account Department
		$option=Options::latest()->first();
		Route::resource('acccoa', 'Acc\AcccoaController');
		Route::resource('coadetail', 'Acc\CoadetailController');
		Route::resource('coacondition', 'Acc\CoaconditionController');
		Route::resource('product', 'Acc\ProductController');
		Route::resource('orderinfo', 'Acc\OrderinfoController');
		Route::resource('lcinfo', 'Acc\LcinfoController');
		Route::resource('buyerinfo', 'Acc\BuyerinfoController');
		Route::resource('supplier', 'Acc\SupplierController');
		Route::resource('budget', 'Acc\BudgetController');
		Route::resource('prequisition', 'Acc\PrequisitionController');
		Route::resource('frequisition', 'Acc\FrequisitionController');
		Route::resource('client', 'Acc\ClientController');
		Route::resource('style', 'Acc\StyleController');
		Route::resource('lcimport', 'Acc\LcimportController');
		Route::resource('purchasemaster', 'Acc\PurchasemasterController');
		Route::resource('purchasedetail', 'Acc\PurchasedetailController');
		Route::resource('importmaster', 'Acc\ImportmasterController');
		Route::resource('importdetail', 'Acc\ImportdetailController');
		Route::resource('salemaster', 'Acc\SalemasterController');
		Route::resource('outlet', 'Acc\OutletController');
		Route::resource('saledetail', 'Acc\SaledetailController');
		Route::resource('tranmaster', 'Acc\TranmasterController');
		Route::resource('trandetail', 'Acc\TrandetailController');
		Route::resource('acc-project', 'Acc\ProjectController');
		Route::resource('company', 'Acc\CompanyController');
		Route::resource('setting', 'Acc\SettingController');
		Route::resource('option', 'Acc\OptionController');
		Route::resource('warehouse', 'Acc\WarehouseController');
		Route::resource('acc-unit', 'Acc\AccUnitController');
		Route::resource('acc-currency', 'Acc\CurrencyController');
		Route::resource('audit', 'Acc\AuditController');
		Route::resource('invenmaster', 'Acc\InvenmasterController');
		Route::resource('invendetail', 'Acc\InvendetailController');
		Route::resource('pplanning', 'Acc\PplanningController');
		Route::resource('pbudget', 'Acc\PbudgetController');
		Route::resource('country', 'Acc\CountryController');
		Route::resource('subhead', 'Acc\SubheadController');
		Route::resource('mteam', 'Acc\MteamController');
		Route::resource('usercompany', 'Acc\UsercompanyController');
		Route::resource('department', 'Acc\DepartmentController');
		Route::resource('b2b', 'Acc\B2bController');
		Route::resource('lctransfer', 'Acc\LctransferController');
		Route::resource('reconciliation', 'Acc\ReconciliationController');
		Route::resource('topic', 'Acc\TopicController');
		Route::resource('coverpage', 'Acc\CoverpageController');
		Route::resource('clientlist', 'Acc\ClientlistController');
		Route::resource('condition', 'Acc\ConditionController');
		Route::resource('termcondition', 'Acc\TermconditionController');
		Route::resource('page', 'Acc\PageController');
		Route::resource('quotation', 'Acc\QuotationController');
		Route::resource('fletter', 'Acc\FletterController');
		Route::resource('signature', 'Acc\SignatureController');
		Route::resource('qproduct', 'Acc\QproductController');
		Route::resource('empolyee', 'Acc\EmpolyeeController');
		Route::resource('desigtn', 'Acc\DesigtnController');
		Route::resource('salary', 'Acc\SalaryController');
		Route::resource('ittype', 'Acc\IttypeController');
    
	Route::get('/role_permission', 'Access\RolesPermissionsController@index');
	Route::post('/role_permission', 'Access\RolesPermissionsController@store');
	

});

	//Merchandizing 
	include(app_path().'/library/merch/route.php');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
