@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Trandetail')

@section('contentheader_title', 	  ' Sale Invoice')
@section('main-content')

<style>
    table.borderless td,table.borderless th, table.borderless tr, table.borderless{
	border:none;
	 padding:10px;
	}
	#col {  min-height:100px; padding-top:50px; width:23%; float:left; padding:20px ; background-color:; margin:5px}
	#inner { border:1px solid #300; min-height:60px; padding:10px; margin:3px}

	#unit {width: 10px} 
	#cur {width: 10px}
	#logo, #td { width:25%}
	#buyerinfo-table tr,#buyerinfo-table td, #buyerinfo-table th { border:1px solid black; }
	.box-body { min-height:400px}
	#in-body { height:50px}
	#foo {width:100%;}
	.underline {  border-bottom: 0; }
	.wordc { text-transform:capitalize}
</style>
        <?php 
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 
			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			isset($_GET['flag']) && $_GET['flag']>0 ? Session::put('siacc_id',$_GET['flag']) : '';

			// data collection filter method by session	
			$data=array('acc_id'=>'');
			
			Session::has('siacc_id') ? 
			$data=array('acc_id'=>Session::get('siacc_id')) : ''; 
			$client_name=''; $client_address='';
			
			isset($data['acc_id']) && $data['acc_id']>0 ?
			$sls=DB::table('acc_salemasters')->where('com_id',$com_id)->where('id', $data['acc_id'])->first() : '';
			isset($sls) && $sls->id >0 ? $sls_check_action=$sls->check_action : $sls_check_action='';
		?>

 <div class="container">
 <div class="box" >
        <div class="box-header">
        	@if($sls_check_action==1)
            <a href="{{ url('salemaster/invoice_print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
<!--            <a href="{{ url('salemaster/invoice_pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('salemaster/invoice_pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('salemaster/invoice_excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('salemaster/invoice_csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('salemaster/invoice_word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
-->            @endif
        </div><!-- /.box-header -->
        

    <div class="table-responsive">
		<div class="box-body" >

        <table  width="100%" border="1" class="borderless">
        <tr><td id="logo"></td><td>
        	<h2 align="center">{{ $com->name }}</h2>
            <h5 class="text-center">{{ $com->oaddress }}</h5>
            <h5 class="text-center">{{ $com->phone }}, {{ $com->fax }}</h5>
            <h5 class="text-center">{{ $com->email }}, {{ $com->web }}</h5>
        </td><td></td></tr>
        <?php 


			if (isset($data['acc_id']) && $data['acc_id']>0):
				// for single account
				
				$sale=DB::table('acc_salemasters')->where('com_id',$com_id)->where('id', $data['acc_id'])->get();
				$sales=DB::table('acc_salemasters')->where('com_id',$com_id)->where('id', $data['acc_id'])->first();
				$sales_invoice=''; isset($sales) && $sales->id > 0 ? $sales_invoice=$sales->invoice : $sales_invoice='';
				$sales_date=''; isset($sales) && $sales->id > 0 ? $sales_date=$sales->sdate : $sales_date='';
				$sales_clinet_id=''; isset($sales) && $sales->id > 0 ? $sales_clinet_id=$sales->client_id : $sales_clinet_id='';
				$sales_clinet_address=''; isset($sales) && $sales->id > 0 ? $sales_clinet_address=$sales->client_address : $sales_clinet_address='';
				$sales_clinet_name=''; isset($sales) && $sales->id > 0 ? $sales_clinet_name=$sales->client : $sales_clinet_name='';
				
				$client = DB::table('acc_clients')->where('com_id',$com_id)->where('id',$sales_clinet_id)->first();  
				if (isset($client) && $client->id > 0):
					$client_name=$client->name;
					$client_address=$client->address1;
				else:
					$client_name=$sales_clinet_name;
					$client_address=$sales_clinet_address;
				
				endif;

				echo '<tr><td ><h2 class="pull-left">Invoice</h2></td><td></td>
				<td class="text-right"  id="td"><h4 aling="right">Invoice No: '.$sales_invoice.'</h4><h4>Date: '.$sales_date.'</h4></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h4>Invoice</h4><h5 ></h5></td></tr>';
			endif;
			
		?>
        
        </table>
			
            <table id="buyerinfo-table" class="table">
                <thead>
                 <tr><td colspan="6"><a href="{!! url('/salemaster/invoice?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'salemaster/sifilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('acc_id', $langs['invoice'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $invoices, null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-3">
                                {!! Form::submit($langs['find'], ['class' => 'btn btn-primary form-control']) !!}
                                </div>    
                            </div>
                          {!! Form::close() !!}
                     @endif
               </td></tr>

                 <tr class="underline"><td colspan="6"> Name: {{ $client_name }} </td></tr>
                 <tr class="underline"><td colspan="6"> Address: {{ $client_address }}</td></tr> 
                    <tr>
                        <th class="col-md-1 text-center">{{ $langs['sl'] }}</th>
                        <th class="col-md-3">{{ $langs['description'] }}</th>
                        <th class="col-md-2 text-right">{{ $langs['qty'] }}</th>
                        <th class="col-md-2 text-right" >{{ $langs['rate'] }}</th>
                        <th class="col-md-2 text-right" >{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
                <?php 
				$username='';$checkname='';$apprname='';$y=0;
				?>
                @foreach($sale as $item)
                
                 	<?php
					$username=$item->user_id >0 ? $users[$item->user_id] : '';
					$checkname=$item->check_action==1 ? $users[$item->check_id] : 'waiting';
					$apprname= '...';
					//$user=$item->user->name;
					$ttl='';
					$details=DB::table('acc_saledetails')->where('com_id',$com_id)->where('group_id',0)->where('sm_id', $item->id)->get(); 
					$purch=DB::table('acc_salemasters')->where('com_id',$com_id)->where('id', $item->id)->first(); //echo $purch->amount;

					 $currency = DB::table('acc_currencies')->where('id',$item->currency_id)->first();  
					 $currency_name=''; isset($currency) && $currency->id > 0 ? $currency_name=$currency->name : $currency_name='';
					
					?>
                    
                        @foreach($details as $item)
                        {{-- */$x++;/* --}}
                        <?php 
						
							$ttl+=$item->amount;
							$item->amount> 0 ? $item->amounts=number_format($item->amount, 2): $item->amounts='';
							$item->rate> 0 ? $item->rates=number_format($item->rate, 2): $item->rates='';

							$vnumber = DB::table('acc_invenmasters')->max('vnumber')+1; 
							$item->user_id > 0 ? $person=$users[$item->user_id] : $person='';

							$products = DB::table('acc_products')->where('id',$item->item_id)->first(); 
							$product_name=''; isset($products) && $products->id > 0 ? $product_name=$products->name : $product_name='';
							$unit_id=''; isset($products) && $products->id > 0 ? $unit_id=$products->unit_id : $unit_id='';
							$units = DB::table('acc_units')->where('id',$unit_id)->first(); 
							$unit_name=''; isset($units) && $units->id > 0 ? $unit_name=$units->name : $unit_name='';
							$y=$y+50;
							$space=""; $item->group_id>0 ? $space="50" : $space=""; //echo $space.'mm<br>';
						?>
                         <tr id="in-body">
                        	<td class="text-center">{{ $x }}</td>
                            <td style="padding-left:{{ $space }}px">{{ $product_name }}</td>
                            <td class=" text-right">{{ $item->qty }} {{ $unit_name }}</td>
                            <td class=" text-right">{{ $item->rates}} {{ $currency_name }}</td>
                            <td class=" text-right">{{ $item->amounts }} {{ $currency_name }}</td>
                          </tr>
						<?php 
							$details=DB::table('acc_saledetails')->where('com_id',$com_id)->where('group_id', $item->id)->get(); 
						?>
                                @foreach($details as $item)
                                {{-- */$x++;/* --}}
                                <?php 
                                    $ttl+=$item->amount;
                                    $item->amount> 0 ? $item->amounts=number_format($item->amount, 2): $item->amounts='';
                                    $item->rate> 0 ? $item->rates=number_format($item->rate, 2): $item->rates='';
        
                                    $vnumber = DB::table('acc_invenmasters')->max('vnumber')+1; 
                                    $item->user_id > 0 ? $person=$users[$item->user_id] : $person='';
        
                                    $products = DB::table('acc_products')->where('id',$item->item_id)->first(); 
                                    $product_name=''; isset($products) && $products->id > 0 ? $product_name=$products->name : $product_name='';
                                    $unit_id=''; isset($products) && $products->id > 0 ? $unit_id=$products->unit_id : $unit_id='';
                                    $units = DB::table('acc_units')->where('id',$unit_id)->first(); 
                                    $unit_name=''; isset($units) && $units->id > 0 ? $unit_name=$units->name : $unit_name='';
                                    $y=$y+50;
                                    $space=""; $item->group_id>0 ? $space="50" : $space=""; //echo $space.'mm<br>';
                                ?>
                                 <tr id="in-body">
                                    <td class="text-center">{{ $x }}</td>
                                    <td style="padding-left:{{ $space }}px">{{ $product_name }}</td>
                                    <td class=" text-right">{{ $item->qty }} {{ $unit_name }}</td>
                                    <td class=" text-right">{{ $item->rates}} {{ $currency_name }}</td>
                                    <td class=" text-right">{{ $item->amounts }} {{ $currency_name }}</td>
                                  </tr>
                                  
                                @endforeach  
                        @endforeach  
                        <?php $y=400 - $y; ?>
                         <tr style="height:{{ $y }}px">
                        	<td class="text-center"></td>
                            <td></td>
                            <td class=" text-right"></td>
                            <td class=" text-right"></td>
                            <td class=" text-right"></td>
                          </tr>
                        <?php 
							$ttl> 0 ? $ttls=number_format($ttl, 2) : $ttls=''; 
							// check entry 
							$check_entry = DB::table('acc_invenmasters')->where('pm_id', $data['acc_id'] )->first();
							isset($check_entry) && $check_entry->pm_id>0 ? $entry_has='yes' : $entry_has='no' ; //echo $entry_has;
						?> 
                        <tr><td colspan="4" class=" text-right">Total</td><td class=" text-right">{{ $ttls }} {{ $currency_name }}</td></tr> 
                        <tr><td colspan="8" class=" text-left wordc">Inwords : {{ Terbilang::make($ttl) }}</td></tr> 

                @endforeach
				
                </tbody>
            </table>
            </div>
         	<div class="foo" style="padding:5px">
                <div class="text-center" id="col">{{ $username }}
                    <div id="inner">Inputed By</div>
                </div>
            	<div class="text-center" id="col">{{ $checkname }}
            		<div id="inner">Checked By</div>
                </div>
            	<div class="text-center" id="col">{{ $apprname }}
            		<div id="inner">Approved By</div>
                </div>
            	<div class="text-center" id="col">....
            		<div id="inner">Received By</div>
                </div>
            </div>     
        </div>
     </div>
</div>
@endsection

@section('custom-scripts')

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".trandetail").validate();
		$( "#dfrom" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
        $( "#dto" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
