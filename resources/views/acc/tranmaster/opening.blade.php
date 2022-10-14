@extends('app')

@section('htmlheader_title', 'Purchasemaster')

@section('contentheader_title', 'Transaction')

@section('main-content')
<style>
	#field{ width:15%; text-align:right}
	#field_value{ width:35%;}
	#acc { width:50%; }
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
 .user-info-block .user-body {float: left; padding: 2%; width: 100%; background: rgb(255, 255, 255);  height:220px}
  .user-body .tab-content > div {float: left; width: 100%;}
  .user-body .tab-content h4 {width: 100%; margin: 10px 0; color: #333;}
  
</style>
<?php 
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	
	$months=array(''=>'Select ...', 1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');

	$currency=$currency[$tranmaster->currency_id];// echo $currency; 
	
	$company=array('' => 'Select ...', 0 => 'Order Chain Management System'); 
	
	$blance=DB::table('acc_trandetails')->where('com_id',$com_id)->where('acc_id', $tranmaster->tranwith_id)->sum('amount'); $blance=number_format($blance);
	$option=DB::table('acc_options')->where('com_id',$com_id)->first();
	$maincash=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Main Cash')->first();
	isset($maincash) && $maincash->id > 0 ? $maincash_id=$maincash->id : $maincash_id='';
	$tran_with=DB::table('acc_coas')->where('com_id',$com_id)->where('id',$tranmaster->tranwith_id)->first(); 
	$tran_with_name=''; isset($tran_with) && $tran_with->id > 0 ? $tran_with_name=$tran_with->name : $tran_with_name='';
?>
<div class="box">
   <div class="box-body" align="center">
   <div class="container" style="background:#9CF">
	<div class="row">
		<div class="user-details">
        	<!--{!! Form::open(['route' => 'trandetail.store', 'class' => 'form']) !!}-->
            <div class="user-info-block text-left">
                <div class="user-heading">
                    <table class="table table-bordered " >
                        <tr>
                            <th id="field">{{ $langs['tdate'] }}</th>
                            <td id="field_value">{{ $tranmaster->tdate }}</td>
                             			<th id="field"><a href="{{ url('/tranmaster') }}">{{ $langs['ttype'] }}</a> </th>
                            			<td id="field_value">{{ $tranmaster->ttype }}</td>
                        </tr>
                        <tr>
                            <th id="field">{{ $langs['vnumber'] }}</th>
                            <td><a href="{{ url('/tranmaster/voucher', $tranmaster->id) }}">{{ $tranmaster->vnumber }}</a></td>
                            			<th id="field">{{ $langs['currency_id'] }}</th>
                            			<td>{{ $currency }}</td>
                        </tr>
                         <tr>
                            <th id="field">{{ $langs['person'] }}</th>
                            <td>{{ $tranmaster->person }}</td>
                            			<th id="field">{{ $langs['tranwith_id'] }}</th>
                            			<td>{{ $tran_with_name }} ({{ $blance }})</td>
                        </tr>
                        <?php 
						//DB::table('acc_coas1')->get();
						$tranmaster->ttype=='Payment' && $tranmaster->tranwith_id==$maincash_id ?
						$max_amount= $option->max_pay : $max_amount=9999999999999999999; //echo $max_amount;
						
						$readonly='';$acc_id=''; 
						$requistion=DB::table('acc_prequisitions')->where('com_id',$com_id)->where('id',$tranmaster->req_id)->first();
						$requistions=''; isset($requistion) && $requistion->id > 0 ? $requistions=$requistion->name : $requistions='';
						
						?>
                        @if($tranmaster->req_id > 0)
                        <tr>
                            <th id="field">{{ $langs['req_id'] }}</th>
                            <td>{{ $requistions }}</td>
                            <?php 
								$tranmaster->req_id>0 ?
								$req = DB::table('acc_prequisitions')->where('com_id',$com_id)->where('id',$tranmaster->req_id)->first() : ''; 
								if (!empty($req)):
									$max_amount=$req->ramount;
									$readonly='readonly'; 
									$acc_id=$req->acc_id;
								endif;
								$req->ramount>0 ? $req->ramount=number_format($req->ramount,2) : '';
							?>
                            			<th id="field">{{ $langs['ramount'] }}</th>
                            			<td>{{ $req->ramount }}</td>
                        </tr>
                        @endif
                        <?php //echo $max_amount;?>
                    </table>
                    <h4 style="padding:0px; margin:0px">Transaction Details</h4>
                    
   			 <table class="table table-bordered">   
             	<tr>
                	<th class="text-center" id="sl">SL</th>
                    <th id="acc">Account Head</th>
                    <th class="text-right" >Debit</th>
                    <th class="text-right" >Credit</th>
                    <th class="text-right"></th>
                    
                </tr>             
                  <?php

				  		$x=0; $ttl=0; //$currency='';
				  		
						$record = DB::table('acc_trandetails')->where('com_id',$com_id)->where('tm_id', $tranmaster->id)->get(); 
						foreach($record as $value){

						$x++; $value->amount>0  ?  $ttl+=$value->amount : '';
						// produc find
						$product=''; $debit=''; $credit='';
	
						$value->acc_id>0 ?
						$coa = DB::table('acc_coas')->where('com_id',$com_id)->where('id',$value->acc_id)->first() : ''; 
						isset($coa) && $coa->id>0  ? $acc_head=$coa->name : $acc_head='' ; 
						
						$subhead=''; //echo $value->sh_id;
						$value->sh_id>0 ? 
						$subhead = DB::table('acc_subheads')->where('com_id',$com_id)->where('id',$value->sh_id)->first(): '';
						$subhead=='' ? '' : $acc_head = $acc_head.', '.$subhead->name; 

						$dep='';
						$value->dep_id>0 ? 
						$dep = DB::table('acc_departments')->where('com_id',$com_id)->where('id',$value->dep_id)->first(): '';
						$dep=='' ? '' : $acc_head = $acc_head.', '.$dep->name; 

						$value->c_number!='' ? $acc_head = $acc_head.', '.$value->c_number : ''; 
						$value->b_name!='' ? $acc_head = $acc_head.', '.$value->b_name : ''; 
						$value->c_date!='0000-00-00' ? $acc_head = $acc_head.', '.$value->c_date : ''; 
												
						$value->m_id>0 ? $m_name=$months[$value->m_id] : $m_name='';
						$m_name!='' ? $acc_head = $acc_head.', for '.$m_name.'-'. $value->year : '';
						
						$value->amount>0 ? $debit=number_format($value->amount, 2) : $credit=number_format(substr($value->amount, 1), 2);
							echo "<tr><td class='text-center'>$x</td><td>$acc_head</td>
							<td class='text-right'>".$debit."</td><td class='text-right'>".$credit."</td>
							<td width='150px'>"; ?>
                            {!! Form::open(['route' => ['trandetail.destroy', $value->id], 'method' => 'DELETE']) !!}
                            {!! Form::hidden('tm_id', $tranmaster->id) !!} 
                            @if($value->flag==0)
                            {!! Form::submit($langs['delete'], ['class' => 'btn btn-danger pull-right btn-primary', 'onclick' => 'return confirm("Are you sure?");']) !!}
                            @endif
                            {!!  Form::close() !!}
                            @if($value->flag==0)
                            <a class="btn btn-primary btn-primary pull-right" href="{{ URL::route('trandetail.edit', $value->id) }}">{{ $langs['edit'] }}</a>
							@endif
                            <?php echo "</td></tr>"; 
						} 
						$x++;
/*						if (!empty($record)):
							echo "<tr><td class='text-center'>".$x."</td><td>".$acccoa[$tranmaster->tranwith_id]."</td></td><td></td><td class='text-right'>".number_format($ttl)."</td><td width='150px'></td></tr>";
						endif;
*/				  
							//echo $max_amount;
							?>
                    
  			 </table>                 
 
                </div>
                <ul class="navigation">
                    <li class="active">
                        <a data-toggle="tab" href="#information">
                            <span class="glyphicon glyphicon-record"> Basic</span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#extra">
                            <span class="glyphicon glyphicon-plus"> Extra </span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#bank">
                            <span class="glyphicon glyphicon-plus"> Bank </span>
                        </a>
                    </li>
					<li>
                        <a data-toggle="tab" href="#export">
                            <span class="glyphicon glyphicon-plus"> Export</span>
                        </a>
                    </li>
					<li>
                        <a data-toggle="tab" href="#import">
                            <span class="glyphicon glyphicon-plus"> Import</span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#project">
                            <span class="glyphicon glyphicon-plus"> Project</span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#syster">
                            <span class="glyphicon glyphicon-plus"> Transfer</span>
                        </a>
                    </li>
                </ul>
                {!! Form::open(['route' => 'trandetail.store', 'class' => 'form-horizontal tranmaster']) !!}
                <div class="user-body">
                    <div class="tab-content">
                        <!-- Basic--> 
                        <div id="information" class="tab-pane active" >
                               <div class="form-group">
                                    {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                    <a href="{{ URL::route('acccoa.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                                    <div class="col-sm-6"> 
                                        {!! Form::select('acc_id', $acccoa, $acc_id, ['class' => 'form-control select2', 'required', $readonly , 'id' => 'acc_id']) !!}
                                    </div>    
                                </div>

                               <div class="form-group">
                                    {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-6"> 
                                     {!! Form::hidden('ttype', $tranmaster->ttype) !!}
                                     {!! Form::hidden('tm_id', $tranmaster->id) !!} 
                                     {!! Form::hidden('tranwiths_id', $tranmaster->tranwith_id) !!} 
                                     {!! Form::text('amount', null, ['class' => 'form-control', 'required', 'max'=>$max_amount]) !!}
                                    </div>    
                                </div>
                                <div class="form-group">
                                    {!! Form::label('sh_id', $langs['sh_id'], ['class' => 'col-sm-3 control-label']) !!}
                                    <a href="{{ URL::route('subhead.create') }}"><span class="glyphicon glyphicon-plus"></span></a>
                                    <div class="col-sm-6"> 
                                        {!! Form::select('sh_id', $sh, null, ['class' => 'form-control select2']) !!}
                                    </div>    
                                </div>
                        </div>
						<!-- Extra info--> 
                        <div id="extra" class="tab-pane vv">
                            <div class="form-group">
                                {!! Form::label('dep_id', $langs['dep_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <a href="{{ URL::route('department.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                                <div class="col-sm-6"> 
                                    {!! Form::select('dep_id', $departments ,null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('m_id', $langs['m_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('m_id', $months,null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('year', $langs['year'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('year', date('Y'), ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                        </div>                          
						<!-- Bank info--> 
                        <div id="bank" class="tab-pane">
                            <div class="form-group">
                                {!! Form::label('c_number', $langs['c_number'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('c_number', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('b_name', $langs['b_name'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('b_name', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('c_date', $langs['c_date'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('c_date', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                        </div>                          

                        <!-- LC info--> 
                        <div id="export" class="tab-pane">
                            <div class="form-group">
                                {!! Form::label('lc_id', $langs['lc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <a href="{{ URL::route('lcinfo.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                                <div class="col-sm-6"> 
                                    {!! Form::select('lc_id', $lcs, null, ['class' => 'form-control', 'id' => 'lc_id']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('ord_id', $langs['ord_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <a href="{{ URL::route('orderinfo.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                                <div class="col-sm-6"> 
                                    {!! Form::select('ord_id', $ords, null, ['class' => 'form-control' , 'id' => 'ord_id']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('stl_id', $langs['stl_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <a href="{{ URL::route('style.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                                <div class="col-sm-6"> 
                                    {!! Form::select('stl_id', $stls, null, ['class' => 'form-control', 'id' => 'stl_id']) !!}
                                </div>    
                            </div>
                        </div>
 
                        <!-- Import info--> 
                        <div id="import" class="tab-pane">
                            <div class="form-group">
                                {!! Form::label('ilc_id', $langs['ilc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <a href="{{ URL::route('lcimport.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                                <div class="col-sm-6"> 
                                    {!! Form::select('ilc_id', $ilcs, null, ['class' => 'form-control', 'id' => 'ilc_id']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('accid', $langs['accid'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('accid', $acccoa, null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                        </div>

						<!-- Project-->    
                        <div id="project" class="tab-pane">
                            <div class="form-group">
                                {!! Form::label('pro_id', $langs['pro_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <a href="{{ URL::route('acc-project.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
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
                                {!! Form::label('prod_id', $langs['prod_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('prod_id', $products, null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                                    
                        </div>
						<!-- Condition-->                       
						<div id="syster" class="tab-pane">
                            <div class="form-group">
                                {!! Form::label('sis_id', $langs['sis_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('sis_id', $sisters, null, ['class' => 'form-control','id'=>'sis_id']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('sis_accid', $langs['sis_accid'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('sis_accid', array(), null, ['class' => 'form-control select2','id'=>'sis_accid']) !!}
                                </div>    
                            </div>
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
    		{!! Form::model($tranmaster, ['route' => ['tranmaster.update', $tranmaster->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}
 					<br>
                    <div class="form-group">
                        {!! Form::label('note', $langs['note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::textarea('note', null, ['class' => 'form-control', 'required','size' => '5x3', 'id'=>'naote']) !!}
                            {!! Form::hidden('notes', null, ['class' => 'form-control', 'id'=>'naotes']) !!}
                            {!! Form::hidden('tmamount', $ttl, ['class' => 'form-control', 'required', 'readonly']) !!}
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
var x = document.getElementById("note");

x.addEventListener("keydown", myFocusFunction, true);
x.addEventListener("keyup", myFocusFunction, true);

function myFocusFunction() {
    document.getElementById("notes").value = document.getElementById("note").value;  
}

</script>
<script>
jQuery(document).ready(function($) {        
        $(".tranmaster").validate();
		$(".form").validate();
		$( "#c_date" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		$( "#ndate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		
		$("#acc_id").change(function() {
            $.getJSON("{{ url('tranmaster/coacon')}}/" + $("#acc_id").val(), function(data) {
                var $courts = $("#lc_id");
                $courts.empty();
                $.each(data, function(index, value) {
                    $courts.append('<option value="' + index +'">' + value + '</option>');
                });
            $("#lc_id").trigger("change");
            });
        });
		
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
		
		$("#sis_id").change(function() {
            $.getJSON("{{ url('tranmaster/sis_acc')}}/" + $("#sis_id").val(), function(data) {
                var $courts = $("#sis_accid");
                $courts.empty();
                $.each(data, function(index, value) {
                    $courts.append('<option value="' + index +'">' + value + '</option>');
                });
            $("#sis_accid").trigger("change");
            });
        });

    });
</script>

@endsection