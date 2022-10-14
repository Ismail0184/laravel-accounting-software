@extends('app')

@section('htmlheader_title', 'Purchase Details')

@section('contentheader_title', 	  ' Purchase Details')
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
			

			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			
			
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

			echo account_exist('Local Purchase','Current Assets','Balance Sheet','Account');

			
			$sa_id=''; $mc_id=''; $npay=''; $asalry=''; $loans=''; $tdate=''; $m_id=''; $year=''; $as_id=''; $el_id='';
			
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h2 align="center">'.$com_name.'</h2></td></tr>';
			// data collection filter method by session	
			$data=array('acc_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');
			
			Session::has('pddto') ? 
			$data=array('acc_id'=>Session::get('pdacc_id'),'dfrom'=>Session::get('pddfrom'),'dto'=>Session::get('pddto')) : 
			$data=array('acc_id'=>'','dfrom'=>date('Y-m-01'),'dto'=>date('Y-m-d')); 

			// for Accounting information
			$vnumbers = DB::table('acc_tranmasters')->where('com_id',$com_id)->max('vnumber')+1;
			$purchase = DB::table('acc_coas')->where('com_id',$com_id)->where('name','Local Purchase')->first();
			$purchase_id=''; isset($purchase) && $purchase->id> 0 ? $purchase_id=$purchase->id : $purchase_id='';
			$sale = DB::table('acc_coas')->where('com_id',$com_id)->where('name','Sales')->first();
			$sale_id=''; isset($sale) && $sale->id> 0 ? $sale_id=$sale->id : $sale_id='';

			$maincash = DB::table('acc_coas')->where('com_id',$com_id)->where('name','Main Cash')->first();
			$maincash_id=''; isset($maincash) && $maincash->id> 0 ? $maincash_id=$maincash->id : $maincash_id='';
			
			if (isset($data['acc_id']) && $data['acc_id']>0):
				// for single accountoption_cur_id
				
				echo '<tr><td ><h3 class="pull-left">Purchase Details</h3></td>
				<td class="text-right" ><h3 aling="right"></h3><h5 ></h5></td></tr>'; //'.$invoices[$data['acc_id']].'
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h5>Purchase Details</h5><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			endif;
			
		?>
        
        </table>

            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="10"><a href="{!! url('/purchasemaster/report?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'purchasemaster/filter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('acc_id', $langs['invoice'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $invoices, null, ['class' => 'form-control']) !!}
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
                        <th class="col-md-3">{{ $langs['pdate'] }}</th>
                        <th class="col-md-3">{{ $langs['client_id'] }}</th>
                        <th class="col-md-3">{{ $langs['item_id'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['qty'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['rate'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
                <?php 
						if (isset($data['acc_id']) && $data['acc_id'] > 0): 
							$purchase=DB::table('acc_purchasemasters')->where('com_id',$com_id)->where('id', $data['acc_id'])->get();
						elseif (isset($data['dfrom']) && $data['dfrom']!= '0000-00-00'): 
							$purchase=DB::table('acc_purchasemasters')->where('com_id',$com_id)
							->whereBetween('pdate', [$data['dfrom'], $data['dto']])->get();	
						endif;
						$check_action='';
						
				?>
                @foreach($purchase as $item)
                	<?php
		
					$clint=DB::table('acc_clients')->where('com_id',$com_id)->where('id',$item->client_id)->first();	
					isset($clint) && $clint->id>0 ? $client_name=$clint->name : $client_name=$item->client;
					isset($clint) && $clint->id>0 ? $client_id=$clint->acc_id : $client_id='';
					if ($item->client_id!=0 && $clint->name=='') : 
						echo "<h1>The clinet has no COA link; Please <a href=". URL::route('client.edit', $item->client_id) .">Link Now</a></h1>"; 
					endif;
					//$user=$item->user->name;
					$ttl='';
					$details=DB::table('acc_purchasedetails')->where('pm_id', $item->id)->get(); 
					$purch=DB::table('acc_purchasemasters')->where('id', $item->id)->first(); //echo $purch->amount;

					$currency=DB::table('acc_currencies')->where('id',$item->currency_id)->first();
					$currency_name=''; isset($currency) && $currency->id > 0 ? $currency_name=$currency->name : $currency_name='';
					
					$pdate=$item->pdate;
					$inv=$item->invoice;
					$check_action=$item->check_action;
					$wh_id=$item->wh_id;
					?>
                    	 {!! Form::open(['route' => 'invenmaster.store', 'class' => 'form-horizontal']) !!}
                        @foreach($details as $item)
                        {{-- */$x++;/* --}}
                        <?php 
							$ttl+=$item->amount;
							$item->amount> 0 ? $item->amounts=number_format($item->amount, 2): $item->amounts='';
							$item->rate> 0 ? $item->rates=number_format($item->rate, 2): $item->rates='';
							$ratio=$item->amount/$purch->amount*100;
							$ratio> 0 ? $ratios=number_format($ratio, 4): '';
							$vnumber = DB::table('acc_invenmasters')->where('com_id',$com_id)->max('vnumber')+1; 
							$item->user_id > 0 ? $person=$users[$item->user_id] : $person='';
							
							$product=DB::table('acc_products')->where('com_id',$com_id)->where('id',$item->item_id)->first();

							isset($product) && $product->id > 0 ? $product_name=$product->name : $product_name='';
							$unit_id=''; isset($product) && $product->id > 0 ? $unit_id=$product->unit_id : $unit_id='';
							$unit = DB::table('acc_units')->where('id',$unit_id)->first(); 
							$unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name : $unit_name='';

						?>
                         <tr>
                        	<td class="text-center">{{ $x }}</td>
                            <td>{{ $pdate }}/ Invoice: {{ $inv }}</td>
                            <td>{{ $client_name }}</td>
                            <td>{{ $product_name }}</td>
                            <td id="unit" class="text-right" ></td><td class=" text-right">{{ $item->qty }} {{ $unit_name }}</td>
                            <td class="text-right">{{ $currency_name }}</td><td class=" text-right">{{ $item->rates}}</td>
                            <td class="text-right">{{ $currency_name }}</td><td class=" text-right">{{ $item->amounts }}</td>
                         </tr>
                            <input type="hidden" name="item_id[]" value="{{ $item->item_id }}" />
                            <input type="hidden" name="qty[]" value="{{ $item->qty }}" />
                            <input type="hidden" name="rate[]" value="{{ $item->rate }}" />
                            <input type="hidden" name="vnumber" value="{{ $vnumber }}" />
                            <input type="hidden" name="itype" value="Receive" />
                            <input type="hidden" name="idate" value="{{ date('Y-m-d')}}" />
                            <input type="hidden" name="unit_id[]" value="{{ $unit_id }}" />
                            <input type="hidden" name="amount" value="{{ $purch->amount }}" />
                            <input type="hidden" name="person" value="{{ $person }}" />
                            <input type="hidden" name="note" value="Purchase, VNo:{{ $invoices[$data['acc_id']] }}" />
                            <input type="hidden" name="check" value="purchase" />
                            <input type="hidden" name="war_id" value="{{ $wh_id }}" />

                        	{!! Form::hidden('vnumbers', $vnumbers, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('sh_id', null, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('acc_id', $purchase_id, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('tranwith_id', $purch->acc_id, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('sale_id', $sale_id, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('tmamount', $purch->paid, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('amounts', $purch->paid, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('dues', $purch->amount-$purch->paid, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('paid', $purch->paid, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('tdate', date('Y-m-d'), ['class' => 'form-control']) !!}
                        	{!! Form::hidden('ttype', 'Payment', ['class' => 'form-control']) !!}
                        	{!! Form::hidden('clacc_id', $client_id, ['class' => 'form-control']) !!}
                        	{!! Form::hidden('inven_auto_update', $inven_auto_update, ['class' => 'form-control']) !!}

                        @endforeach  
                        <?php 
							$ttl> 0 ? $ttls=number_format($ttl, 2) : $ttls=''; 
							// check entry 
							$check_entry = DB::table('acc_invenmasters')->where('com_id',$com_id)->where('note', 'Purchase, VNo:'.$invoices[$data['acc_id']])->first();
							isset($check_entry) && $check_entry->id>0 ? $entry_has='yes' : $entry_has='no' ; //echo $entry_has;
						?> 
                        <tr><td colspan="7" class=" text-right">Total</td><td id="cur" class=" text-right">{{ $currency_name }}<td class=" text-right">{{ $ttls }}</td><td></td></tr> 
                        @if(isset($data['acc_id']) && $data['acc_id'] > 0 && $check_action==1)
                        	<tr><td class="text-right" colspan="11">
                			{!! Form::hidden('flag','addstore') !!} 
                			{!! Form::hidden('check','purchase') !!} 
                            @if($entry_has=='no')
                        		{!! Form::submit($langs['addstore'], ['class' => 'btn btn-primary']) !!}
                            @else
                            	Already Stored
                            @endif
                            </td></tr>
                        @endif
                @endforeach
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
