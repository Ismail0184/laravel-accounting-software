@extends('app')

@section('htmlheader_title', 'Purchasemaster')

@section('contentheader_title', 'Purchase')

@section('main-content')
<style>
	#field{ width:150px; text-align:right}
	#unit, #currency { width:30px}
	#sl { width:150px;}
</style>
<?php 
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$clients = DB::table('acc_clients')->where('com_id',$com_id)->where('id',$purchasemaster->client_id)->first(); 
		$client=''; isset($clients) && $clients->id > 0 ? $client=$clients->name : $client='';
		$client_acc_id=''; isset($clients) && $clients->acc_id > 0 ? $client_acc_id=$clients->acc_id : $client_acc_id=''; //echo $client_acc_id;
		
		$purchasemaster->client_id==0 ? $client=$purchasemaster->client : '';
		$purchasemaster->client_id==0 ? $required='required' : $required='';
		$client_address=''; isset($clients) && $clients->id > 0 ? $client_address=$clients->address1 : $client_address='';
		$purchasemaster->client_id==0 ? $client_address=$purchasemaster->client_address : '';
		
?>
<div class="box">
        <div class="box-header">
            <a href="{{ url('purchasemaster/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
<!--            <a href="{{ url('purchasemaster/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('purchasemaster/pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('purchasemaster/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('purchasemaster/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('purchasemaster/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
-->        </div><!-- /.box-header -->
        <div class="box-body" align="center">
                <div class="table-responsive" style=" width:90%" >
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th id="field">{{ $langs['pdate'] }}</th>
                            <td>{{ $purchasemaster->pdate }}</td>
                        </tr>
                        <tr>
                            <th id="field">{{ $langs['invoice'] }}</th>
                            <td>{{ $purchasemaster->invoice }}</td>
                        </tr>
                         <tr>
                            <th id="field">{{ $langs['client_id'] }}</th>
                            <td>{{ $client }}</td>
                        </tr>
                         <tr>
                            <th id="field">{{ $langs['client_address'] }}</th>
                            <td>{{ $client_address }}</td>
                        </tr>
                    </table>
                    
   			 <table class="table table-bordered">   
             	<tr>
                	<th class="text-center" id="sl">SL</th>
                    <th>Product</th>
                    <th class="text-right" colspan="2">Quantity</th>
                    <th class="text-right" colspan="2">Rate</th>
                    <th class="text-right" colspan="2">Amount</th>
                    <th class="text-right"></th><th class="text-right"></th>
                    
                </tr>             
                  <?php
				  		$currency='Tk'; //s=array('1'=>'USD', '2'=>'EURO', '3'=>'Taka');
				  		$units=array('1'=>'PCS', '2'=>'Dozen', '3'=>'Kg');
				  		$x=0; $ttl=0; //$currency='';
				  		$record = DB::table('acc_purchasedetails')->where('pm_id', $purchasemaster->id)->get(); 
						
						foreach($record as $item):
						//$item->currency_id > 0 ? $currency=$currencys[$item->currency_id] : $currency='';
						$x++; $ttl+=$item->amount;

							$product = DB::table('acc_products')->where('id',$item->item_id)->first(); 
							$product_name=''; isset($product) && $product->id > 0 ? $product_name=$product->name : $product_name='';
							$unit_id=''; isset($product) && $product->id > 0 ? $unit_id=$product->unit_id : $unit_id='';

							$units = DB::table('acc_units')->where('id',$unit_id)->first(); 
							$unit=''; isset($units) && $units->id > 0 ? $unit=$units->name : $unit='';
							
							echo "<tr><td class='text-center'>$x</td><td>$product_name</td>
							<td class='text-right'>$item->qty</td><td id='unit'>".$unit."</td>
							<td class='text-right'>".number_format($item->rate,2)."</td><td id='currency'>".$currency."</td>
							<td class='text-right'>".number_format($item->amount)."</td><td id='currency'>".$currency."</td>
							"; ?>
                            <td width="40px"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('purchasedetail.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td>
                            {!! Form::open(['route' => ['purchasedetail.destroy', $item->id], 'method' => 'DELETE']) !!}
                            <td width="40px">{!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}</td>
                            {!!  Form::close() !!}
                            

                            <?php echo "</tr>";  
						endforeach;
						echo "<tr><td colspan='6' class='text-right'>Total</td><td class='text-right'>".number_format($ttl)."</td>
						<td id='currency'>".$currency."</td><td></td><td></td></tr>";

				  ?>
                    
  			 </table>                 
                    
{!! Form::open(['route' => 'purchasedetail.store', 'class' => 'form']) !!}
 <div style="background-color:#0F9">
   
   <table class="table table-bordered">
   				<tr><td>
					<div class="form-group">
                        {!! Form::label('item_id', $langs['item_id']) !!}
                            {!! Form::select('item_id', $productz, null, ['class' => 'form-control', 'required', 'style' => 'width: 200px;']) !!}
                            
                    </div>
   				</td><td>
					<div class="form-group">
                        {!! Form::label('qty', $langs['qty']) !!}
                            {!! Form::text('qty', null, ['class' => 'form-control', 'required', 'id'=>'qty', 'style' => 'width: 150px']) !!}
                    </div>

     			</td><td>                
					<div class="form-group">
                        {!! Form::label('rate', $langs['rate']) !!}
                            {!! Form::text('rate', null, ['class' => 'form-control', 'required', 'id'=>'rate', 'style' => 'width: 150px']) !!}
                    </div>
	 			</td><td>
                	<div class="form-group">
                    	{!! Form::hidden('pm_id', $purchasemaster->id) !!} 
                    	{!! Form::hidden('war_id', $purchasemaster->wh_id) !!} 
                        {!! Form::label('amount', $langs['amount']) !!}
                            {!! Form::text('amount', null, ['class' => 'form-control', 'required', 'id'=>'amount', 'style' => 'width: 150px']) !!}
                    </div>
 				</td><td>

                    <div class="form-group">
                        <div class=""><br>
                            {!! Form::submit($langs['create'], ['class' => 'btn btn-primary form-control']) !!}
                        </div>    
                    </div>
                </td></tr>
    </table>
    {!! Form::close() !!}
</div>
    <?php $purchasemaster->client_id>0 ? $readonly='' : $readonly='readonly';  ?>          
    {!! Form::model($purchasemaster, ['route' => ['purchasemaster.update', $purchasemaster->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

	<table  class="table table-bordered">
        <tr><td>
					<div class="form-group">
                        {!! Form::label('note', $langs['note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('note', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
    	</td></tr>
        <tr><td>
					<div class="form-group">
                        {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('amount', $ttl, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
        </td></tr><tr><td>
         			<div class="form-group" >
                        {!! Form::label('discount', $langs['discount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('discount', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>

        </td></tr><tr><td>
					<div class="form-group">
                        {!! Form::label('vat_tax', $langs['vat_tax'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('vat_tax', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
        </td></tr><tr><td>
					<div class="form-group">
                        {!! Form::label('transport', $langs['transport'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('transport', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
        </td></tr><tr><td>
					<div class="form-group">
                        {!! Form::label('other', $langs['other'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('other', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
        </td></tr><tr><td>
					<?php $purchasemaster->paid==0 && $client_acc_id==0 ? $paid=$ttl : $paid=$purchasemaster->paid;  ?>
     				<div class="form-group">
                        {!! Form::label('paid', $langs['paid'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('paid', $paid, ['class' => 'form-control',$readonly] ) !!}
                        </div>    
                    </div>
        </td></tr>
        <tr><td>
					<div class="form-group">
                        {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('acc_id', $coa,null, ['class' => 'form-control', $required ]) !!}
                        </div>    
                    </div>
        </td></tr>
        <tr><td>
                    <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                {!! Form::submit($langs['save'], ['class' => 'btn btn-primary form-control']) !!}
                            </div>    
                    </div>                    

        </td></tr>
    </table>
    {!! Form::close() !!}
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

</script>

@endsection