@extends('app')

@section('htmlheader_title', 'Cheque Register')

@section('contentheader_title', 'Cheque Register')

@section('main-content')

<style>
    table.borderless td,table.borderless th{
     border: none !important; margin:0px; padding:0px
	}


	#cur {width: 10px}
	.container { width:auto;}
	body { padding:0px}
	#opn { margin:opx; padding:0px;}
	#dt { width:15%;} 
	#nt { width:30%; } 
	
</style>
 <div class="container">
 <div class="box" >
    <div class="table-responsive">
    	<?php	
		$user_name=''; Session::has('user_name') ? $user_name=Session::get('user_name') : $user_name='';

		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		$edit_disabled='';
		?>
        <table  width="100%>
        <tr><td colspan="2"><h2 align="center">{{ $com_name }}</h2></td></tr>
        <?php 
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';			
				// data collection filter method by session	
			$data=array('acc_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');
			
			Session::has('crdto') ? 
			$data=array('acc_id'=>Session::get('cracc_id'),'dfrom'=>Session::get('crdfrom'),'dto'=>Session::get('crdto')) : ''; 
		
			if (isset($data['acc_id']) && $data['acc_id']>0):
				// for single account
				$acc=DB::table('acc_coas')->where('id',$data['acc_id'])->first();
				$acc_head=''; isset($acc) && $acc->id>0 ? $acc_head=$acc->name : $acc_head='';
				echo '<tr><td ><h4 class="pull-left">Cheque Issue Register</h4></td>
				<td class="text-right" ><h3 aling="right">'.$acc_head.'</h3><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h5>General Ledger</h5><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			endif;
			$dcur='';
		?>
        
        </table>

            <table id="buyerinfo-table" class="table table-bordered ">
                <thead>
                <tr><td colspan="8"><a href="{!! url('/tranmaster/cheqregister?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'tranmaster/crfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $coa, null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  null, ['class' => 'form-control', 'id'=>'dfrom', 'required']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dto', $langs['dto'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dto',  date('Y-m-d'), ['class' => 'form-control', 'id'=>'dto', 'required']) !!}
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
                        <th class="col-md-1 text-center" id="vn">{{ $langs['vnumber'] }}</th>
                        <th class="col-md-1" id="">{{ $langs['tdate'] }}</th>
                        <th class="col-md-6" id="">{{ $langs['description'] }}</th>
                        <th class="col-md-2" id="">{{ $langs['c_number'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
						//  filter wise acc_id based data collection 
						isset($data['acc_id']) && $data['acc_id'] > 0 ?  
						$tran=DB::table('acc_coas')->where('id', $data['acc_id'])->groupBy('acc_coas.id')->get() : 
						$tran=DB::table('acc_coas')->select('acc_coas.id as id')
						->join('acc_trandetails', 'acc_coas.id', '=','acc_trandetails.acc_id')
						->groupBy('acc_coas.id')->get();
						
						$cur='Tk'; $debit=0; $credit=0; $balance=0; $ttl=0; //$balances='';
						
				?>
                  @foreach($tran as $item)
                  			<?php 
							
							//$acchead= $data['acc_id']=='' ? "<h4>".$acccoa[$item->id]."</h4>" : '';
							//DB::table('acc_coas1')->get();
							// account-wise data 
							$details=DB::table('acc_trandetails')->where('acc_id', $item->id)->orderBy('acc_trandetails.id')->get() ;
							if (isset($data['dfrom'])):
								// account and date-wise data
								$details=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
								->where('acc_trandetails.tranwiths_id', $item->id)
								->where('amount','>', 0)
								->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
								->orderBy('acc_tranmasters.id')
								->get();
							endif;
							 
							$balances='';$balance=0; $ttl_debit=''; $ttl_credit=''; $ttl_balances=''; $tdcur='';
							?>
                        
                        @foreach($details as $item)
                        <?php 
							
							//echo $item->amount;
							$debit=''; $credit=''; $bc=''; $dcur=''; $ccur=''; 
							// to tal calculation
							$ttl+=$item->amount; $balance += $item->amount;
							// make different debit and credit
							$debit=number_format($item->amount, 2); 
							
							$debit!='' ? $dcur=$cur : $dcur=''; $credit!='' ? $ccur=$cur : $ccur='';
							// make total of debit and credit and thier currency
							$item->amount>0 ? $ttl_debit += $item->amount :  $ttl_credit += $item->amount ; 
							$ttl_debit!='' ? $tdcur=$cur : $tdcur=''; $ttl_credit!='' ? $tccur=$cur : $tccur='';
 							// to get tranmaster data	
							$master	   = DB::table('acc_tranmasters')->where('id', $item->tm_id)->first(); //echo $master->tdate;
							// to make sign Dr or Cr behind balance 
							$balance<0 ? $balances=substr(number_format($balance,2), 1).' '.$bc='Cr' : $balances= number_format($balance,2).' '. $bc='Dr';
							
							$notes=''; 
							$item->acc_id>0 ?
							$coa = DB::table('acc_coas')->where('com_id',$com_id)->where('id',$item->acc_id)->first() : ''; 
							isset($coa) && $coa->id>0  ? $notes =$coa->name : '' ; 
							
							$subhead='';
							$item->sh_id>0 ? 
							$subhead = DB::table('acc_subheads')->where('com_id',$com_id)->where('id',$item->sh_id)->first(): '';
							$subhead=='' ? '' : $notes =$notes. ', '.$subhead->name;  
							
							$dep='';
							$item->dep_id>0 ? 
							$dep = DB::table('acc_departments')->where('com_id',$com_id)->where('id',$item->dep_id)->first(): '';
							$dep=='' ? '' : $notes =$notes. ', Department of '.$dep->name;  

							$item->note!='' ? $notes =$notes.', '. $item->note : ''; 
							$ff='';
							$item->c_number !='' ? $notes =$notes. ', hasan ' : $ff=''; 
							$item->b_name !='' ? $notes =$notes. ', '.$item->b_name : '';
							$item->c_date !='0000-00-00' ? $notes =$notes. ', '.$item->c_date : '';
							$master->person !='' ? $notes =$notes.', ' .$master->person  : '';

						?>
                         <tr>
                            <td class="text-center"><a href="{{ url('/tranmaster/voucher', $master->id) }}">{{ $master->vnumber }}</a></td>
                            <td>{{ $master->tdate }}</td>
                            <td>{{ $notes}}</td>
                            <td>{{ $item->c_number }}</td>
                            <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }}</td>
                             </tr>
                        @endforeach  
                        <?php 
							$ttl_debit>0 ? $ttl_debit = number_format($ttl_debit, 2) : ''; 
							$ttls=number_format($ttl,2); 
						if ($ttl!='')	:
						?>
                        <tr>
                        	<td colspan="4" class="text-right">Total</td>
                        	<td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $ttls }}</td>
                        </tr> 
						<?php endif; ?>
                   @endforeach 
                   		
                        <!--<tr><td colspan="" class=" text-right">Total</td><td id="cur">{{ $cur }}<td class=" text-right">{{ $ttl }}</td></tr> -->

                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Transaction->Checque Register</td><td class="text-right">Report generated by: {{ $user_name }}</td></tr>
                </table>
            </div><!-- /.box-header -->
        </div>
     </div>
</div>
@endsection

@section('custom-scripts')

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".tranmaster").validate();
		$( "#dfrom" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		$( "#dto" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
