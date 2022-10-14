@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Pbudget')

@section('contentheader_title', ' Cost Sheet')

<style>
    table.borderless td,table.borderless th{
     border: none !important; margin:0px; padding:0px
	}

	h1{
		font-size: 1.6em;
	}
	h5{
		font-size: 2em; margin:0px; font-weight:bold; margin:opx; padding:0px;
	}
	#cur {width: 10px}
	body { padding:0px}
	#opn { margin:opx; padding:0px;}
	#dt { width:15%;} 
	#nt { width:30%; } 
</style>

@section('main-content')
 <div class="container">
 <div class="box" >
    <div class="table-responsive">
        <table  width="100%>
        <tr><td colspan="2"><h1 align="center">OCMS</h1></td></tr>
        <?php 
			// data collection filter method by session	
			$data=array('acc_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');

			Session::has('oacc_id') ? 
			$data=array('acc_id'=>Session::get('oacc_id')) : ''; 
		
			if (isset($data['acc_id']) && $data['acc_id']>0):
				// for single account
				echo '<tr><td ><h3 class="pull-left">Order-wise Cost Sheet</h3></td>
				<td class="text-right" ><h3 aling="right">'.$lcinfos[$data['acc_id']].'</h3><h5 ></h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h5>General Ledger</h5><h5 ></h5></td></tr>';
			endif;

		?>
        
        </table>

            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="9"><a href="{!! url('/orderinfo/costsheet?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'orderinfo/filter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $orders, null, ['class' => 'form-control']) !!}
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
                        <th class="col-md-1" id="dt">{{ $langs['tdate'] }}</th>
                        <th class="col-md-1" id="nt">{{ $langs['acc_id'] }}</th>
                         <th class="col-md-2" id="nt">{{ $langs['note'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['debit'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['credit'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['balance'] }}</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
						//  filter wise acc_id based data collection 
						!isset($data['acc_id']) && $data['acc_id'] > 0 ?  
						$tran=DB::table('acc_coas')->where('id', $data['acc_id'])->groupBy('acc_coas.id')->get() : 
						$tran=DB::table('acc_coas')->select('acc_coas.id as id')
						->join('acc_trandetails', 'acc_coas.id', '=','acc_trandetails.acc_id')
						->where('ord_id', '=', $data['acc_id'])
						->groupBy('acc_coas.id')->get();
						
						$cur='Tk'; $debit=0; $credit=0; $balance=0; $ttl=0; //$balances='';
						
				?>
                  @foreach($tran as $item)
                  			<?php 
							// account-wise data 
							$details=DB::table('acc_trandetails')->where('acc_id', $item->id)->orderBy('acc_trandetails.id')->get() ;
							if (isset($data['dfrom'])):
								// account and date-wise data
								$details=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
								->where('acc_trandetails.acc_id', $item->id)
								->orderBy('acc_tranmasters.id')
								->get();
							endif;
							$opb='';
							$balances='';$balance=0; $ttl_debit=''; $ttl_credit=''; $ttl_balances='';
							$opb!='' ? $balance=$opb : '';  $tdcur=''; $tccur='';
							$opb> 0 ? $ttl_debit=$opb :  $ttl_credit=$opb;
							?>
                        
                        @foreach($details as $item)
                        <?php 

							$debit=''; $credit=''; $bc=''; $dcur=''; $ccur=''; 
							// to tal calculation
							$ttl+=$item->amount; $balance += $item->amount;
							// make different debit and credit
							$item->amount>0 ? $debit=number_format($item->amount, 2) :  '' ; 
							$item->amount<0 ? $credit= substr(number_format($item->amount, 2),1) : '' ;
							
							$debit!='' ? $dcur=$cur : $dcur=''; $credit!='' ? $ccur=$cur : $ccur='';
							// make total of debit and credit and thier currency
							$item->amount>0 ? $ttl_debit += $item->amount :  $ttl_credit += $item->amount ; 
							$ttl_debit!='' ? $tdcur=$cur : $tdcur=''; $ttl_credit!='' ? $tccur=$cur : $tccur='';
 							// to get tranmaster data	
							$master	   = DB::table('acc_tranmasters')->where('id', $item->tm_id)->first(); //echo $master->tdate;
							// to make sign Dr or Cr behind balance 
							$balance<0 ? $balances=substr(number_format($balance,2), 1).' '.$bc='Cr' : $balances= number_format($balance,2).' '. $bc='Dr';
							
							$master->person!='' ? $person=', ' .$master->person  : $person='';
						?>
                         <tr>
                            <td>{{ $master->tdate }}</td>
                            <td>{{ $acccoa[$item->acc_id] }}</td>
                            <td>{{ $master->note }} {{ $person }}</td>
                            <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }}</td>
                            <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $credit }}</td>
                            <td id="cur">{{ $cur }}</td><td class=" text-right">{{ $balances }}</td>
                             </tr>
                        @endforeach  

                   @endforeach 
                        <?php $ttl_debit>0 ? $ttl_debit = number_format($ttl_debit, 2) : ''; 
						$ttl_credit<0 ? $ttl_credit=substr(number_format($ttl_credit,2),1) : $ttl_credit=''; ?>
                        <tr>
                        	<td colspan="3" class="text-right">Total</td>
                        	<td id="cur">{{ $tdcur }}</td><td class=" text-right">{{ $ttl_debit }}</td>
                            <td id="cur">{{ $tccur }}</td><td class=" text-right">{{ $ttl_credit }}</td>
                            <td id="cur"></td><td class=" text-right">{{ $ttl_balances }}</td>
                        </tr> 
                        <!--<tr><td colspan="6" class=" text-right">Total</td><td id="cur">{{ $cur }}<td class=" text-right">{{ $ttl }}</td></tr> -->

                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Transaction->Cost Sheet</td><td class="text-right">Report generated by: </td></tr>
                </table>
            </div><!-- /.box-header -->
        </div>
     </div>
</div>
@endsection
@section('custom-scripts')

    jQuery(document).ready(function($) {        
        $(".tranmaster").validate();
		$( "#dfrom" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		$( "#dto" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
