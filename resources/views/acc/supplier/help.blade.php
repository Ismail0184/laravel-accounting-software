@extends('app')

@section('contentheader_title', 'COA')

@section('main-content')

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
<p>Accounting Modules
Purpose of the module is to manage accounts department professionally. There are strong user access securities with different level permission and auto remote server backup system. After normal transaction entry, related reports like ledger, trial balance, profit and loss, and Balance Sheet and so on will be generated automatically.  Minimum skilled requited to operate it. Requisition for purchase and fund is required to make transaction. After making any transaction, necessary check and approval system are applied here. Pre-message Alert on different events like post dated check, due payment, due collection will be given to related concern automatically. And auto mailing system to management with various reports is available in this module. Following sub-modules are included to manage accounting comprehensively. 
Export: Export-oriented transactions with details information, like country-wise export, buyer-wise export, and product-wise export report are generated from here. LC-wise and order-wise process cost will be built in this section.
Import: Main purpose of this module is to calculate import LC-wise cost along with per unit cost of imported products. Country-wise import volume, supplier-wise import volume, product-wise import volume. 
Purchase: All local purchase and auto connection with transaction and inventory 
Sale: Total local sale solution. Retail sale, dealer and whole sale, marketing team based target sale with incentive, commission and incentive on dealer target sale. Live stock quantity update and stock value. Sales report marketing team-wise, client-wise, dealer-wise and product-wise. 
Please note that calculation of cost of sale and stock value is formulated by weight-average-method (according to running stock) automatically.  
Budget: Budgetary control for revenue, capital and cash flow. Report for comparative statement of actual cost with budget integrated here.
Project: Project, planning, budget and compare with actual cost 
Transaction: All transaction of cash, bank and journal are operated from here. This is the main part of accounting software.  Department-wise transaction, Project-wise transaction and import Lc-wise transaction if necessary. 
Report: Important accounts reports are listed here. Please note that, maximum reports are added in their respective sub-modules. Report of Account-wise ledger, Subhead ledger and department-wise ledger are available here. Trail Balance, Receipt and Payment, Profit and loss, Trading, Profit and loss distribution Account, Balance Sheet are also available.
Inventory: Actually, this is a part of sale and purchase module. Inventory will be auto updated according to import, purchase and sale action. Daily receipt and issue report, product-wise ledger report, current stock balance, warehouse-wise stock balance. 
Audit: From the software, how auditor can work? This is for Internal Audit system like audit check, required explanation and audit claim along with Internal Audit Report.
This is a managerial accounting system. Graphical presentation, check and approval for data transaction, auto message and email alert system integrated. So this is not book-keeping level software. 
</p>      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#acccoa-table").dataTable({
    		"aoColumns": [ null, null, { "bSortable": false }, { "bSortable": false } ] 
    	});
    } );
</script>

@endsection
