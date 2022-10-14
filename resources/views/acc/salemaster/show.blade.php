@extends('app')

@section('htmlheader_title', 'Salemaster')

@section('contentheader_title', 'Sale')

@section('main-content')
<style>
	#field{ width:150px; text-align:right}
	#unit, #currency { width:30px}
	#sl { width:150px;}
</style>
<?php 
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

			$client=DB::table('acc_clients')->where('com_id',$com_id)->where('id', $salemaster->client_id)->first();
			$client_name=''; isset($client) && $client->id > 0 ? $client_name=$client->name : $client_name='';
			$client_address=''; isset($client) && $client->id > 0 ? $client_address=$client->address1 : $client_address='';
			$client_address=='' ? $client_address=$salemaster->client_address : '';
			$client_acc_id=''; isset($client) && $client->acc_id > 0 ? $client_acc_id=$client->acc_id : $client_acc_id=''; //echo $client_acc_id;
			
			$wh=DB::table('acc_warehouses')->where('com_id',$com_id)->where('id', $salemaster->wh_id)->first();
			$wh_name=''; isset($wh) && $wh->id > 0 ? $wh_name=$wh->name : $wh_name='';

			$currency=DB::table('acc_currencies')->where('id',$salemaster->currency_id)->first();
			isset($currency) && $currency->id > 0 ? $currencys=$currency->name: $currencys='';
			
			Session::put('sswh_id', $salemaster->wh_id);
//			$product = DB::table('acc_products')->join('acc_invendetails','acc_products.id','=','acc_invendetails.item_id')->select(DB::raw('sum(qty) as qty, name'))
//			->having(DB::raw('sum(qty)'),'>',0)
//			->where('acc_products.com_id',$com_id)
//			->where('war_id', $salemaster->wh_id)
//			->groupBy('item_id')->get();


?>
<div class="box">
        <div class="box-header">
            <a href="{{ url('salemaster/invoice_print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('salemaster/invoice_pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('salemaster/invoice_pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('salemaster/invoice_excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('salemaster/invoice_csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('salemaster/invoice_word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
        </div><!-- /.box-header -->
                <div class="table-responsive"  width:90%" >
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th id="field">{{ $langs['pdate'] }}</th>
                            <td><a href="{{ url('salemaster') }}">{{ $salemaster->sdate }}</a></td>
                            <th id="field">{{ $langs['client_id'] }}</th>
                            <td>{{ $client_name }}</td>
                        </tr>
                        <tr>
                            <th id="field">{{ $langs['invoice'] }}</th>
                            <td>{{ $salemaster->invoice }}</td>
                            <th id="field">{{ $langs['client_address'] }}</th>
                            <td>{{ $client_address }}</td>
                        </tr>
                        <tr>
                            <th id="field">{{ $langs['war_id'] }}</th>
                            <td>{{ $wh_name }}</td>
                            <th id="field"></th>
                            <td></td>
                        </tr>
                    </table>
                    
   			 <table class="table table-bordered">   
             	<tr>
                	<th class="text-center" id="sl">SL</th>
                    <th>Product</th>
                    <th class="text-right" colspan="2">Quantity</th>
                    <th class="text-right" colspan="2">Rate</th>
                    <th class="text-right" colspan="2">Amount</th>
                    <th></th><th></th>
                    
                </tr>             
                  <?php 
						
				  		$x=0; $ttl=0;
				  		$record = DB::table('acc_saledetails')->where('com_id',$com_id)->where('sm_id', $salemaster->id)->get(); 
						
						foreach($record as $item):
						$x++; $ttl+=$item->amount;
						$product = DB::table('acc_products')->where('com_id',$com_id)->where('id',$item->item_id)->first(); 
						$product_name=''; isset($product) && $product->id >0 ? $product_name=$product->name : $product_name='';
						$unit_id=''; isset($product) && $product->id > 0 ? $unit_id=$product->unit_id : $unit_id='';
						$unit = DB::table('acc_units')->where('id',$unit_id)->first(); 
						$unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name : $unit_name='';

							echo "<tr><td class='text-center'>$x</td><td>$product_name</td>
							<td class='text-right'>$item->qty</td><td id='unit'>".$unit_name."</td>
							<td class='text-right'>".number_format($item->rate)."</td><td id='currency'>".$currencys."</td>
							<td class='text-right'>".number_format($item->amount)."</td><td id='currency'>".$currencys."</td>
							"; ?>
                            <td width="40px"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('saledetail.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td>
                            {!! Form::open(['route' => ['saledetail.destroy', $item->id], 'method' => 'DELETE']) !!}
                            <td width="40px">{!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}</td>
                            {!!  Form::close() !!}
                            

                            <?php echo "</tr>"; 
						endforeach;
						echo "<tr><td colspan='6' class='text-right'>Total</td><td class='text-right'>".number_format($ttl)."</td><td id='currency'>".$currencys."</td><td></td><td></td></tr>";

				  ?>
                    
  			 </table>                 
                    
                    
                    
{!! Form::open(['route' => 'saledetail.store', 'class' => 'form']) !!}
 <div style="background-color:#0F9">
   
   <table class="table table-bordered">
   				<tr><td>
					<div class="form-group">
                        {!! Form::label('item_id', $langs['item_id']) !!}
                            {!! Form::select('item_id', $productz, null, ['class' => 'form-control select2', 'required', 'style' => 'width: 200px;']) !!}
                    </div>
   				</td><td>
					<div class="form-group">
                        {!! Form::label('qty', $langs['qty']) !!}
                            {!! Form::text('qty', null, ['class' => 'form-control', 'required', 'id'=>'qty', 'style' => 'width: 150px']) !!}
                            {!! Form::hidden('max_qty', null, ['class' => 'form-control', 'required','id'=>'max_qty']) !!}
                    </div>

     			</td><td>                
					<div class="form-group">
                        {!! Form::label('rate', $langs['rate']) !!}
                            {!! Form::text('rate', null, ['class' => 'form-control', 'required', 'id'=>'rate', 'style' => 'width: 150px']) !!}
                    </div>
	 			</td><td>
                	<div class="form-group">
                    	{!! Form::hidden('sm_id', $salemaster->id) !!} 
                        {!! Form::label('amount', $langs['amount']) !!}
                            {!! Form::text('amount', null, ['class' => 'form-control', 'required', 'id'=>'amount', 'style' => 'width: 150px']) !!}
                    </div>
	 			</td><td>
                	<div class="form-group">
                        {!! Form::label('group_id', $langs['group_id']) !!}
                            {!! Form::select('group_id', $groups, null, ['class' => 'form-control', 'style' => 'width: 150px']) !!}
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
    <?php $salemaster->client_id>0 ? $readonly='' : $readonly='readonly';  ?>          

    {!! Form::model($salemaster, ['route' => ['salemaster.update', $salemaster->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

	<table  class="table table-bordered">
    	<tr><td>
					<div class="form-group">
                        {!! Form::label('samount', $langs['samount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('samount', $ttl, ['class' => 'form-control', ]) !!}
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
        <?php $salemaster->paid==0 && $client_acc_id==0 ? $paid=$ttl : $paid=$salemaster->paid; ?>
     				<div class="form-group">
                        {!! Form::label('paid', $langs['paid'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('paid', $paid, ['class' => 'form-control', $readonly]) !!}
                        </div>    
                    </div>
        </td></tr><tr><td>
     				<div class="form-group">
                        {!! Form::label('note', $langs['note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('note', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>

        </td></tr><tr><td>
					<div class="form-group">
                        {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('acc_id', $coa,null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
        
        </td></tr><tr><td>

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


@endsection
@section('custom-scripts')

<script>
var x = document.getElementById("amount");
x.addEventListener("focus", myFocusFunction, true);

function myFocusFunction() {
    document.getElementById("amount").value = document.getElementById("qty").value*document.getElementById("rate").value;  
}

    jQuery(document).ready(function($) {        
		
		 $("#item_id").change(function() {
            $.getJSON("{{ url('qproduct/price')}}/" + $("#item_id").val(), function(data) {
                var $courts = $("#rate");
                $courts.empty();
                $.each(data, function(index, value) {
					$courts.val(value);
                });
            });
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

		$("#qty").on('input', function() {
			 var $max_qty = parseInt($("#max_qty").val());
			 var $courts = parseInt($("#qty").val());
			if ($courts>$max_qty){
		  		alert('Exit Limit, Stock Balance is '+$("#max_qty").val());
				$('#qty').val("");
			}
		});    

		  $(function () {
			  $("#discount").bind('input', function() {
				$("#paid").val($("#samount").val()-($("#discount").val()+$("#vat_tax").val()));
			  //alert("letter entered");
			  });
		   });

		  $(function () {
			  $("#vat_tax").bind('input', function() {
				$("#paid").val($("#samount").val()-($("#discount").val()+$("#vat_tax").val()));
			  //alert("letter entered");
			  });
		   });


	});
</script>

@endsection