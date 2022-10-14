@if ($setting['onem']=='accounting' )
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
        </ul>
    </li> 
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
        </ul>                   
    </li> 
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
    <li>
        <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Budget</span> <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('budget') }}"><i class='fa fa-users'></i> <span>Capital</span></a></li>
            <li><a href="{{ url('budget') }}"><i class='fa fa-cogs'></i> <span>Revenue</span></a></li>
             <li><a href="{{ url('budget') }}"><i class='fa fa-cogs'></i> <span>Cash Flow</span></a></li>
            <li><a href="{{ url('budget') }}"><i class='fa fa-cogs'></i> <span>Special</span></a></li>
        </ul>                 
    </li>                 
    <li>
        <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Project</span> <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('acc-project') }}"><i class='fa fa-users'></i> <span>Project</span></a></li>
            <li><a href="{{ url('pplanning') }}"><i class='fa fa-cogs'></i> <span>Planning</span></a></li>
            <li><a href="{{ url('pbudget') }}"><i class='fa fa-cogs'></i> <span>Budget</span></a></li>
            <li><a href="{{ url('project') }}"><i class='fa fa-cogs'></i> <span>Actual Cost</span></a></li>
        </ul>                 
    </li>                 
    <li>
        <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>COA</span> <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('acccoa') }}"><i class='fa fa-users'></i> <span>COA</span></a></li>
            <li><a href="{{ url('coadetail') }}"><i class='fa fa-cogs'></i> <span>Details</span></a></li>
            <li><a href="{{ url('coacondition') }}"><i class='fa fa-cogs'></i> <span>Condition</span></a></li>
            <li><a href="{{ url('acccoa/report') }}"><i class='fa fa-cogs'></i> <span>COA Report</span></a></li>
        </ul>                 
    </li>                  
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
            <li><a href="{{ url('option/transaction/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
        </ul>                 
    </li>                
    <li>
        <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Report</span> <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('tranmaster/ledger') }}"><i class='fa fa-users'></i> <span>Ledger</span></a></li>
            <li><a href="{{ url('tranmaster/subhead') }}"><i class='fa fa-cogs'></i> <span>Subhead Ledger</span></a></li>
            <li><a href="{{ url('tranmaster/department') }}"><i class='fa fa-cogs'></i> <span>Department Ledger</span></a></li>
            <li><a href="{{ url('tranmaster/receiptpayment') }}"><i class='fa fa-cogs'></i> <span>Recipt and Payment</span></a></li>
            <li><a href="{{ url('tranmaster/cheqregister') }}"><i class='fa fa-cogs'></i> <span>Checque Register</span></a></li>
            <li><a href="{{ url('reconciliation/report') }}"><i class='fa fa-cogs'></i> <span>Reconciliation</span></a></li>
            <li><a href="{{ url('tranmaster/trialbalance') }}"><i class='fa fa-cogs'></i> <span>Trial Balance</span></a></li>
            <li><a href="{{ url('tranmaster/profitloss') }}"><i class='fa fa-cogs'></i> <span>Profit and Loss</span></a></li>
            <li><a href="{{ url('tranmaster/trading') }}"><i class='fa fa-cogs'></i> <span>Trading Account</span></a></li>
            <li><a href="{{ url('tranmaster/manufacturing') }}"><i class='fa fa-cogs'></i> <span>Manufacturing</span></a></li>
            <li><a href="{{ url('tranmaster/pldistribution') }}"><i class='fa fa-cogs'></i> <span>PL Distribution</span></a></li>
            <li><a href="{{ url('tranmaster/balancesheet') }}"><i class='fa fa-cogs'></i> <span>Balance Sheet</span></a></li>
        </ul>                 
    </li>
    <li>
        <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Inventory</span> <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('invenmaster') }}"><i class='fa fa-users'></i> <span>Inventory</span></a></li>
            <li><a href="{{ url('invenmaster/create?f=Receive') }}"><i class='fa fa-users'></i> <span>Receive</span></a></li>
            <li><a href="{{ url('invenmaster/create?f=Issue') }}"><i class='fa fa-cogs'></i> <span>Issue</span></a></li>
            <li><a href="{{ url('warehouse') }}"><i class='fa fa-cogs'></i> <span>Warehouse</span></a></li>
            <li><a href="{{ url('option/inventory/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
            <li><a href="{{ url('invenmaster/ledger') }}"><i class='fa fa-cogs'></i> <span>Ledger</span></a></li>
            <li><a href="{{ url('invenmaster/report') }}"><i class='fa fa-cogs'></i> <span>Receive and Issue</span></a></li>
            <li><a href="{{ url('invenmaster/stock') }}"><i class='fa fa-cogs'></i> <span>Stock</span></a></li>
            <li><a href="{{ url('option/inventory/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
        </ul>                 
    </li>                 
    <li>
        <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Audit</span> <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('tranmaster/checkby') }}"><i class='fa fa-users'></i> <span>Check</span></a></li>
            <li><a href="{{ url('tranmaster/approveby') }}"><i class='fa fa-cogs'></i> <span>Approve</span></a></li>
            <li><a href="{{ url('tranmaster/auditby') }}"><i class='fa fa-users'></i> <span>Audit</span></a></li>
            <li><a href="{{ url('audit/reply') }}"><i class='fa fa-cogs'></i> <span>Reply</span></a></li>
            <li><a href="{{ url('audit/final_action') }}"><i class='fa fa-cogs'></i> <span>Final Action</span></a></li>
            <li><a href="{{ url('audit/internal_report') }}"><i class='fa fa-cogs'></i> <span>Internal Audit Report</span></a></li>
            <li><a href="{{ url('option/audit/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
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