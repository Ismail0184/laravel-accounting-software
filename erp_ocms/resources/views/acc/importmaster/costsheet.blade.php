@extends('app')

@section('htmlheader_title',  ' Cost Sheet')

@section('contentheader_title', 	  ' Cost Sheet')
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
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h2 align="center">'.$com_name.'</h2></td></tr>';

			$data=array('acc_id'=>'');
			
			Session::has('imacc_id') ? 
            $data=array('acc_id'=>Session::get('imacc_id')) : ''; 

			if (isset($data['acc_id']) && $data['acc_id']>0):
				$im=DB::table('acc_lcimports')->where('com_id',$com_id)->where('id',$data['acc_id'])->first();
				$im_lcnumber=''; isset($im) && $im->id > 0 ? $im_lcnumber=$im->lcnumber : $im_lcnumber='';
			// for single account
			echo '<tr><td ><h3 class="pull-left">Import Cost Sheet</h3></td>
				<td class="text-right" ><h3 aling="right">'.$im_lcnumber.'</h3><h5 ></h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h3>Import Cost Sheet</h3><h5 ></h5></td></tr>';
			endif;
			
			$pending_lc=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Pending LC Import')->first();
			$ca=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Current Assets')->first();
			isset($ca) && $ca->id > 0 ? $g=$ca->id : $g='';
			$bs=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Balance Sheet')->first();
			isset($bs) && $bs->id > 0 ? $tg=$bs->id : $tg='';
			$ttl_amts='';
		?>
        @if(!isset($pending_lc))
           <div class="callout callout-info col-sm-12">
            <h4>Create Account Head!</h4>
            
            <div class="form-group">
                <div class="form-group col-sm-4" style="padding-right:0px; padding-left:0px; "> 
                <ul>
                	<li><a href="{{ url('/acccoa/create?name=Pending LC Import'.'&g='.$g.'&tg='.$tg) }}">Pending LC Import</a></li>
                </ul>
                </div>
            </div>
          </div>
		@endif
		</table>
            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="11"><a href="{!! url('/importmaster/costsheet?flag=filter') !!}"> Filter  </a>
                <?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
				    // to get data by fileter
					
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'importmaster/csfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('ilc_id', $langs['ilc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $lcimports, null, ['class' => 'form-control']) !!}
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
                        <th class="col-md-3">{{ $langs['item_id'] }}</th>
                        <th class="col-md-1 text-right" colspan="2">{{ $langs['qty'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['rate'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['amount'] }}</th>
                        <th class="col-md-1 text-right" >Ratio</th>
                        <th class="col-md-1 text-right" >Unit Cost</th>
                        <th class="col-md-1 text-right" >Total</th>
                    </tr>
                </thead>
                <tbody>
        		{!! Form::open(['route' => 'invenmaster.store', 'class' => 'form-horizontal']) !!}
				{{-- */$x=0;/* --}}
                <?php 
						$vnumber_inv = DB::table('acc_invenmasters')->where('com_id',$com_id)->max('vnumber')+1;  //echo $com_id;
						$vnumber_tran = DB::table('acc_tranmasters')->where('com_id',$com_id)->max('vnumber')+1;  //echo $com_id;
				  		
						isset($data['acc_id']) && $data['acc_id']>0 ?
						$import=DB::table('acc_importmasters')->where('com_id',$com_id)->where('lcimport_id', $data['acc_id'])->get() : '';
						$amount =''; $im_id='';
				?>
                @foreach($import as $item)
               
                 	<?php
					$im_id= $item->id; $ilc_id=$data['acc_id'];
					$ttl='';$amounts='';$unitCosts='';$ttls=''; $ttl_amt='';
					$cur=DB::table('acc_lcimports')->where('com_id',$com_id)->where('id', $item->lcimport_id)->first();  //echo $cur->currency_id;
					$cur->currency_id>0 ? $cur=$currency[$cur->currency_id]: $cur='' ;
					
					$details=DB::table('acc_importdetails')->where('com_id',$com_id)->where('im_id', $item->id)->get(); 
					?>
                        @foreach($details as $item)
                         {{-- */$x++;/* --}}
                        <?php 
							$ttl_amt+=$item->amount;
							$sum=DB::table('acc_importdetails')->where('com_id',$com_id)->where('im_id', $im_id)->sum('amount'); 
							$amount=DB::table('acc_trandetails')->where('com_id',$com_id)->where('ilc_id', $data['acc_id'])->sum('amount'); 
							
							$ratio=''; $sum>0 ? $ratio=$item->amount/$sum*100 : ''; $ratio > 0 ? $ratio=number_format($ratio, 4) : '';
							
							$amount>0 ? $unitCost=$amount/100*$ratio/$item->qty : $unitCost=''; $unitCost > 0 ? $unitCosts=number_format($unitCost, 2) : '';
							$ttl= $unitCost * $item->qty; $ttl> 0 ? $ttls=number_format($ttl,2) : '';
							
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
                            <td>{{ $product_name }}</td>
                            <td id="unit">{{ $unit_name }}</td><td class=" text-right">{{ $item->qty }}</td>
                            <td id="cur">{{ $cur }}</td><td class=" text-right">{{ $item->rate }}</td>
                            <td id="cur">{{ $cur }}</td><td class=" text-right">{{ $item->amount }}</td>
                            <td class="text-right">{{ $ratio }}%</td>
                            <td class="text-right">{{ $unitCosts }}</td>
                            <td class="text-right">{{ $ttls }}</td>
                         </tr>
                            <input type="hidden" name="item_id[]" value="{{ $item->item_id }}" />
                            <input type="hidden" name="qty[]" value="{{ $item->qty }}" />
                            <input type="hidden" name="unitCost[]" value="{{ $unitCost }}" />
                            <input type="hidden" name="vnumber" value="{{ $vnumber_inv }}" />
                            <input type="hidden" name="itype" value="Receive" />
                            <input type="hidden" name="idate" value="{{ date('Y-m-d')}}" />
                            <input type="hidden" name="unit_id[]" value="{{ $item->unit_id }}" />
                            <input type="hidden" name="amount" value="{{ $amount }}" />
                            <input type="hidden" name="person" value="{{ $person }}" />
                            <input type="hidden" name="note" value="{{ $lcimports[$data['acc_id']] }}" />
                            
                        @endforeach 
                        
                        <?php 
						 
							$ttl_amt > 0 ? $ttl_amts=number_format($ttl_amt, 2): ''; 
							$acc=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Pending LC Import')->first();
							$acc_id=''; isset($acc) && $acc->id>0 ? $acc_id=$acc->id : $acc_id=''; 
							
							$tranwith=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Inventory')->first();
							$tranwith_id=''; isset($tranwith) && $tranwith->id>0 ? $tranwith_id=$tranwith->id : $tranwith_id=''; 
							
							// check entry 
							$check_entry = DB::table('acc_tranmasters')->where('com_id',$com_id)->where('note', $lcimports[$data['acc_id']] )->first();
							isset($check_entry) && $check_entry->vnumber>0 ? $entry_has='yes' : $entry_has='no' ; //echo $entry_has.'<br>'; echo $amount;
							?> 
                         	<input type="hidden" name="acc_id" value="{{ $acc_id }}" />
                            <input type="hidden" name="tranwith_id" value="{{ $tranwith_id }}" />
                            <input type="hidden" name="vnumbers" value="{{ $vnumber_tran }}" />
                            <input type="hidden" name="ilc_id" value="{{ $ilc_id }}" />
                            <input type="hidden" name="check" value="import" />

                        <tr><td colspan="7" class=" text-right">Total</td><td class=" text-right">{{ $ttl_amts }}</td><td></td><td></td><td class="text-right">{{ $amounts }}</td></tr> 
                @endforeach
				<tr><td colspan="11" class=" text-right">
                			{!! Form::hidden('flag','addstore') !!} 
                			{!! Form::hidden('check','import') !!} 
                            @if($amount>0 && $entry_has=='no')
                        		{!! Form::submit($langs['addstore'], ['class' => 'btn btn-primary']) !!}
                            @elseif($amount>0 && $entry_has=='yes')
                            	Already Stored
                            @endif
                </td></tr> 
            {!! Form::close() !!}
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
		$( "#c_date" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
