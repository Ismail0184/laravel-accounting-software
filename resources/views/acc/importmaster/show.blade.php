@extends('app')

@section('htmlheader_title', 'Purchasemaster')

@section('contentheader_title', 'Import')

@section('main-content')
<style>
	#field{ width:150px; text-align:right}
	#unit { width:30px}  
	#rate { width:30px}  
	#amt  { width:30px}
</style>
<div class="container" >
<div class="box">
        <div class="box-body" align="center">
                	<?php 	
							Session::has('com_id') ? 
							$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

							Session::put('im_id', $importmaster->id);
							$cur_name=''; $lc_value='';$lc_numbers='';
							$lcimport = DB::table('acc_lcimports')->where('id',$importmaster->lcimport_id)->first();
							if (isset($lcimport) && $lcimport->id >0 ):
								$cur=DB::table('acc_currencies')->where('id',$lcimport->currency_id)->first() ;
								isset($cur) && $cur->id > 0 ? $cur_name=$cur->name : $cur_name='';
								$lc_value=$lcimport->lcvalue;
								$lc_numbers=$lcimport->lcnumber;
							endif;
							$im_amount=DB::table('acc_importdetails')->where('im_id',$importmaster->id)->sum('amount') ;
							$max=$lc_value-$im_amount; $max < 0 ? $max=substr($max,1) : '';
							
							
					?>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th id="field">{{ $langs['idate'] }}</th>
                            <td><a href="{{ url('/importmaster') }}">{{ $importmaster->idate }}</a></td>
                             
                            <th id="field">{{ $langs['lcimport_id'] }}</th>
                            <td>{{ $lc_numbers }}</td>

                        </tr>
                       
                        <tr>
                            <th id="field">{{ $langs['invoice'] }}</th>
                            <td>{{ $importmaster->invoice }}</td>
                            <th id="field">{{ $langs['lcvalue'] }}</th>
                            <td>{{ $cur_name.': '.$lc_value.'/'.$max }}</td>
                        </tr>
                    </table>
                    
                    <h3 class="text-left">Transaction Details</h3>
   			 <table class="table table-bordered">   
             	<tr>
                	<th class="text-center">SL</th>
                    <th>Product</th>
                    <th class="text-right" colspan="2">Quantity</th>
                    <th class="text-right" colspan="2">Rate</th>
                    <th class="text-right" colspan="2">Amount</th>
                    
                    <th class="text-right"></th>
                    
                </tr>             
                  <?php 
				  	 	$units=array('1'=>'PCS', '2'=>'Dozen');
				  		$x=0; $ttl=0;
				  		$record = DB::table('acc_importdetails')->where('im_id', $importmaster->id)->get(); 
						foreach($record as $item):
						$x++; $ttl+=$item->amount;
						
						$product_name=''; $unit_name='';$unit_id='';
						$product = DB::table('acc_products')->where('id',$item->item_id)->first(); 
						if(isset($product) && $product->id > 0):
						  	$product_name=$product->name ;
							isset($product) && $product->id > 0 ? $unit_id=$product->unit_id : $unit_id='';
							$unit = DB::table('acc_units')->where('id',$unit_id)->first(); 
							isset($unit) && $unit->id > 0 ? $unit_name=$unit->name : $unit_name='';
						endif;
							echo "<tr><td class='text-center'>$x</td>
							<td>$product_name</td>
							<td class='text-right'>$item->qty</td><td id='unit'>$unit_name</td>
							<td class='text-right'>".number_format($item->rate,2)."</td><td id='rate'>$cur_name</td>
							<td class='text-right'>".number_format($item->amount,2)."</td><td id='amt'>$cur_name</td>"; 
							
							?>
                            
                            {!! Form::open(['route' => ['importdetail.destroy', $item->id], 'method' => 'DELETE']) !!}
							<td width="40px"><a class="btn btn-edit btn-block" role="button" title="{{ $langs['edit'] }}" href="{{ URL::route('importdetail.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td>
                            <td width="40px">{!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'],'role'=>'button' ,'onclick' => 'return confirm("Are you sure?");']) !!}</td>
                            {!!  Form::close() !!}
                            <?php echo "</tr>"; 
						endforeach;
						echo "<tr><td colspan='6' class='text-right'>Total</td><td class='text-right'>".number_format($ttl)."</td><td id='amt'>$cur_name</td><td width='150px'></td></tr>";

				  ?>
                    
  			 </table>                 
                    
                    
{!! Form::open(['route' => 'importdetail.store', 'class' => 'form']) !!}
 <div style="background-color:#0F9">
   
   <table class="table table-bordered">
   				<tr><td>
					<div class="form-group">
                        {!! Form::label('item_id', $langs['item_id']) !!}
                            {!! Form::select('item_id', $products, null, ['class' => 'form-control select2', 'required', 'style' => 'width: 200px;']) !!}
                    </div>
   				</td><td>
					<div class="form-group">
                        {!! Form::label('qty', $langs['qty']) !!}
                            {!! Form::text('qty', null, ['class' => 'form-control', 'required', 'id'=>'qtys', 'style' => 'width: 150px']) !!}

                    </div>
     			</td><td>                
					<div class="form-group">
                        {!! Form::label('rate', $langs['rate']) !!}
                            {!! Form::text('rate', null, ['class' => 'form-control', 'required', 'id'=>'rates', 'style' => 'width: 200px']) !!}
                    </div>
	 			</td><td>
                	<div class="form-group">
                    	{!! Form::hidden('im_id', $importmaster->id) !!} 
                        {!! Form::label('amount', $langs['amount']) !!}
                            {!! Form::text('amount', null, ['class' => 'form-control', 'required', 'id'=>'amount', 'style' => 'width: 200px', 'max'=>$max]) !!}
                    </div>
     			</td><td>                
					<div class="form-group">
                        {!! Form::label('for', $langs['for']) !!}
                            {!! Form::select('for', array('Sale'=>'Sale','Guarantee'=>'Guarantee'),null, ['class' => 'form-control', 'required', 'id'=>'rates', 'style' => 'width: 200px']) !!}
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
                </div>
		</div>
</div>

@endsection
@section('custom-scripts')

<script>
var x = document.getElementById("amount");
x.addEventListener("focus", myFocusFunction, true);

function myFocusFunction() {
    document.getElementById("amount").value = document.getElementById("qtys").value*document.getElementById("rates").value;  
}

</script>
<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".form").validate();
    });
        
</script>
@endsection