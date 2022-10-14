<!-- Collect the nav links, forms, and other content for toggling -->

<?php 
use App\Models\Acc\Settings;
use App\Models\Acc\Options;

$setting=Settings::latest()->first();

Session::has('com_id') ? 
$com_id=Session::get('com_id') : $com_id='' ; //echo $com_id.'osama';

$option=Options::where('com_id',$com_id)->first();
$option_id=''; isset($option) && $option->id > 0 ? $option_id=$option->id : $option_id='';

//include(app_path().'/library/acc/myFunctions.php');

?>
<style>
	.gap { margin-left:100px; }
</style>
<div class="collapse navbar-collapse" id="topbar-collapse">
    <ul class="nav navbar-nav" >
		<!--<li><a class="home" href="{{ url('dashboard') }}"><i class='fa fa-home'></i> <span>Home</span></a></li>--> 
        <?php $setting['onem']='accounting'; ?>       
        @if ($setting['onem']=='accounting' )
        	@if (Entrust::can('manage_export'))
            <li class="dropdown">
            <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Export</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('buyerinfo') }}"><i class='fa fa-users'></i> <span>Buyer</span></a></li>
                    <li><a href="{{ url('lcinfo') }}"><i class='fa fa-cogs'></i> <span>LC Info</span></a></li>
                    <li><a href="{{ url('lctransfer') }}"><i class='fa fa-cogs'></i> <span>LC Transfer</span></a></li>
                    <li><a href="{{ url('b2b') }}"><i class='fa fa-cogs'></i> <span>B2B</span></a></li>
                    <li><a href="{{ url('orderinfo') }}"><i class='fa fa-cogs'></i> <span>Order Info</span></a></li>
                    <li><a href="{{ url('style') }}"><i class='fa fa-cogs'></i> <span>Style Info</span></a></li>
                    <li><a href="{{ url('lcinfo/costsheet') }}"><i class='fa fa-cogs'></i> <span>Costsheet</span></a></li>
                    <li><a href="{{ url('lcinfo/ledger') }}"><i class='fa fa-cogs'></i> <span>LC Ledger</span></a></li>
                    <li><a href="{{ url('lcinfo/report') }}"><i class='fa fa-cogs'></i> <span>Buyer Export</span></a></li>
                    <li><a href="{{ url('lcinfo/report') }}"><i class='fa fa-cogs'></i> <span>Country Export</span></a></li>
                    <li><a href="{{ url('option/export/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
                </ul>
            </li> 
            @endif
        	@if (Entrust::can('manage_import'))
            <li class="dropdown">
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Import</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('supplier') }}"><i class='fa fa-users'></i> <span>Supplier</span></a></li>
                    <li><a href="{{ url('lcimport') }}"><i class='fa fa-cogs'></i> <span>LC Info</span></a></li>
                    <li><a href="{{ url('product') }}"><i class='fa fa-cogs'></i> <span>Product</span></a></li>
                    <li><a href="{{ url('importmaster') }}"><i class='fa fa-cogs'></i> <span>Import</span></a></li>
                    <li><a href="{{ url('importmaster/costsheet') }}"><i class='fa fa-cogs'></i> <span>Cost Sheet</span></a></li>
                    <li><a href="{{ url('importmaster/ledger') }}"><i class='fa fa-cogs'></i> <span>Ledger</span></a></li>
                    <li><a href="{{ url('option/import/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
                    <li><a href="{{ url('country') }}"><i class='fa fa-cogs'></i> <span>Country</span></a></li>
                </ul>
            </li> 
            @endif
        	@if (Entrust::can('manage_purchase'))
            <li class="dropdown">
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Purchase</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('client') }}"><i class='fa fa-users'></i> <span>Client</span></a></li>
                    <li><a href="{{ url('product') }}"><i class='fa fa-cogs'></i> <span>Product</span></a></li>
                    <li><a href="{{ url('prequisition') }}"><i class='fa fa-cogs'></i> <span>Requisition</span></a></li>
                    <li><a href="{{ url('purchasemaster') }}"><i class='fa fa-cogs'></i> <span>Purchase</span></a></li>
                    <li><a href="{{ url('purchasemaster/check') }}"><i class='fa fa-cogs'></i> <span>Check</span></a></li>
                    <li><a href="{{ url('purchasemaster/report') }}"><i class='fa fa-cogs'></i> <span>Purchase Report</span></a></li>
                    <li><a href="{{ url('purchasemaster/client') }}"><i class='fa fa-cogs'></i> <span>Client Report</span></a></li>
                    <li><a href="{{ url('product/report') }}"><i class='fa fa-cogs'></i> <span>Product Report</span></a></li>
                    <li><a href="{{ url('option/purchase/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
                    <li><a href="{{ url('acc-unit') }}"><i class='fa fa-cogs'></i> <span>Unit</span></a></li>
                </ul>                   
            </li> 
            @endif
        	@if (Entrust::can('manage_sale'))
            <li>
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Sales</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('client') }}"><i class='fa fa-users'></i> <span>Client</span></a></li>
                    <li><a href="{{ url('product') }}"><i class='fa fa-cogs'></i> <span>Product</span></a></li>
                    <li><a href="{{ url('outlet') }}"><i class='fa fa-cogs'></i> <span>Outlet</span></a></li>
                    <li><a href="{{ url('mteam') }}"><i class='fa fa-cogs'></i> <span>Marketing Team</span></a></li>
                    <li><a href="{{ url('salemaster') }}"><i class='fa fa-cogs'></i> <span>Sale</span></a></li>
                    <li><a href="{{ url('salemaster/check') }}"><i class='fa fa-cogs'></i> <span>Check</span></a></li>
                    <li><a href="{{ url('salemaster/invoice') }}"><i class='fa fa-cogs'></i> <span>Invoice</span></a></li>
                    <li><a href="{{ url('salemaster/challan') }}"><i class='fa fa-cogs'></i> <span>Challan</span></a></li>
                    <li><a href="{{ url('salemaster/report') }}"><i class='fa fa-cogs'></i> <span>Sales Report</span></a></li>
                    <li><a href="{{ url('salemaster/client') }}"><i class='fa fa-cogs'></i> <span>Client Report</span></a></li>
                    <li><a href="{{ url('salemaster/mteam') }}"><i class='fa fa-cogs'></i> <span>Team Report</span></a></li>
                    <li><a href="{{ url('salemaster/product') }}"><i class='fa fa-cogs'></i> <span>Product Report</span></a></li>
                    <li><a href="{{ url('salemaster/stock') }}"><i class='fa fa-cogs'></i> <span>Stock</span></a></li>
                    <li><a href="{{ url('option/sale/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
                </ul>                 
            </li> 
            @endif
        	@if (Entrust::can('manage_budgets'))

            <li>
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Budget</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('budget') }}"><i class='fa fa-users'></i> <span>Capital</span></a></li>
                    <li><a href="{{ url('budget') }}"><i class='fa fa-cogs'></i> <span>Revenue</span></a></li>
                     <li><a href="{{ url('budget') }}"><i class='fa fa-cogs'></i> <span>Cash Flow</span></a></li>
                    <li><a href="{{ url('budget') }}"><i class='fa fa-cogs'></i> <span>Special</span></a></li>
                </ul>                 
            </li>                 
            @endif
        	@if (Entrust::can('manage_projects'))
            <li>
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Project</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-submenu">
                            <a tabindex="0" data-toggle="dropdown">Quotation</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('quotation') }}"><i class='fa fa-users'></i> <span>Quotation</span></a></li>
                                <li><a href="{{ url('coverpage') }}"><i class='fa fa-users'></i> <span>Cover Page</span></a></li>
                                <li><a href="{{ url('fletter') }}"><i class='fa fa-users'></i> <span>Forwarding Letter</span></a></li>
                                <li><a href="{{ url('topic') }}"><i class='fa fa-users'></i> <span>Topic</span></a></li>
                                <li><a href="{{ url('condition') }}"><i class='fa fa-users'></i> <span>Condition</span></a></li>
                                <li><a href="{{ url('termcondition') }}"><i class='fa fa-users'></i> <span>Terms and Condition</span></a></li>
                                <li><a href="{{ url('qproduct') }}"><i class='fa fa-users'></i> <span>Produst List</span></a></li>
                                <li><a href="{{ url('clientlist') }}"><i class='fa fa-users'></i> <span>Client List</span></a></li>
                                <li><a href="{{ url('clientlist') }}"><i class='fa fa-users'></i> <span>Signature</span></a></li>
                            </ul>
                        </li>
                        
                    <li><a href="{{ url('acc-project') }}"><i class='fa fa-users'></i> <span>Project</span></a></li>
                    <li><a href="{{ url('pplanning') }}"><i class='fa fa-cogs'></i> <span>Planning</span></a></li>
                    <li><a href="{{ url('pbudget') }}"><i class='fa fa-cogs'></i> <span>Budget</span></a></li>
                    <li><a href="{{ url('acc-project/costsheet') }}"><i class='fa fa-cogs'></i> <span>Costsheet</span></a></li>
                    <li><a href="{{ url('acc-project/ledger') }}"><i class='fa fa-cogs'></i> <span>Ledger</span></a></li>
                    <li><a href="{{ url('acc-project/projectadvance') }}"><i class='fa fa-cogs'></i> <span>Project Advance</span></a></li>
                </ul>                 
            </li>                 
            @endif
        	@if (Entrust::can('manage_coas'))
            <li>
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>COA</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('acccoa') }}"><i class='fa fa-users'></i> <span>COA</span></a></li>
                    <li><a href="{{ url('coadetail') }}"><i class='fa fa-cogs'></i> <span>Details</span></a></li>
                    <li><a href="{{ url('coacondition') }}"><i class='fa fa-cogs'></i> <span>Condition</span></a></li>
                    <li><a href="{{ url('acccoa/report') }}"><i class='fa fa-cogs'></i> <span>COA Report</span></a></li>
                    <li><a href="{{ url('subhead') }}"><i class='fa fa-cogs'></i> <span>Subhead</span></a></li>
                    <li><a href="{{ url('department') }}"><i class='fa fa-cogs'></i> <span>Department</span></a></li>
                </ul>                 
            </li>                  
            @endif
        	@if (Entrust::can('manage_tran'))

            <li>
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Transaction</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('prequisition') }}"><i class='fa fa-users'></i> <span>Requisition</span></a></li>
                    <li><a href="{{ url('tranmaster') }}"><i class='fa fa-users'></i> <span>Transaction</span></a></li>
                    <li><a href="{{ url('tranmaster/create?t=Payment') }}"><i class='fa fa-users'></i> <span>Payment</span></a></li>
                    <li><a href="{{ url('tranmaster/create?t=Receipt') }}"><i class='fa fa-cogs'></i> <span>Receipt</span></a></li>
                    <li><a href="{{ url('tranmaster/create?t=Journal') }}"><i class='fa fa-cogs'></i> <span>Journal</span></a></li>
                    <li><a href="{{ url('tranmaster/depreciation') }}"><i class='fa fa-cogs'></i> <span>Depreciation</span></a></li>
                    <li><a href="{{ url('reconciliation') }}"><i class='fa fa-cogs'></i> <span>Reconciliation</span></a></li>
                    <li><a href="{{ url('empolyee/salary') }}"><i class='fa fa-cogs'></i> <span>Salary</span></a></li>
                    <li><a href="{{ url('trandetail/ioslip') }}"><i class='fa fa-cogs'></i> <span>IO Slip</span></a></li>
                    <li><a href="{{ url('option/transaction/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
                </ul>                 
            </li>                
            @endif
        	@if (Entrust::can('manage_report'))
            <li>
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Report</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                @if (Entrust::can('ledger_view'))
                    <li><a href="{{ url('tranmaster/ledger') }}"><i class='fa fa-users'></i> <span>Ledger</span></a></li>
                @endif
                @if (Entrust::can('subhead_view'))
                    <li><a href="{{ url('tranmaster/subhead') }}"><i class='fa fa-cogs'></i> <span>Subhead Ledger</span></a></li>
                @endif
                @if (Entrust::can('department_view'))
                    <li><a href="{{ url('tranmaster/department') }}"><i class='fa fa-cogs'></i> <span>Department Ledger</span></a></li>
                @endif
                @if (Entrust::can('receiptpayment_view'))
                    <li><a href="{{ url('tranmaster/receiptpayment') }}"><i class='fa fa-cogs'></i> <span>Recipt and Payment</span></a></li>
                @endif
                @if (Entrust::can('checqueregister_view'))
                    <li><a href="{{ url('tranmaster/cheqregister') }}"><i class='fa fa-cogs'></i> <span>Checque Register</span></a></li>
                @endif
                @if (Entrust::can('reconciliation_view'))
                    <li><a href="{{ url('reconciliation/report') }}"><i class='fa fa-cogs'></i> <span>Reconciliation</span></a></li>
                @endif
                @if (Entrust::can('trialbalance_view'))
                    <li><a href="{{ url('tranmaster/trialbalance') }}"><i class='fa fa-cogs'></i> <span>Trial Balance</span></a></li>
                @endif
                @if (Entrust::can('profitloss_view'))
                    <li><a href="{{ url('tranmaster/profitloss') }}"><i class='fa fa-cogs'></i> <span>Profit and Loss</span></a></li>
                @endif
                @if (Entrust::can('trading_view'))
                    <li><a href="{{ url('tranmaster/trading') }}"><i class='fa fa-cogs'></i> <span>Trading Account</span></a></li>
                @endif
                @if (Entrust::can('manufacturing_view'))
                    <li><a href="{{ url('tranmaster/manufacturing') }}"><i class='fa fa-cogs'></i> <span>Manufacturing</span></a></li>
                @endif
                @if (Entrust::can('pldistribution_view'))
                    <li><a href="{{ url('tranmaster/pldistribution') }}"><i class='fa fa-cogs'></i> <span>PL Distribution</span></a></li>
                @endif
                @if (Entrust::can('balancesheet_view'))
                    <li><a href="{{ url('tranmaster/balancesheet') }}"><i class='fa fa-cogs'></i> <span>Balance Sheet</span></a></li>
                @endif
                @if (Entrust::can('particollection_view'))
                    <li><a href="{{ url('salemaster/collection') }}"><i class='fa fa-cogs'></i> <span>Party Collection</span></a></li>
                @endif
                @if (Entrust::can('partypayment_view'))
                    <li><a href="{{ url('purchasemaster/payment') }}"><i class='fa fa-cogs'></i> <span>Party Payment</span></a></li>
                @endif
                    <li><a href="{{ url('trandetail/cashflowd') }}"><i class='fa fa-cogs'></i> <span>CashFlow Direct</span></a></li>
                    <li><a href="{{ url('trandetail/cashflowid') }}"><i class='fa fa-cogs'></i> <span>CashFlow Indirect</span></a></li>

                </ul>                 
            </li>
            @endif
        	@if (Entrust::can('manage_inventory'))
            <li>
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Inventory</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('invenmaster') }}"><i class='fa fa-users'></i> <span>Inventory</span></a></li>
                    <li><a href="{{ url('invenmaster/create?f=Receive') }}"><i class='fa fa-users'></i> <span>Receive</span></a></li>
                    <li><a href="{{ url('invenmaster/create?f=Issue') }}"><i class='fa fa-cogs'></i> <span>Issue</span></a></li>
                    <li><a href="{{ url('invenmaster/checkby') }}"><i class='fa fa-cogs'></i> <span>Check</span></a></li>
                    <li><a href="{{ url('warehouse') }}"><i class='fa fa-cogs'></i> <span>Warehouse</span></a></li>
                    <li><a href="{{ url('invenmaster/ledger') }}"><i class='fa fa-cogs'></i> <span>Product Ledger</span></a></li>
                    <li><a href="{{ url('invenmaster/client') }}"><i class='fa fa-cogs'></i> <span>Client Ledger</span></a></li>
                    <li><a href="{{ url('invenmaster/rcvdissue') }}"><i class='fa fa-cogs'></i> <span>Receive and Issue</span></a></li>
                    <li><a href="{{ url('invenmaster/stock') }}"><i class='fa fa-cogs'></i> <span>Stock Balance 1</span></a></li>
                    <li><a href="{{ url('invenmaster/sbalance') }}"><i class='fa fa-cogs'></i> <span>Stock Balance 2</span></a></li>
                    <li><a href="{{ url('invenmaster/report') }}"><i class='fa fa-cogs'></i> <span>Stock Balance 3</span></a></li>
                    <li><a href="{{ url('invenmaster/invoice') }}"><i class='fa fa-cogs'></i> <span>Invoice</span></a></li>
                    <li><a href="{{ url('invenmaster/challan') }}"><i class='fa fa-cogs'></i> <span>Challan</span></a></li>
                    <li><a href="{{ url('option/inventory/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
                </ul>                 
            </li>                 
            @endif
        	@if (Entrust::can('manage_audits'))
            <li>
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Audit</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                @if (Entrust::can('tecknical_check'))
                    <li><a href="{{ url('tranmaster/techeckby') }}"><i class='fa fa-users'></i> <span>Technical Check</span></a></li>
				@endif
                @if (Entrust::can('partypayment_view'))
                    <li><a href="{{ url('tranmaster/checkby') }}"><i class='fa fa-users'></i> <span>Check</span></a></li>
				@endif
                @if (Entrust::can('partypayment_view'))
                    <li><a href="{{ url('tranmaster/approveby') }}"><i class='fa fa-cogs'></i> <span>Approve</span></a></li>
				@endif
                @if (Entrust::can('partypayment_view'))
                    <li><a href="{{ url('tranmaster/auditby') }}"><i class='fa fa-users'></i> <span>Audit</span></a></li>
				@endif
                @if (Entrust::can('partypayment_view'))
                    <li><a href="{{ url('audit/reply') }}"><i class='fa fa-cogs'></i> <span>Reply</span></a></li>
				@endif
                @if (Entrust::can('partypayment_view'))
                    <li><a href="{{ url('audit/final_action') }}"><i class='fa fa-cogs'></i> <span>Final Action</span></a></li>
				@endif
                @if (Entrust::can('partypayment_view'))
                    <li><a href="{{ url('audit/internal_report') }}"><i class='fa fa-cogs'></i> <span>Internal Audit Report</span></a></li>
				@endif
                @if (Entrust::can('partypayment_view'))
                    <li><a href="{{ url('option/audit/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
				@endif
                </ul>                 
            </li>                 
            @endif
        	@if (Entrust::can('manage_tools'))
            <li>
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Tools</span> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                	<li><a href="/backup.php"><i class='fa fa-users'></i> <span>Database Backup</span></a></li>
                    <li><a href="{{ url('setting') }}"><i class='fa fa-users'></i> <span>Settings</span></a></li>
                    <li><a href="{{ url('option') }}"><i class='fa fa-cogs'></i> <span>Options</span></a></li>
                    <li><a href="{{ url('company') }}"><i class='fa fa-cogs'></i> <span>Company</span></a></li>
                    <li><a href="{{ url('usercompany') }}"><i class='fa fa-cogs'></i> <span>Company for users</span></a></li>
                    <li><a href="{{ url('usercompany') }}"><i class='fa fa-cogs'></i> <span>Database Backup</span></a></li>
                </ul> 
            </li> 
            @endif
        @endif
		@if ($setting['onem']=='merchandizing' )
        		<!--Merchandizing -->
                <li class="dropdown">
                <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Order Information</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('buyer') }}"><i class='fa fa-users'></i> <span>Buyer</span></a></li>
                        <li><a href="{{ url('order') }}"><i class='fa fa-cogs'></i> <span>Order Info</span></a></li>
                        <li><a href="{{ url('pomaster') }}"><i class='fa fa-cogs'></i> <span>PO Info</span></a></li>
                        <li><a href="{{ url('fabricmaster') }}"><i class='fa fa-cogs'></i> <span>Fabrication</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Yarn</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Print & Embroidery</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Trims</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Other</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Costsheet</span></a></li>
                    </ul>
                </li> 
                <li class="dropdown">
                    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Work Order</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-users'></i> <span>Trims</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Print</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Embroidery</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>AOP</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Finishing</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Washing</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Finish Fabric</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Knitting</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Yarn Dyeing</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Yarn</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Sample</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Yarn Requisition</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
                    </ul>
                </li> 
                <li class="dropdown">
                    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Sample</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-users'></i> <span>Sample</span></a></li>
                    </ul>                   
                </li> 
                <li>
                    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Check And Approval</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-users'></i> <span>Check</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Approve</span></a></li>
                    </ul>                 
                </li> 
                <li>
                    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Short Management</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-users'></i> <span>Fabric</span></a></li>
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-cogs'></i> <span>Trim</span></a></li>
                    </ul>                 
                </li>                  
                <li>
                    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Marketing</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-users'></i> <span>Marketing</span></a></li>
                    </ul>                 
                </li>                
                <li>
                    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Report</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('dashboard/coming') }}"><i class='fa fa-users'></i> <span>Order List</span></a></li>
                    </ul>                 
                </li>
                <li class="dropdown right-sub">
                    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-calculator'></i> Library<span class="caret"></span></a>
                    
                    <!-- role="menu": fix moved by arrows (Bootstrap dropdown) -->
                    <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-submenu">
                            <a tabindex="0" data-toggle="dropdown">Order</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('port') }}"><i class='fa fa-users'></i> <span>Port</span></a></li>
                                <li><a href="{{ url('bdtype') }}"><i class='fa fa-users'></i> <span>Breakdown Type</span></a></li>
                                <li><a href="{{ url('incoterm') }}"><i class='fa fa-users'></i> <span>Incoterm</span></a></li>
                                <li><a href="{{ url('lcmode') }}"><i class='fa fa-users'></i> <span>LC Mode</span></a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a tabindex="0" data-toggle="dropdown">Fabrication</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('gtype') }}"><i class='fa fa-users'></i> <span>Garments Type</span></a></li>
                                <li><a href="{{ url('pogarment') }}"><i class='fa fa-users'></i> <span>Part of Garments</span></a></li>
                                <li><a href="{{ url('dia') }}"><i class='fa fa-users'></i> <span>DIA</span></a></li>
                                <li><a href="{{ url('diatype') }}"><i class='fa fa-users'></i> <span>DIA Type</span></a></li>
                                <li><a href="{{ url('structure') }}"><i class='fa fa-users'></i> <span>Struncture</span></a></li>
                                <li><a href="{{ url('gsm') }}"><i class='fa fa-users'></i> <span>GSM</span></a></li>
                                <li><a href="{{ url('ftype') }}"><i class='fa fa-users'></i> <span>Fabric Type</span></a></li>
                                <li><a href="{{ url('finishing') }}"><i class='fa fa-users'></i> <span>Finishing</span></a></li>
                                <li><a href="{{ url('ycount') }}"><i class='fa fa-users'></i> <span>Yarn Count</span></a></li>                                
                                <li><a href="{{ url('ycount') }}"><i class='fa fa-users'></i> <span>Yarn Count</span></a></li>
                                <li><a href="{{ url('yconsumption') }}"><i class='fa fa-users'></i> <span>Yarn Consumption</span></a></li>
                                <li><a href="{{ url('lycraraion') }}"><i class='fa fa-users'></i> <span>Elastane Ratio</span></a></li>
                                <li><a href="{{ url('ydstripe') }}"><i class='fa fa-users'></i> <span>YD Stripe</span></a></li>
                                <li><a href="{{ url('ccuff') }}"><i class='fa fa-users'></i> <span>Collar Cuff</span></a></li>
                                <li><a href="{{ url('washing') }}"><i class='fa fa-users'></i> <span>washing</span></a></li>
                                <li><a href="{{ url('aop') }}"><i class='fa fa-users'></i> <span>AOP</span></a></li>
                                <li><a href="{{ url('cprocess') }}"><i class='fa fa-users'></i> <span>Process Type</span></a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a tabindex="0" data-toggle="dropdown">Work Order</a>
                            <ul class="dropdown-menu">
                                <li><a tabindex="0">Sub action</a></li>
                                <li><a tabindex="0" data-toggle="dropdown">Another sub action</a></li>
                                <li><a tabindex="0">Something else here</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>
                <li>
                    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Tools</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('setting') }}"><i class='fa fa-users'></i> <span>Settings</span></a></li>
                        <li><a href="{{ url('option') }}"><i class='fa fa-cogs'></i> <span>Options</span></a></li>
                        <li><a href="{{ url('company') }}"><i class='fa fa-cogs'></i> <span>Company</span></a></li>
                        <li><a href="{{ url('usercompany') }}"><i class='fa fa-cogs'></i> <span>Company for users</span></a></li>
                        <li><a href="{{ url('usercompany') }}"><i class='fa fa-cogs'></i> <span>Database Backup</span></a></li>
                    </ul> 
                </li> 
                @endif

                @if (Entrust::can(['manage_users', 'manage_roles', 'manage_permissions', 'role_permission']))
                <li class="dropdown right-sub">
                    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Users</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        @if (Entrust::can(['manage_users', 'create_users', 'update_users', 'delete_users']))
                        <li><a href="{{ url('users') }}"><i class='fa fa-users'></i> <span>Users</span></a></li>
                        @endif
                        @if (Entrust::can('manage_roles'))
                        <li><a href="{{ url('roles') }}"><i class='fa fa-cogs'></i> <span>Roles</span></a></li>
                        @endif
                        @if (Entrust::can('manage_permissions'))
                        <li><a href="{{ url('permissions') }}"><i class='fa fa-key'></i> <span>Permissions</span></a></li>
                        @endif
                        @if (Entrust::can('role_permission'))
                        <li><a href="{{ url('role_permission') }}"><i class='fa fa-user-plus'></i> <span>Roles &amp; Permissions</span></a></li>
                        @endif
                    </ul>
                </li>
                @endif

    </ul>                     
</div><!-- /.navbar-collapse -->
