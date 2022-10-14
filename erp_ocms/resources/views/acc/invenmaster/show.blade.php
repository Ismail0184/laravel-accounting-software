@extends('app')

@section('htmlheader_title', 'Inventory')

@section('contentheader_title', 'Inventory')

@section('main-content')

<style>
	#field{ width:15%; text-align:right}
	#field_value{ width:35%;}
	#acc_id { width:50%; }
	#sl { width:15%;}
	
body {background: #EAEAEA;}
.user-details {position: relative; padding: 0;}
.user-details .user-image {position: relative;  z-index: 1; width: 100%; text-align: center;}
 .user-image img { clear: both; margin: auto; position: relative;}

.user-details .user-info-block {width: 100%; position: ; top: 55px; background: rgb(255, 255, 255); z-index: 0; padding-top: 0px;}
 .user-info-block .user-heading {width: 100%; text-align: left; margin: 10px 0 0;}
 .user-info-block .navigation {float: left; width: 100%; margin: 0; padding: 0; list-style: none; border-bottom: 1px solid #428BCA; border-right: 1px solid #428BCA; border-top: 1px solid #428BCA; background: rgb(255, 255, 255);}
  .navigation li {float: left; margin: 0; padding: 0;}
   .navigation li a {padding: 10px 30px; float: left;}
   .navigation li.active a {background: #428BCA; color: #fff;}
 .user-info-block .user-body {float: left; padding: 2%; width: 100%; background: rgb(255, 255, 255);  height:210px}
  .user-body .tab-content > div {float: left; width: 100%;}
  .user-body .tab-content h4 {width: 100%; margin: 10px 0; color: #333;}

</style>
<?php 
		
	Session::has('com_id') ? 
	$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
	$invenmaster->currency_id> 0 ? $currencys=$currency[$invenmaster->currency_id]: $currencys='' ;// echo $invenmaster->wh_id; 
	$invenmaster->check_id> 0 ? $user=$users[$invenmaster->check_id] : $user='';
	$wh=DB::table('acc_warehouses')->where('com_id',$com_id)->where('id', $invenmaster->wh_id)->first();
	$wh_name=''; isset($wh) && $wh->id > 0 ? $wh_name=$wh->name : $wh_name='';
	
	Session::put('ssitype', $invenmaster->itype); //echo $invenmaster->itype;
	
	$client=DB::table('acc_clients')->where('com_id',$com_id)->where('id',$invenmaster->client_id)->first();
	$client_name=''; isset($client) && $client->id> 0 ? $client_name=$client->name : $client_name='';
	$client_name=='' ? $client_name=$invenmaster->client.', '.$invenmaster->client_address : '';
	
	$option=DB::table('acc_options')->where('com_id',$com_id)->first();
	$cwh_id=''; isset($option) && $option->id > 0 ? $cwh_id=$option->cwh_id : $cwh_id='';
	$business=''; isset($option) && $option->id > 0 ? $business=$option->business : $business='';
	Session::put('sswh_id', $cwh_id);

?>
<div class="box">
        <div class="box-body" align="center">

   <div class="container" style="background:#9CF">
	<div class="row">
		<div class="user-details">
        	<!--{!! Form::open(['route' => 'trandetail.store', 'class' => 'form']) !!}-->
            <div class="user-info-block text-left">
                <div class="user-heading">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th id="field">{{ $langs['idate'] }}</th>
                            <td id="field_value">{{ $invenmaster->idate }}</td>
                             			<th id="field">{{ $langs['itype'] }}</th>
                            			<td id="field_value"><a href="{{ url('/invenmaster') }}">{{ $invenmaster->itype }}</a></td>
                        </tr>
                        <tr>
                            <th id="field">{{ $langs['vnumber'] }}</th>
                            <td>{{ $invenmaster->vnumber }}</td>
                            			<th id="field">{{ $langs['wh_id'] }}</th>
                            			<td>{{ $wh_name }}</td>
                        </tr>
                         <tr>
                            <th id="field">{{ $langs['person'] }}</th>
                           
                            <td>{{ $invenmaster->person }}</td>
                            			<th id="field">{{ $langs['client_id'] }}</th>
                            			<td>{{ $client_name }}</td>
                        </tr>
                        <?php $max_amount=9999999999999999999; $readonly='';$acc_id=''; ?>
                        @if($invenmaster->req_id > 0)
                        <tr>
                            <th id="field">{{ $langs['req_id'] }}</th>
                            <td>{{ $reqs[$invenmaster->req_id] }}</td>
                            <?php 
								$invenmaster->req_id>0 ?
								$req = DB::table('acc_prequisitions')->where('id',$invenmaster->req_id)->first() : ''; 
								empty($req) ? '' : $max_amount=$req->amount.','.$readonly='readonly'.','.$acc_id=$req->amount;
							?>
                            			<th id="field">{{ $langs['amount'] }}</th>
                            			<td>{{ $req->amount }}</td>
                        </tr>
                        @endif
                        <?php //echo $max_amount;?>
                    </table>
                    <h4>Inventory Details</h4>
                    
   			 <table class="table table-bordered">   
             	<tr>
                	<th class="text-center" id="sl">SL</th>
                    <th id="acc_id">{{ $langs['item_id'] }}</th>
                    <th class="text-right" colspan='2'>{{ $langs['qty'] }}</th>
                    <th class="text-right"></th>
                </tr>             
                  <?php

				  		//$units=array('1'=>'PCS', '2'=>'Dozen', '3'=>'Kg');
				  		$x=0; $ttl=0; //$currency='';
				  		
						$record = DB::table('acc_invendetails')->where('im_id', $invenmaster->id)->get(); 
						foreach($record as $value){

						$x++; $value->amount>0  ?  $ttl+=$value->amount : '';
						// produc find
						$product=''; $debit=''; $credit='';
						$value->qty<0 ? $value->qty=substr($value->qty, 1) : '';
						$value->item_id>0 ?
						$product = DB::table('acc_products')->where('com_id',$com_id)->where('id',$value->item_id)->first() : ''; 
						$product_name=''; isset($product) && $product->id > 0 ? $product_name=$product->name : $product_name=''; 
						$unit_id=''; isset($product) && $product->id > 0 ? $unit_id=$product->unit_id : $unit_id=''; 
						$unit=DB::table('acc_units')->where('id',$unit_id)->first();
						$unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name : $unit_name='';
						$value->amount>0 ? $debit=number_format($value->amount, 2) : $credit=number_format(substr($value->amount, 1), 2);
						

						$whs=DB::table('acc_warehouses')->where('com_id',$com_id)->where('id', $value->war_id)->first();
						$whs_name=''; isset($whs) && $whs->id > 0 ? $whs_name='/'.$whs->name : $whs_name='';
  					 	strlen($value->ref)==0 ? $ref='' : $ref=', '.$value->ref; 

						
							echo "
							<tr><td class='text-center'>$x</td><td>".$product_name.$whs_name.$ref."</td>
							<td class='text-right'>".$unit_name."</td><td class='text-right'>$value->qty</td>
							<td width='150px'>"; ?>
                            {!! Form::open(['route' => ['invendetail.destroy', $value->id], 'method' => 'DELETE']) !!}
                            {!! Form::hidden('im_id', $invenmaster->id) !!} 
                            {!! Form::submit($langs['delete'], ['class' => 'btn btn-danger pull-right btn-primary', 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}
                            <a class="btn btn-primary btn-primary pull-right" href="{{ URL::route('invendetail.edit', $value->id) }}">{{ $langs['edit'] }}</a>

                            <?php echo "</td></tr>"; 
						}
						$x++;
/*						if (!empty($record)):
							echo "<tr><td class='text-center'>".$x."</td><td>".$acccoa[$invenmaster->tranwith_id]."</td></td><td></td><td class='text-right'>".number_format($ttl)."</td><td width='150px'></td></tr>";
						endif;
*/				  ?>
                    
  			 </table>                 
 
                </div>
                <ul class="navigation">
                    <li class="active">
                        <a data-toggle="tab" href="#basic">
                            <span class="glyphicon glyphicon-record"> Basic</span>
                        </a>
                    </li>
                     <li>
                        <a data-toggle="tab" href="#extra">
                            <span class="glyphicon glyphicon-plus"> Extra</span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#export">
                            <span class="glyphicon glyphicon-plus"> Export</span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#project">
                            <span class="glyphicon glyphicon-plus"> Project</span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#producttion">
                            <span class="glyphicon glyphicon-plus"> Production</span>
                        </a>
                    </li>
                </ul>
                {!! Form::open(['route' => 'invendetail.store', 'class' => 'form-horizontal invenmaster']) !!}
                <div class="user-body">
                    <div class="tab-content">
                        <!-- Basic--> 
                        <div id="basic" class="tab-pane active" >
                               <div class="form-group">
                                    <a href="{{ url('product') }}"><span class="glyphicon glyphicon-plus"></span></a>
                                    {!! Form::label('item_id', $langs['item_id'], ['class' => 'col-sm-3 control-label','required']) !!}
                                    <div class="col-sm-6"> 
                                        {!! Form::select('item_id', $products, $acc_id, ['class' => 'form-control select2', 'required', ]) !!}
                                    </div>    
                                </div>

                               <div class="form-group">
                                    {!! Form::label('qty', $langs['qty'], ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-6"> 
                                       {!! Form::text('qty', null, ['class' => 'form-control', 'required', 'max'=>$max_amount, 'id'=>'qty']) !!}
                                       {!! Form::hidden('wh_id123', $invenmaster->wh_id) !!} 
			                           {!! Form::hidden('max_qty', null, ['class' => 'form-control', 'required','id'=>'max_qty']) !!}

                                    </div>    
                                </div>
								@if($business=='General')
                                <div class="form-group">
                                    {!! Form::label('for', $langs['for'], ['class' => 'col-sm-3 control-label']) !!}
                                    <a href="{{ url('ittype') }}"><span class="glyphicon glyphicon-plus"></span></a>
                                    <div class="col-sm-6"> 
                                       {!! Form::select('for', $ittypes ,null, ['class' => 'form-control', ]) !!}
                                    </div>    
                                </div>
                                @else
                                <div class="form-group">
                                    {!! Form::label('ref', $langs['ref'], ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-6"> 
                                       {!! Form::text('ref', null, ['class' => 'form-control', ]) !!}
                                    </div>    
                                </div>
								@endif
                        </div>
						<!-- LC info--> 
                        <div id="extra" class="tab-pane">
								<div class="form-group">
                                    {!! Form::label('rate', $langs['rate'], ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-6"> 
                                       {!! Form::text('rate', null, ['class' => 'form-control', ]) !!}
                                    </div>    
                                </div>
                                <div class="form-group">
                                    {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-6"> 
                                     {!! Form::hidden('im_id', $invenmaster->id) !!} 
                                     {!! Form::hidden('itype', $invenmaster->itype,['class' => 'form-control', 'id'=>'itype']) !!} 
                                       {!! Form::text('amount', null, ['class' => 'form-control', 'max'=>$max_amount]) !!}
                                    </div>    
                                </div>
<!--                                <div class="form-group">
                                    {!! Form::label('wh_id', $langs['wh_id'], ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-6"> 
                                        {!! Form::select('wh_id', $warehouses ,$cwh_id, ['class' => 'form-control', 'required', 'maxlength'=>60]) !!}
                                    </div>    
                                </div>-->
                                <div class="form-group">
                                    {!! Form::label('war_id', $langs['war_id'], ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-6"> 
                                       {!! Form::select('war_id', $warehouses, $cwh_id, ['class' => 'form-control']) !!}
                                    </div>    
                                </div>                                
                        </div>
    						<!-- LC info--> 
                        <div id="export" class="tab-pane">
                            <div class="form-group">
                                {!! Form::label('lc_id', $langs['lc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('lc_id', $lcs, null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('ord_id', $langs['ord_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('ord_id', $ords, null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('stl_id', $langs['stl_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('stl_id', $stls, null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>

                            
                        </div>
                        <!-- Project-->    
                        <div id="project" class="tab-pane">
                            <div class="form-group">
                                {!! Form::label('pro_id', $langs['pro_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('pro_id', $project, null, ['class' => 'form-control', 'id'=> 'pro_id']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('seg_id', $langs['seg_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select ('seg_id', array(),  null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('accid', $langs['accid'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('accid', $acccoa, null, ['class' => 'form-control select2']) !!}
                                </div>    
                            </div>
                                    
                        </div>
						<!-- Production-->                       
						<div id="producttion" class="tab-pane">
                            <div class="form-group">
                                {!! Form::label('prod_id', $langs['prod_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('prod_id', $products, null, ['class' => 'form-control select2']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('batch', $langs['batch'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('batch', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
<!--                            <div class="form-group">
                                {!! Form::label('wh_id', $langs['wh_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                   {!! Form::select('wh_id', $warehouses, null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>                                
-->
                        </div>
                        
                    </div>
                    <!-- Condition-->                       
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                {!! Form::submit($langs['create'], ['class' => 'btn btn-primary form-control']) !!}
                            </div>    
                        </div>

                </div>
                {!! Form::close() !!}
            </div>

            <div style="background:"; >
    		{!! Form::model($invenmaster, ['route' => ['invenmaster.update', $invenmaster->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}
 					<br>
                    <div class="form-group">
                        {!! Form::label('note', $langs['note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::textarea('note', null, ['class' => 'form-control', 'required','size' => '5x3']) !!}
                            {!! Form::hidden('amount', $ttl, ['class' => 'form-control', 'required', 'readonly']) !!}
                        </div>    
                    </div>  
                    <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                {!! Form::submit($langs['save'], ['class' => 'btn btn-primary form-control']) !!}
                            </div>    
                    </div>                    
    		{!! Form::close() !!}
           
        </div>

</div>
 
                 
                    
</div>
		</div>
</div>


@endsection
@section('custom-scripts')

<script>
var x = document.getElementById("amount");
x.addEventListener("focus", myFocusFunction, true);

function myFocusFunction() {
    document.getElementById("amount").value = document.getElementById("qty").value*document.getElementById("rate").value;  
}

 jQuery(document).ready(function($) {        
        $(".invenmaster").validate();
		$(".form").validate();
		$("#pro_id").change(function() {
            $.getJSON("{{ url('pbudget/segment')}}/" + $("#pro_id").val(), function(data) {
                var $courts = $("#seg_id");
                $courts.empty();
                $.each(data, function(index, value) {
                    $courts.append('<option value="' + index +'">' + value + '</option>');
                });
            $("#seg_id").trigger("change");
            });
        });
		
		 $("#lc_id").change(function() {
            $.getJSON("{{ url('tranmaster/order')}}/" + $("#lc_id").val(), function(data) {
                var $courts = $("#ord_id");
                $courts.empty();
                $.each(data, function(index, value) {
                    $courts.append('<option value="' + index +'">' + value + '</option>');
                });
            $("#ord_id").trigger("change");
            });
        });
		
		 $("#ord_id").change(function() {
            $.getJSON("{{ url('tranmaster/style')}}/" + $("#ord_id").val(), function(data) {
                var $courts = $("#stl_id");
                $courts.empty();
                $.each(data, function(index, value) {
                    $courts.append('<option value="' + index +'">' + value + '</option>');
                });
            $("#stl_id").trigger("change");
            });
        });

		$("#qty").on('input', function() {
			 var $max_qty = parseInt($("#max_qty").val());
			 var $courts = parseInt($("#qty").val());
			 var $itype = $("#itype").val();
			if ($itype=='Issue'){
				if ($courts > $max_qty){
					alert('Exit Limit, Stock Balance is '+$("#max_qty").val());
					$('#qty').val("");}
			}
		});    

		 $("#item_id").change(function() {
            $.getJSON("{{ url('invenmaster/qty')}}/" + $("#item_id").val(), function(data) {
                var $courts = $("#max_qty");
                $courts.empty();
                $.each(data, function(index, value) {
					$courts.val(value);
                });
            });
        });


    });

</script>

@endsection