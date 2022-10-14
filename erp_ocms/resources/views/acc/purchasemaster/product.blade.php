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
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h2 align="center">'.$com_name.'</h2></td></tr>';
			// data collection filter method by session	
			$data=array('acc_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');
			
			Session::has('pdto') ? 
			$data=array('acc_id'=>Session::get('pacc_id'),'dfrom'=>Session::get('pdfrom'),'dto'=>Session::get('pdto')) : 
			$data=array('acc_id'=>'','dfrom'=>date('Y-m-01'),'dto'=>date('Y-m-d')); 

			$product=DB::table('acc_products')->where('com_id',$com_id)->where('id',$data['acc_id'])->first();
			$productname=''; isset($product) && $product->id > 0 ? $productname=$product->name : $productname='';

			
			if (isset($data['acc_id']) && $data['acc_id']>0):
				// for single accountoption_cur_id
				
				echo '<tr><td ><h3 class="pull-left">Purchase Details</h3></td>
				<td class="text-right" ><h3 aling="right">'.$productname.'</h3><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>'; //'.$invoices[$data['acc_id']].'
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h5>Purchase Details</h5><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			endif;
		?>
        
        </table>

            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="8"><a href="{!! url('/purchasemaster/product?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'purchasemaster/pfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $products, null, ['class' => 'form-control','required']) !!}
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
                        <th class="col-md-3">{{ $langs['item_id'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['qty'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['rate'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
                <?php 
						if (isset($data['dfrom']) && $data['acc_id']!= ''): 
							$purchase=DB::table('acc_purchasemasters')
							->join('acc_purchasedetails','acc_purchasedetails.pm_id','=','acc_purchasemasters.id')
							->where('acc_purchasemasters.com_id',$com_id)
							->whereBetween('pdate', [$data['dfrom'], $data['dto']])
							->where('item_id',$data['acc_id'])
							->get();	
						endif;
				$check_action='';
				?>
                @foreach($purchase as $item)
                	<?php

					//$user=$item->user->name;
					$ttl='';
					$details=DB::table('acc_purchasedetails')->where('com_id',$com_id)->where('pm_id', $item->pm_id)->where('item_id',$item->item_id)->get(); 
					$purch=DB::table('acc_purchasemasters')->where('com_id',$com_id)->where('id', $item->id)->first(); //echo $purch->amount;

					$currency=DB::table('acc_currencies')->where('id',$item->currency_id)->first();
					$currency_name=''; isset($currency) && $currency->id > 0 ? $currency_name=$currency->name : $currency_name='';
					
					$pdate=$item->pdate;
					$inv=$item->invoice;
					$check_action=$item->check_action;
					?>
                    	 {!! Form::open(['route' => 'invenmaster.store', 'class' => 'form-horizontal']) !!}
                        @foreach($details as $item)
                        {{-- */$x++;/* --}}
                        <?php 
							$ttl+=$item->amount;
							$item->amount> 0 ? $item->amounts=number_format($item->amount, 2): $item->amounts='';
							$item->rate> 0 ? $item->rates=number_format($item->rate, 2): $item->rates='';
							
							$product=DB::table('acc_products')->where('com_id',$com_id)->where('id',$item->item_id)->first();
							isset($product) && $product->id > 0 ? $product_name=$product->name : $product_name='';
							$unit_id=''; isset($product) && $product->id > 0 ? $unit_id=$product->unit_id : $unit_id='';
							$unit = DB::table('acc_units')->where('id',$unit_id)->first(); 
							$unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name : $unit_name='';

						?>
                         <tr>
                        	<td class="text-center">{{ $x }}</td>
                            <td>{{ $pdate }}/ Invoice: {{ $inv }}</td>
                            <td>{{ $product_name }}</td>
                            <td id="unit" class="text-right" ></td><td class=" text-right">{{ $item->qty }} {{ $unit_name }}</td>
                            <td class="text-right">{{ $currency_name }}</td><td class=" text-right">{{ $item->rates}}</td>
                            <td class="text-right">{{ $currency_name }}</td><td class=" text-right">{{ $item->amounts }}</td>
                             </tr>
                        @endforeach  
                        <?php 
							$ttl> 0 ? $ttls=number_format($ttl, 2) : $ttls=''; 
						?> 
                        <tr><td colspan="7" class=" text-right">Total</td><td id="cur" class=" text-right">{{ $currency_name }}<td class=" text-right">{{ $ttls }}</td></tr> 
                            </td></tr>
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
