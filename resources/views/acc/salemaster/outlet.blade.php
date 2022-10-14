@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Trandetail')

@section('contentheader_title', 	  ' Outlet-wise Sales')
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
			
			Session::has('odto') ? 
			$data=array('acc_id'=>Session::get('oacc_id'),'dfrom'=>Session::get('odfrom'),'dto'=>Session::get('odto')) : 
			$data=array('acc_id'=>'','dfrom'=>date('Y-m-01'),'dto'=>date('Y-m-d'));
			$outlet=DB::table('acc_outlets')->where('id',$data['acc_id'])->where('com_id',$com_id)->first();
			$outlet_name=''; isset($outlet) && $outlet->id >0 ? $outlet_name=$outlet->name : $outlet_name='';
		
			if (isset($data['acc_id']) && $data['acc_id']>0):
				// for single account
				$data['acc_id']> 0 ? $invoice='' : $invoice='';
				echo '<tr><td ><h3 class="pull-left">Sale Details</h3></td>
				<td class="text-right" ><h3 aling="right">For :'.$outlet_name.'</h3><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h5>Sale Details</h5><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			endif;
		?>
        
        </table>

            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="8"><a href="{!! url('/salemaster/outlet?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'salemaster/ofilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('acc_id', $langs['olt_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $outlets, null, ['class' => 'form-control']) !!}
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

				{{-- */$x=0;/* --}}
                <?php 
						if (isset($data['dfrom']) && $data['acc_id']!=''): 
							$sale=DB::table('acc_salemasters')
							->join('acc_saledetails','acc_salemasters.id','=','acc_saledetails.sm_id')
							->whereBetween('sdate', [$data['dfrom'], $data['dto']])
							->where('outlet_id',$data['acc_id'])
							->where('acc_saledetails.com_id',$com_id)->groupBY('invoice')->get();	
						endif;
						$sdates='';$ttl=''; $qty='';$unit_name='';$currency_name='';
				?>

                @foreach($sale as $item)
                
                 	<?php
					//$user=$item->user->name;
					$check_has='';
					$details=DB::table('acc_saledetails')->where('com_id',$com_id)->where('sm_id', $item->sm_id)->get(); 
					$purch=DB::table('acc_salemasters')->where('com_id',$com_id)->where('id', $item->sm_id)->first(); //echo $purch->amount;

					 $currency = DB::table('acc_currencies')->where('id',$item->currency_id)->first();  
					 $currency_name=''; isset($currency) && $currency->id > 0 ? $currency_name=$currency->name : $currency_name='';
					
					$sdates=$item->sdate;
					$item->check_action > 0 ? $check_has='yes' : $check_has='no'; 
					?>
                        @foreach($details as $item)
                        {{-- */$x++;/* --}}
                        <?php 
						
							$ttl+=$item->amount; $qty+=$item->qty;
							$item->amount> 0 ? $item->amounts=number_format($item->amount, 2): $item->amounts='';
							$item->rate> 0 ? $item->rates=number_format($item->rate, 2): $item->rates='';
							$purch->amount> 0 ? $ratio=$item->amount/$purch->amount*100 : $ratio=0;
							$ratio > 0 ? $ratios=number_format($ratio, 4): '';
							$vnumber = DB::table('acc_invenmasters')->where('com_id',$com_id)->max('vnumber')+1; 
							$item->user_id > 0 ? $person=$users[$item->user_id] : $person='';

							$products = DB::table('acc_products')->where('id',$item->item_id)->first(); 
							$product_name=''; isset($products) && $products->id > 0 ? $product_name=$products->name : $product_name='';
							$unit_id=''; isset($products) && $products->id > 0 ? $unit_id=$products->unit_id : $unit_id='';
							$units = DB::table('acc_units')->where('id',$unit_id)->first(); 
							$unit_name=''; isset($units) && $units->id > 0 ? $unit_name=$units->name : $unit_name='';
							
						?>
                         <tr>
                        	<td class="text-center">{{ $x }}</td>
                            <td>{{ $sdates }}/ VNo:{{ $invoice=$invoices[$item->sm_id] }}</td>
                            <td>{{ $product_name }}</td>
                            <td id="unit" class="text-right" >{{ $unit_name }}</td><td class=" text-right">{{ $item->qty }}</td>
                            <td id="cur">{{ $currency_name }}</td><td class=" text-right">{{ $item->rates}}</td>
                            <td id="cur">{{ $currency_name }}</td><td class=" text-right">{{ $item->amounts }}</td>
                             </tr>
                        @endforeach  
                @endforeach
                        <?php 
							$ttl> 0 ? $ttls=number_format($ttl, 2) : $ttls=''; 

						?> 
                        <tr><td colspan="3" class=" text-right">Total</td><td id="unit" class="text-right" >{{ $unit_name }}</td><td class=" text-right">{{ $qty }}</td><td></td><td></td><td id="cur">{{ $currency_name }}<td class=" text-right">{{ $ttls }}</td></tr> 
                            </td></tr>

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
