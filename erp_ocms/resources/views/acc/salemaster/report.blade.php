@extends('app')

@section('htmlheader_title',  ' Sales')

@section('contentheader_title', 	  ' Sales')
@section('main-content')

<style>
    table.borderless td,table.borderless th{
     border: none !important;
	}

	h1{
		font-size: 1.6em;
	}
	h5{
		font-size: 1.2em; margin:0px
	}
	#unit {width: 10px} 
	#cur {width: 10px}
</style>

 <div class="container">
 <div class="box" >
    <div class="table-responsive">
        <table  width="100%>
        <?php 
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 
			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 

			echo '<tr><td colspan="2"><h1 align="center">'.$com_name.'</h1></td></tr>';

			// data collection filter method by session	
			$data=array('acc_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');
			
			Session::has('smdto') ? 
			$data=array('acc_id'=>Session::get('smacc_id'),'dfrom'=>Session::get('smdfrom'),'dto'=>Session::get('smdto')) : 
			$data=array('acc_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');
			
			$invoice='';
			if (isset($data['acc_id']) && $data['acc_id']>0):
				// for single account
				$data['acc_id']> 0 ? $invoice=$invoices[$data['acc_id']] : $invoice='';
				echo '<tr><td ><h3 class="pull-left">Sale Details</h3></td>
				<td class="text-right" ><h3 aling="right">Invoice No:'.$invoice.'</h3><h5 ></h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h5>Sale Details</h5><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			endif;

			function account_exist($account_head,$group,$tg,$at){
				Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
				$has=DB::table('acc_coas')->where('com_id', $com_id)->where('name',$account_head)->first();
				
				if(isset($has) && $has->id>0):
				else:
					$ca=DB::table('acc_coas')->where('com_id',$com_id)->where('name',$group)->first();
					isset($ca) && $ca->id > 0 ? $g=$ca->id : $g='';
					$bs=DB::table('acc_coas')->where('com_id',$com_id)->where('name',$tg)->first();
					isset($bs) && $bs->id > 0 ? $tg=$bs->id : $tg='';
					return '<a href="'.url('acccoa/create?name='.$account_head.'&g='.$g.'&tg='.$tg.'&at='.$at).'">Please create '.$account_head.'</a>';
				endif;
			}

			//echo account_exist('Inventory','Current Assets','Balance Sheet','Account');
			echo account_exist('Sales','Income','Profit and Loss Account','Account');

			// for Accounting information
			$vnumbers = DB::table('acc_tranmasters')->where('com_id',$com_id)->max('vnumber')+1;
			$sale = DB::table('acc_coas')->where('com_id',$com_id)->where('name','Sales')->first();
			$sale_id=''; isset($sale) && $sale->id> 0 ? $sale_id=$sale->id : $sale_id='';

			$saleX = DB::table('acc_coas')->where('com_id',$com_id)->where('name','Sales')->first();
			$sales_id=''; isset($saleX) && $saleX->id> 0 ? $sales_id=$saleX->id : $sales_id='';
		?>
        
        </table>

            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="9"><a href="{!! url('/salemaster/report?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'salemaster/filter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('acc_id', $langs['invoice'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $invoices, null, ['class' => 'form-control select2']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  date('Y-m-01'), ['class' => 'form-control', 'id'=>'dfrom', ]) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dto', $langs['dto'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dto', date('Y-m-d'), ['class' => 'form-control', 'id'=>'dto', ]) !!}
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
                    <tr>
                        <th class="col-md-1 text-center">{{ $langs['sl'] }}</th>
                        <th class="col-md-3">{{ $langs['sdate'] }}</th>
                        <th class="col-md-3">{{ $langs['item_id'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['qty'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['rate'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
                {!! Form::open(['route' => 'invenmaster.store', 'class' => 'form-horizontal']) !!}
				{{-- */$x=0;/* --}}
                <?php 
						if (isset($data['acc_id']) && $data['acc_id'] > 0): 
							$sale=DB::table('acc_salemasters')->where('id', $data['acc_id'])->where('com_id',$com_id)->get();
						elseif (isset($data['dfrom']) && $data['dfrom']!= '0000-00-00' && $data['acc_id'] =='') : 
							$sale=DB::table('acc_salemasters')
							->whereBetween('sdate', [$data['dfrom'], $data['dto']])
							->where('com_id',$com_id)->get();
						else:
							$sale=array();
						endif;
						$sdates='';$ttl='';$check_has=''; $client_name='';
				?>

                @foreach($sale as $item)
                
                 	<?php
					
					//$user=$item->user->name;
					$check_has='';
					$details=DB::table('acc_saledetails')->where('com_id',$com_id)->where('sm_id', $item->id)->get(); 
					$purch=DB::table('acc_salemasters')->where('com_id',$com_id)->where('id', $item->id)->first(); //echo $purch->amount;

					 $currency = DB::table('acc_currencies')->where('id',$item->currency_id)->first();  
					 $currency_name=''; isset($currency) && $currency->id > 0 ? $currency_name=$currency->name : $currency_name='';
					
					$sdates=$item->sdate;
					$item->check_action > 0 ? $check_has='yes' : $check_has='no'; 

					$clint=DB::table('acc_clients')->where('id',$item->client_id)->first();	
					isset($clint) && $clint->id>0 ? $client_name=$clint->name : $client_name='';
					isset($clint) && $clint->id>0 ? $client_id=$clint->acc_id : $client_id='';
					?>
                        @foreach($details as $item)
                        {{-- */$x++;/* --}}
                        <?php 
						
							$ttl+=$item->amount;
							$item->amount> 0 ? $item->amounts=number_format($item->amount, 2): $item->amounts='';
							$item->rate> 0 ? $item->rates=number_format($item->rate, 2): $item->rates='';
							$purch->samount> 0 ? $ratio=$item->amount/$purch->samount*100 : $ratio=0;
							$ratio > 0 ? $ratios=number_format($ratio, 4): '';

							$vnumber = DB::table('acc_invenmasters')->where('com_id',$com_id)->max('vnumber')+1; 
							$item->user_id > 0 && isset($users[$item->user_id]) ? $person=$users[$item->user_id] : $person='';

							$products = DB::table('acc_products')->where('id',$item->item_id)->first(); 
							$product_name=''; isset($products) && $products->id > 0 ? $product_name=$products->name : $product_name='';
							$unit_id=''; isset($products) && $products->id > 0 ? $unit_id=$products->unit_id : $unit_id='';
							$units = DB::table('acc_units')->where('id',$unit_id)->first(); 
							$unit_name=''; isset($units) && $units->id > 0 ? $unit_name=$units->name : $unit_name='';
							
						?>
                         <tr>
                        	<td class="text-center">{{ $x }}</td>
                            <td>{{ $sdates }}/ VNo:{{ isset($invoices[$item->sm_id]) ? $invoice=$invoices[$item->sm_id] : '' }}</td>
                            <td>{{ $product_name }}</td>
                            <td id="unit" class="text-right" >{{ $unit_name }}</td><td class=" text-right">{{ $item->qty }}</td>
                            <td id="cur">{{ $currency_name }}</td><td class=" text-right">{{ $item->rates}}</td>
                            <td id="cur">{{ $currency_name }}</td><td class=" text-right">{{ $item->amounts }}</td>
                             </tr>
                            <input type="hidden" name="item_id[]" value="{{ $item->item_id }}" />
                            <input type="hidden" name="qty[]" value="{{ $item->qty }}" />
                            <input type="hidden" name="rate[]" value="{{ $item->rate }}" />
                            <input type="hidden" name="vnumber" value="{{ $vnumber }}" />
                            <input type="hidden" name="itype" value="Issue" />
                            <input type="hidden" name="idate" value="{{ $purch->sdate }}" />
                            <input type="hidden" name="unit_id[]" value="{{ $item->unit_id }}" />
                            <input type="hidden" name="amount" value="{{ $purch->samount }}" />
                            <input type="hidden" name="person" value="{{ $person }}" />
                            <input type="hidden" name="note" value="Sale Invoice No:{{ $invoices[$data['acc_id']] }}" />
							<input type="hidden" name="sm_id" value="{{ $data['acc_id'] }}" />
                            <input type="hidden" name="check" value="sale" />
                            <input type="hidden" name="war_id" value="{{$purch->wh_id }}" />
                        <?php ?>    
                        @endforeach  
                        	{!! Form::hidden('vnumbers', $vnumbers, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('sh_id', null, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('acc_id', $sale_id, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('cash_id', $purch->acc_id, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('tmamount', $purch->samount, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('amounts', $purch->paid, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('dues', $purch->samount-$purch->paid, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('paid', $purch->paid, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('tdate', $purch->sdate, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('ttype', 'Receive', ['class' => 'form-control']) !!}
                        	{!! Form::hidden('clacc_id', $client_id, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('sales_id', $sales_id, ['class' => 'form-control']) !!}

                @endforeach
                        <?php 
							$ttl> 0 ? $ttls=number_format($ttl, 2) : $ttls=''; 
							// check entry 
							$check_entry = DB::table('acc_invenmasters')
							->where('com_id',$com_id)->where('note', 'Sale Invoice No:'.$invoices[$data['acc_id']] )->first(); //echo $data['acc_id'];
							isset($check_entry) && $check_entry->sm_id>0 ? $entry_has='yes' : $entry_has='no' ; //echo $entry_has;

						?> 
                        <tr><td colspan="3" class="text-right">{{  $client_name }}</td><td colspan="4" class=" text-right">Total</td><td id="cur"><td class=" text-right">{{ $ttls }}</td></tr> 
                        

                        @if(isset($data['acc_id']) && $data['acc_id'] > 0)
                        	<tr><td class="text-right" colspan="9">
                			{!! Form::hidden('flag','addstore') !!} 
                 			{!! Form::hidden('check','sale') !!} 
                           @if($entry_has=='no' && $check_has=='yes')
                           		@if($client_id>0)
                        			{!! Form::submit($langs['storer'], ['class' => 'btn btn-primary']) !!}
                                @else
                                	<a href="{{ URL::route('client.edit', $purch->client_id) }}">Please connect the client with chart of account</a>
                                @endif
                            @elseif($entry_has=='yes' && $check_has=='yes')
                            	Already Store Released
                            @endif
                            </td></tr>
                        @endif
                {!! Form::close() !!}
                </tbody>
            </table>
            
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Export->Buyer</td><td class="text-right">Report generated by: </td></tr>
                </table>
            </div><!-- /.box-header -->
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
