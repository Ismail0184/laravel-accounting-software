@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Trandetail')

@section('contentheader_title', 	  ' Import')
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
        <div class="box-header">
<table  width="100%>
        <?php 
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h2 align="center">'.$com_name.'</h2></td></tr>';

			$data=array('prod_id'=>'');
			
			Session::has('pdto') ? 
			$data=array('prod_id'=>Session::get('pprod_id'),'dfrom'=>Session::get('pdfrom'),'dto'=>Session::get('pdto')) : 
			$data=array('prod_id'=>'','dfrom'=>date('Y-m-01'),'dto'=>date('Y-m-d'));
			
			if (isset($data['prod_id']) && $data['prod_id']>0):
				$prod=DB::table('acc_products')->where('com_id',$com_id)->where('id',$data['prod_id'])->first();
				$prod_name=''; isset($prod) && $prod->id > 0 ? $prod_name=$prod->name : $prod_name='';
			// for single account
			echo '<tr><td ><h3 class="pull-left">Product-wise Import</h3></td>
				<td class="text-right" ><h3 aling="right">'.$prod_name.'</h3><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h3>Product-wise Import</h3><h5 ></h5></td></tr>';
			endif;
			
		?>
		</table>
            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="6"><a href="{!! url('/importmaster/product?flag=filter') !!}"> Filter  </a>
                <?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['prod_id']) ? $data['prod_id']='' : '' ;
				    // to get data by fileter
					
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'importmaster/pfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('prod_id', $langs['prod_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('prod_id', $products, null, ['class' => 'form-control','required']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  date('Y-m-01'), ['class' => 'form-control', 'id'=>'dfrom','required' ]) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dto', $langs['dto'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dto', date('Y-m-d'), ['class' => 'form-control', 'id'=>'dto','required' ]) !!}
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
                <thead>
                    <tr>
                        <th class="col-md-1">{{ $langs['sl'] }}</th>
                        <th class="col-md-2">{{ $langs['idate'] }}</th>
                        <th class="col-md-2">{{ $langs['ilc_id'] }}</th>
                        <th class="col-md-2">{{ $langs['item_id'] }}</th>
                        <th class="col-md-1 text-right" colspan="2">{{ $langs['qty'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['rate'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>

				{{-- */$x=0;/* --}}
                <?php 
				  		
						isset($data['prod_id']) && $data['prod_id']>0 ?
						$import=DB::table('acc_importmasters')
						->join('acc_importdetails','acc_importmasters.id','=','acc_importdetails.im_id')
						->where('acc_importmasters.com_id',$com_id)->where('item_id', $data['prod_id'])->groupBy('item_id')->groupBy('item_id')->get() : '';
						$amount =''; $im_id=''; $ttl_amts='';
				?>
                @foreach($import as $item)
               
                 	<?php
					$im_id= $item->id; $ilc_id=$data['prod_id'];
					$ttl='';$amounts='';$unitCosts='';$ttls=''; $ttl_amt='';
					$imlc=DB::table('acc_lcimports')->where('com_id',$com_id)->where('id', $item->lcimport_id)->first();  //echo $cur->currency_id;
					$imlc_number='' ;isset($imlc) && $imlc->currency_id>0 ? $imlc_number=$imlc->lcnumber : $imlc_number='' ;
					$imlc_supplier_id='' ;isset($imlc) && $imlc->supplier_id>0 ? $imlc_supplier_id=$imlc->supplier_id : $imlc_supplier_id='' ;
					
					$supplier=DB::table('acc_suppliers')->where('id',$imlc_supplier_id)->first();
					$supplier_name='' ;isset($supplier) && $supplier->id>0 ? $supplier_name=$supplier->name : $supplier_name='' ;

					isset($imlc) && $imlc->currency_id>0 ? $cur_id=$imlc->currency_id : $cur_id='' ;
					$currency=DB::table('acc_currencies')->where('id',$cur_id)->first();
					$currency_name=''; isset($currency) && $currency->id > 0 ? $currency_name=$currency->name : $currency_name='';
					
					$details=DB::table('acc_importdetails')->where('acc_importmasters.com_id',$com_id)
					->join('acc_importmasters','acc_importdetails.im_id','=','acc_importmasters.id')
					->whereBetween('idate', [$data['dfrom'], $data['dto']])
					->where('item_id', $item->item_id)->get(); 
					?>
                        @foreach($details as $item)
                         {{-- */$x++;/* --}}
                        <?php 
							$ttl_amt+=$item->amount;
							$sum=DB::table('acc_importdetails')->where('com_id',$com_id)->where('im_id', $im_id)->sum('amount'); 
							$amount=DB::table('acc_trandetails')->where('com_id',$com_id)->where('ilc_id', $data['prod_id'])->sum('amount'); 
							
							$amount > 0 ? $amounts=number_format($amount,2) : '';
							$item->amount> 0 ? $item->amount=number_format($item->amount, 2) : '';
							$item->rate> 0 ? $item->rate=number_format($item->rate, 2) : '';
							$item->user_id > 0 ? $person=$users[$item->user_id] : $person='';
							$product=DB::table('acc_products')->where('com_id',$com_id)->where('id',$item->item_id)->first();

							isset($product) && $product->id > 0 ? $product_name=$product->name : $product_name='';
							$unit_id=''; isset($product) && $product->id > 0 ? $unit_id=$product->unit_id : $unit_id='';
							$unit = DB::table('acc_units')->where('id',$unit_id)->first(); 
							$unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name : $unit_name='';
							
							$entry_has='';
						?>
                         <tr>
                        	<td>{{ $x }}</td>
                            <td>{{ $item->idate }}/Invoice: {{ $item->invoice }}</td>
                            <td>{{ $imlc_number }}/{{ $supplier_name }}</td>
                            <td>{{ $product_name }}</td>
                            <td id="unit">{{ $unit_name }}</td><td class=" text-right">{{ $item->qty }}</td>
                            <td id="cur">{{ $currency_name }}</td><td class=" text-right">{{ $item->rate }}</td>
                            <td id="cur">{{ $currency_name }}</td><td class=" text-right">{{ $item->amount }}</td>
                         </tr>
                        @endforeach 
                @endforeach
                </tbody>
            </table>
			
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Import->Cost Sheet</td><td class="text-right">Report generated by: </td></tr>
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
