@extends('app')

@section('htmlheader_title', 'Buyer')

@section('contentheader_title', 'LC-wise Costsheet')

@section('main-content')
<style>
	h4, h3 { margin:0px ; padding:0px}
</style>
 <div class="container">
 <div class="box" >
    <div class="table-responsive">
        <table class="table borderless">
        <?php 
			//$path =  $_SERVER['DOCUMENT_ROOT'];
			 //echo $path;
			isset($_GET['id']) && $_GET['id']> 0 && !isset($_GET['ord_id']) ? Session::put('cslc_id', $_GET['id']).Session::put('csord_id', '') : '';
			isset($_GET['ord_id']) && $_GET['ord_id']> 0 && $_GET['id']>0 ? Session::put('csord_id', $_GET['ord_id']).Session::put('cslc_id', $_GET['id']) : '';

			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
       		echo '<tr><td colspan="2"><h3 align="center">'. $com_name.'</h3></td></tr>';

			// data collection filter method by session	
			$data=array('lc_id'=>'','ord_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');

			Session::has('cslc_id') ? 
			$data=array('lc_id'=>Session::get('cslc_id'),'ord_id'=>Session::get('csord_id')) : 
			$data=array('lc_id'=>'','ord_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00'); 
		

				$lc=DB::table('acc_lcinfos')->where('com_id',$com_id)->where('id',$data['lc_id'])->first();
				$lc_number=''; isset($lc) && $lc->id>0 ? $lc_number=$lc->lcnumber : $lc_number='';
			
			if (isset($data['lc_id']) && $data['lc_id']>0 && $data['ord_id']==''):
			// for single account
				echo '<tr><td ><h3 class="pull-left">Process Cost</h3></td>
					<td class="text-right" ><h3 aling="right">LC No: '.$lc_number.'</h3><h5 ></h5></td></tr>';
			elseif (isset($data['ord_id']) && $data['ord_id']>0 &&  $data['lc_id']>0):
				$ord=DB::table('acc_orderinfos')->where('com_id',$com_id)->where('id',$data['ord_id'])->first();
				$ord_number=''; isset($ord) && $ord->id>0 ? $ord_number=$ord->ordernumber : $ord_number='';
				// for multiple account
				echo '<tr><td ><h3 class="pull-left">Process Cost</h3></td>
					<td class="text-right" ><h3 aling="right">LC No: '.$lc_number.'<br>Order No: '.$ord_number.'</h3><h5 ></h5></td></tr>';
			endif;
		?>
        </table>
            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="9"><a href="{!! url('/lcinfo/costsheet?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['lc_id']) ? $data['lc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'lcinfo/csfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('lc_id', $langs['lc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('lc_id', $lcinfos, null, ['class' => 'form-control select2','id'=>'lc_id']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('ord_id', $langs['ord_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('ord_id', $lcinfos, null, ['class' => 'form-control select2','id'=>'ord_id']) !!}
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
                        <th class="col-md-1">{{ $langs['tdate'] }}</th>
                        <th class="col-md-2">{{ $langs['acc_id'] }}</th>
                        <th class="col-md-1 text-right">{{ $langs['debit'] }}</th>
                        <th class="col-md-1 text-right">{{ $langs['credit'] }}</th>
                        <th class="col-md-1 text-right">{{ $langs['balance'] }}</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
					$amount_ttl=''; $amount_ttls=''; $amountttl_USAs='' ;
					$lcinfo=array();
					$bs=DB::table('acc_coas')->where('name','Balance Sheet')->where('com_id',$com_id)->first();
					isset($bs) && $bs->id > 0 ? $bs_id=$bs->id : $bs_id='';
					if($data['lc_id']>0 && $data['ord_id']==''):
						$lcinfo=DB::table('acc_trandetails')
						->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
						->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
						->where('acc_coas.com_id',$com_id)->where('acc_coas.topGroup_id','<>',$bs_id)
						->where('lc_id',$data['lc_id'])->get();
					elseif($data['lc_id']>0 && $data['ord_id']>0):
						$lcinfo=DB::table('acc_trandetails')
						->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
						->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
						->where('acc_coas.com_id',$com_id)->where('acc_coas.topGroup_id','<>',$bs_id)
						->where('lc_id',$data['lc_id'])->where('ord_id',$data['ord_id'])->get();
					
					endif;
					$ttl_amount=''; $ttl_amounts=''; $ttl_debit=''; $ttl_credit=''; $ttl_credits='';$ttl_debits='';
				?>
				{{-- */$x=0;/* --}}
                @foreach($lcinfo as $item)
                {{-- */$x++;/* --}}
                <?php 
				$debit=''; $credit=''; $debits='';$credits ='';$ttl_amounts='';
						$amount=DB::table('acc_trandetails')
						->where('acc_trandetails.com_id',$com_id)
						->where('acc_id',$item->acc_id)
						->where('lc_id',$data['lc_id'])->sum('amount');
						$amount >0 ? $debit=$amount : '';
						$amount <0 ? $credit=$amount : '';
						$ttl_amount +=$amount;
						$debit> 0 ? $debits=number_format($debit,2) : '';
						$credit < 0 ? $credits=substr(number_format($credit,2),1) : '';
						
						if ($ttl_amount <0):
							$ttl_amounts=substr(number_format($ttl_amount,2),1).' Cr';
						elseif($ttl_amount >0): 
							$ttl_amounts=number_format($ttl_amount,2).' Dr';
						endif;
						$ttl_debit += $debit; 
						$ttl_credit += $credit; 
				?>
                <tr>
                        <td class="">{{ $item->tdate }}/{{ $item->vnumber }}</td>
                        <td class="">{{ $item->name }}</td>
                        <td class="text-right">{{ $debits }}</td>
                        <td class="text-right">{{ $credits }}</td>
                        <td class="text-right">{{ $ttl_amounts }}</td>

                 </tr>
                @endforeach
                <?php 
					$ttl_credit <0 ? $ttl_credits=substr(number_format($ttl_credit,2),1) : '';
					$ttl_debit > 0 ? $ttl_debits=number_format($ttl_debit, 2) : '';
				?>
                <tr><td></td><td></td><td class="text-right">{{ $ttl_debits }}</td><td class="text-right">{{ $ttl_credits }}</td><td></td></tr>
                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Export->Lc info->Costsheet</td><td class="text-right">Report generated by: </td></tr>
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
		
			$("#lc_id").change(function() {
            $.getJSON("{{ url('tranmaster/order')}}/" + $("#lc_id").val(), function(data) {
                var $courts = $("#ord_id");
                $courts.empty();
                $.each(data, function(index, value) {
                    $courts.append('<option value="' + index +'">' + value + '</option>');
                });
            $("#ord_id").trigger("change");
            });
        });

    });
        
</script>

@endsection