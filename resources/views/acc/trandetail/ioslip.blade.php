@extends('app')

@section('htmlheader_title', 'Daily Transaction')

@section('contentheader_title', 	  ' Daily Transaction')
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
	.space { padding-left:30px; padding-right:30px}
</style>
<?php 
		function subhead($id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$sh=DB::table('acc_subheads')->where('com_id',$com_id)->where('id',$id)->first();
			if (isset($sh) && $sh->id>0 ):
				return $sh->name;
			else:
				return '';
			endif;
		}
		function has($id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$stock=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$id)->sum('qty');
			if (isset($stock) ):
				return $stock;
			else:
				return 0;
			endif;
		}
	$ttle='';$ttles='';
 ?>
 <div class="container">
 <div class="box" >
 <div class="box" >
         <div class="box-header">
        <a href="{{ url('invenmaster/ledger_print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
        </div><!-- /.box-header -->

    <div class="table-responsive">
        <table  width="100%>
        <?php 
			isset($_GET['item_id']) && $_GET['item_id']>0 ? Session::put('lgprod_id',$_GET['item_id']) : '';
			
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 




			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h1 align="center">'.$com_name.'</h1></td></tr>';
			// data collection filter method by session	
			$data=array('dfrom'=>date('Y-m-01'),'dto'=>date('Y-m-d'));
			
			Session::has('iodto') ? $data=array('dfrom'=>Session::get('iodfrom'),'dto'=>Session::get('iodto') ) : ''; 
		

				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h5>Daily Expenditure</h5><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';

		?>
            <tr><td colspan="8"><a href="{!! url('/trandetail/ioslip?flag=filter') !!}"> Filter  </a>
        					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['prod_id']) ? $data['prod_id']='' : '' ;
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'trandetail/iofilter', 'class' => 'form-horizontal']) !!}
                            <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',$data['dfrom'], ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dto', $langs['dto'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dto',$data['dto'], ['class' => 'form-control','required']) !!}
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
        <?php 
			$opening=$op_mc+$op_afe; $opening>0 ? $openings=number_format($opening) : $openings='('.number_format(substr($opening,1)).')';
			$closing=$cb_mc+$cb_afe; $closing>0 ? $closings=number_format($closing) : $closings='('.number_format(substr($closing,1)).')';
		
		?>
        <tr><td class="text-left space"> Opening Balance : {{ $openings }} ({{ 'Main Cash: '.$op_mc.'- AFE: '.$op_afe}})</td><td class="text-right space">Clossing Balance: {{ $closings }}</td></tr>
        </table>

<!--        <div class="col-md-12">
-->			<div class="col-md-6">
            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center" width>{{ $langs['sl'] }}</th>
                        <th class="">Bank Receipt</th>
                        <th class="text-right">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
				@foreach($bankreceipt as $item)
                {{-- */$x++;/* --}}
            	<tr>
                    <td width="50" class="text-center">{{ $x }}</td>
                	<td>{{ $item->name }}</td>
                    <td class="text-right">{{ $item->amount }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            
			<div class="col-md-6">
            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center" width>{{ $langs['sl'] }}</th>
                        <th class="">Bank Payment</th>
                        <th class="text-right">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
				@foreach($bankexpenses as $item)
                {{-- */$x++;/* --}}
            	<tr>
                    <td width="50" class="text-center">{{ $x }}</td>
                	<td>{{ $item->name }}</td>
                    <td class="text-right">{{ $item->amount < 0 ? substr($item->amount,1) : $item->amount }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
<!--			</div>
-->   		
<!--            <div class="col-md-12">
-->			<div class="col-md-6">
            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center" width>{{ $langs['sl'] }}</th>
                        <th class="">Cash Receipt</th>
                        <th class="text-right">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}} {{ $ttl='' }}

				@foreach($cashrecipt as $item)
                {{-- */$x++;/* --}}
            	<tr>
                    <td width="50" class="text-center">{{ $x }}</td>
                	<td>{{ $item->name }}</td>
                    <td class="text-right"> @if($item->amount<0){{ substr($item->amount,1) }} @else {{ $item->amount }} @endif </td>
                    </tr>
                    <?php $ttl+=$item->amount<0 ? substr($item->amount,1) : $item->amount ; ?>
                @endforeach
                    <tr><td></td><td class="text-right">Total: </td><td class="text-right">{{ $ttl> 0 ? number_format($ttl,2) : $ttl  }}</td></tr>
                    <tr><td colspan="3"></td></tr>
 
                    <tr><td></td><td class="text-right">Cash Balance</td><td class="text-right">{{ $cb_mc }}</td></tr>
                    <tr><td></td><td class="text-right">Advance For Expenses</td><td class="text-right"><a href="{{ url('/trandetail/afexpense?tdate='.$data['dto']) }}">{{ $cb_afe }}</a></td></tr>


                </tbody>
            </table>
            
            </div>
            
			<div class="col-md-6">
            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">{{ $langs['sl'] }}</th>
                        <th class="">Expense</th>
                        <th class="text-right">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0; $ttle=''; /* --}} 
				@foreach($expenses as $item)
                {{-- */$x++;/* --}}
            	<tr>
                <?php  
					$afe=DB::table('acc_coas')->where('name','Advance For Expenses')->first();
					$afe_id=''; isset($afe) && $afe->id >0 ? $afe_id=$afe->id : $afe_id='';

					$sh=DB::table('acc_trandetails')->select('acc_subheads.name','acc_trandetails.sh_id')
					->join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')
					->join('acc_subheads','acc_trandetails.sh_id','=','acc_subheads.id')
					->where('acc_tranmasters.vnumber', $item->vnumber)->where('acc_id',$afe_id )->where('acc_trandetails.sh_id','>',0)->where('flag',1)->first();
					
				?>
                    <td width="50" class="text-center">{{ $x }}</td>
                	<td><a href="{{ url('/tranmaster', $item->tm_id) }}">
                    {{ $item->name }} /{{ $item->twith->name }}({{ isset($sh->name) && $sh->sh_id>0 ? $sh->name : '' }})
                    </a></td>
                    <td class="text-right">{{ $item->amount }}</td>
                    </tr>
                    <?php $ttle+=$item->amount; 
					?>
                @endforeach
                	<?php $ttle>0 ? $ttles=number_format($ttle,2) : $ttles=''; ?>
                    <tr><td></td><td class="text-right">Total: </td><td class="text-right">{{ $ttles }}</td></tr>
                </tbody>
            </table>
            </div>
            </div>
            
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
