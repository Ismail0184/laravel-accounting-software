@extends('app')

@section('htmlheader_title', 'Purchasemaster')

@section('contentheader_title', 'Import')

@section('main-content')
<style>
	#field{ width:150px; text-align:right}
	#unit { width:30px}  
	#rate { width:30px}  
	#amt  { width:30px}
		h1{
		font-size: 1.6em;
	}
	h5{
		font-size: 1.2em; margin:0px
	}

</style>
 <div class="container">
 <div class="box" >
    <div class="table-responsive">
        <div class="box-header">
		<table  width="100%>
        <?php 
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
			$com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			
			$data=array('prod_id'=>'','dfrom'=>'','dto'=>'');
			
			Session::has('idprod_id') ? 
			$data=array('prod_id'=>Session::get('idprod_id'),'dfrom'=>Session::get('iddfrom'),'dto'=>Session::get('iddto')) : 
			$data=array('prod_id'=>'','dfrom'=>'','dto'=>'');

			echo '<tr><td colspan="2"><h2 align="center">'.$com_name.'</h2></td></tr>';

			if (isset($data['prod_id']) && $data['prod_id']>0):
				$prod=DB::table('acc_products')->where('com_id',$com_id)->where('id',$data['prod_id'])->first();
				$products_name=''; isset($prod) && $prod->id > 0 ? $products_name=$prod->name : $products_name='';
			// for single account
			echo '<tr><td ><h3 class="pull-left">Products-wise Import</h3></td>
				<td class="text-right" ><h3 aling="right">'.$products_name.'</h3><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h3>Products-wise Import</h3><h5 ></h5></td></tr>';
			endif;

		?>
        </table>
   			 <table class="table table-bordered">   
                      <tr><td colspan="6"><a href="{!! url('/importmaster/imdetails?flag=filter') !!}"> Filter  </a>
                <?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['supplier_id']) ? $data['supplier_id']='' : '' ;
				    // to get data by fileter
					
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'importmaster/idfilter', 'class' => 'form-horizontal']) !!}
            
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
       	<tr>
                	<th class="text-center">SL</th>
                    <th>Import Details</th>
                    <th>Product</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Rate</th>
                    <th class="text-right">Amount</th>
                </tr>             
                  <?php   

				  		$x=0; $ttl=0;$currency_name='';$unit='';
				  		$record =array();
						if(isset($data['prod_id']) && $data['prod_id']>0):
							$record = DB::table('acc_importdetails')
							->join('acc_importmasters','acc_importdetails.im_id','=','acc_importmasters.id')
							->where('item_id',$data['prod_id'])
							->whereBetween('idate', [$data['dfrom'], $data['dto']])
							->where('acc_importmasters.com_id', $com_id)->get(); 
						endif;
						
						foreach($record as $item):
						$x++; $ttl+=$item->amount;
								$product = DB::table('acc_products')->where('com_id',$com_id)->where('id',$item->item_id)->first(); 
								$product_name=''; isset($product) && $product->id > 0 ? $product_name=$product->name : $product_name=''; 
								$unit_id=''; isset($product) && $product->id > 0 ? $unit_id=$product->unit_id : $unit_id=''; 
								$unit = DB::table('acc_units')->where('id',$unit_id)->first(); 
								$unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name : $unit_name=''; 
								
								$lcimpost = DB::table('acc_lcimports')->where('com_id',$com_id)->where('id',$item->lcimport_id)->first(); 
								$cur_id=''; isset($lcimpost) && $lcimpost->id > 0 ? $cur_id=$lcimpost->currency_id : $cur_id=''; 
								$imp_details=$lcimpost->lcnumber.','.$lcimpost->lcdate;

								$supplier = DB::table('acc_suppliers')->where('com_id',$com_id)->where('id',$lcimpost->supplier_id)->first(); 
								$supplier_name=''; isset($supplier) && $supplier->id > 0 ? $supplier_name=$supplier->name : $supplier_name=''; 
								$imp_details=$imp_details.', '.$supplier_name;
								$cur = DB::table('acc_currencies')->where('id',$cur_id)->first(); 
								$cur_name=''; isset($cur) && $cur->id > 0 ? $cur_name=$cur->name : $cur_name=''; 
								
							echo "<tr><td class='text-center'>$x</td>
							<td>$imp_details</td>
							<td>$product_name</td>
							<td class='text-right'>".$item->qty .''.$unit_name. "</td>
							<td class='text-right'>".number_format($item->rate)."</td>
							<td class='text-right'>".number_format($item->amount).'/'.$cur_name."</td>
							</tr>"; 
						endforeach;
						echo "<tr><td colspan='4' class='text-right'>Total</td><td class='text-right'>".number_format($ttl)."</td></tr>";

				  ?>
                    
  			 </table>                 
                    <div class="box-header">
                        <table class="table borderless">
                        <tr><td class="text-left">Source: Import->Supplier</td><td class="text-right">Report generated by: </td></tr>
                        </table>
                    </div><!-- /.box-header -->
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
