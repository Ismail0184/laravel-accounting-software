<li class="dropdown">
<a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Order Information</span> <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="'dashboard/coming"><i class='fa fa-users'></i> <span>Buyer</span></a></li>
        <li><a href="dashboard/coming'"><i class='fa fa-cogs'></i> <span>Order Info</span></a></li>
        <li><a href="dashboard/coming'"><i class='fa fa-cogs'></i> <span>Color & Size</span></a></li>
        <li><a href="dashboard/coming'"><i class='fa fa-cogs'></i> <span>Fabrication</span></a></li>
        <li><a href="dashboard/coming'"><i class='fa fa-cogs'></i> <span>Yarn</span></a></li>
        <li><a href="dashboard/coming'"><i class='fa fa-cogs'></i> <span>Print & Embroidery</span></a></li>
        <li><a href="dashboard/coming'"><i class='fa fa-cogs'></i> <span>Trims</span></a></li>
        <li><a href="dashboard/coming'"><i class='fa fa-cogs'></i> <span>Other</span></a></li>
        <li><a href="dashboard/coming"><i class='fa fa-cogs'></i> <span>Costsheet</span></a></li>
        <li><a href="dashboard/coming"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
    </ul>
</li> 
<li class="dropdown">
    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Work Order</span> <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ url('supplier') }}"><i class='fa fa-users'></i> <span>Trims</span></a></li>
        <li><a href="{{ url('lcimport') }}"><i class='fa fa-cogs'></i> <span>Print</span></a></li>
        <li><a href="{{ url('product') }}"><i class='fa fa-cogs'></i> <span>Embroidery</span></a></li>
        <li><a href="{{ url('importmaster') }}"><i class='fa fa-cogs'></i> <span>AOP</span></a></li>
        <li><a href="{{ url('importmaster/costsheet') }}"><i class='fa fa-cogs'></i> <span>Finishing</span></a></li>
        <li><a href="{{ url('importmaster/ledger') }}"><i class='fa fa-cogs'></i> <span>Washing</span></a></li>
        <li><a href="{{ url('importmaster/ledger') }}"><i class='fa fa-cogs'></i> <span>Finish Fabric</span></a></li>
        <li><a href="{{ url('importmaster/ledger') }}"><i class='fa fa-cogs'></i> <span>Knitting</span></a></li>
        <li><a href="{{ url('importmaster/ledger') }}"><i class='fa fa-cogs'></i> <span>Yarn Dyeing</span></a></li>
        <li><a href="{{ url('importmaster/ledger') }}"><i class='fa fa-cogs'></i> <span>Yarn</span></a></li>
        <li><a href="{{ url('importmaster/ledger') }}"><i class='fa fa-cogs'></i> <span>Sample</span></a></li>
        <li><a href="{{ url('importmaster/ledger') }}"><i class='fa fa-cogs'></i> <span>Yarn Requisition</span></a></li>
        <li><a href="{{ url('option/import/'.$option_id) }}"><i class='fa fa-cogs'></i> <span>Option</span></a></li>
    </ul>
</li> 
<li class="dropdown">
    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Sample</span> <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ url('client') }}"><i class='fa fa-users'></i> <span>Sample</span></a></li>
    </ul>                   
</li> 
<li>
    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Check And Approval</span> <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ url('client') }}"><i class='fa fa-users'></i> <span>Check</span></a></li>
        <li><a href="{{ url('product') }}"><i class='fa fa-cogs'></i> <span>Approve</span></a></li>
    </ul>                 
</li> 
<li>
    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Short</span> <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ url('acccoa') }}"><i class='fa fa-users'></i> <span>Fabric</span></a></li>
        <li><a href="{{ url('coadetail') }}"><i class='fa fa-cogs'></i> <span>Trim</span></a></li>
    </ul>                 
</li>                  
<li>
    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Marketing</span> <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ url('prequisition') }}"><i class='fa fa-users'></i> <span>Marketing</span></a></li>
    </ul>                 
</li>                
<li>
    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Report</span> <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ url('tranmaster/ledger') }}"><i class='fa fa-users'></i> <span>Order List</span></a></li>
    </ul>                 
</li>
<li>
    <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Library</span> <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ url('tranmaster/ledger') }}"><i class='fa fa-users'></i> <span>Order</span></a></li>
        <li><a href="{{ url('tranmaster/ledger') }}"><i class='fa fa-users'></i> <span>Fabrication</span></a></li>
        <li><a href="{{ url('tranmaster/ledger') }}"><i class='fa fa-users'></i> <span>Work Order</span></a></li>
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
