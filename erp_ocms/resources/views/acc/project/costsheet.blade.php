@extends('app')

@section('htmlheader_title', 'Project')

@section('contentheader_title', 'Project-wise Costsheet')

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

			Session::has('prjpro_id') ? 
			$data=array('pro_id'=>Session::get('prjpro_id')) : 
			$data=array('pro_id'=>'');  //echo $data['pro_id'].'osama';
		

				$projectx=DB::table('acc_projects')->where('com_id',$com_id)->where('id',$data['pro_id'])->first();
				$project_name=''; isset($projectx) && $projectx->id>0 ? $lc_number=$projectx->name : $project_name='';
			
			if (isset($data['pro_id']) && $data['pro_id']>0):
			// for single account
				echo '<tr><td ><h3 class="pull-left">Project Cost</h3></td>
					<td class="text-right" ><h3 aling="right">Project Name: '.$project_name.'</h3><h5 ></h5></td></tr>';
			endif;
		?>
        </table>
            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="9"><a href="{!! url('/acc-project/costsheet?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['lc_id']) ? $data['lc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'acc-project/prjfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('pro_id', $langs['pro_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('pro_id', $projects, null, ['class' => 'form-control select2','id'=>'lc_id']) !!}
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
					if($data['pro_id']>0 ):
						$lcinfo=DB::table('acc_trandetails')
						->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
						->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
						->where('acc_coas.com_id',$com_id)
						->where('pro_id',$data['pro_id'])->get();
					endif;
					//->where('acc_coas.topGroup_id','<>',$bs_id)
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