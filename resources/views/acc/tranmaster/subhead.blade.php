@extends('app')

@section('htmlheader_title',  ' Subhead Ledger')

@section('contentheader_title', 	  ' Subhead Ledger')
@section('main-content')

<style>
    table.borderless td,table.borderless th{
     border: none !important; margin:0px; padding:0px
	}

	h1{
		font-size: 1.6em;
	}
	h5{
		font-size: 1.2em; margin:0px; font-weight:bold; margin:opx; padding:0px;
	}
	#cur {width: 10px}
	body { padding:0px}
	#opn { margin:opx; padding:0px;}
	#dt { width:15%;} 
	#nt { width:30%; } 
</style>

 <div class="container">
 <div class="box" >
    <div class="table-responsive">
            <div class="box-header">
        <a href="{{ url('tranmaster/subhead_print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
<!--        <a href="{{ url('tranmaster/subhead_pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
        <a href="{{ url('tranmaster/subhead_pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
        <a href="{{ url('tranmaster/subhead_excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
        <a href="{{ url('tranmaster/subhead_csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
        <a href="{{ url('tranmaster/subhead_word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
-->
            </div><!-- /.box-header -->

        <table  width="100%>
        <?php 
			isset($_GET['sh_id']) && $_GET['sh_id']> 0 ? Session::put('subsh_id', $_GET['sh_id']) : '';

			$user_name=''; Session::has('user_name') ? $user_name=Session::get('user_name') : $user_name='';

			$months=array(''=>'Select ...', 1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h1 align="center">'.$com_name.'</h1></td></tr>';

			// data collection filter method by session	
			$data=array('acc_id'=>'','sh_id'=>0,'dfrom'=>'0000-00-00','dto'=>'0000-00-00');

			Session::has('subsh_id') && Session::has('subdfrom') && Session::has('subdto')? 
			$data=array('acc_id'=>Session::get('subacc_id'),'sh_id'=>Session::get('subsh_id'),'dfrom'=>Session::get('subdfrom'),'dto'=>Session::get('subdto')) : ''; 
			
			if (isset($data['acc_id']) && $data['acc_id']>0):
				// for single account
				$s_h=DB::table('acc_subheads')->where('id',$data['sh_id'])->first();
				$s_head=''; isset($s_h) && $s_h->id>0 ? $s_head=$s_h->name : $s_head='';
				$acc=DB::table('acc_coas')->where('id',$data['acc_id'])->first();
				$acc_head=''; isset($acc) && $acc->id>0 ? $acc_head=$acc->name : $acc_head='';
				echo '<tr><td ><h4 class="pull-left"> For '.$s_head.' </h4></td>
				<td class="text-right" ><h3 aling="right">'.$acc_head.'</h3><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h5>General Ledger</h5><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			endif;

		?>
        
        </table>

            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="8"><a href="{!! url('/tranmaster/subhead?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'tranmaster/subfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $acccoa, null, ['class' => 'form-control select2']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('sh_id', $langs['sh_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('sh_id', $subheads, null, ['class' => 'form-control select2']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  date('Y-m-01'), ['class' => 'form-control', 'id'=>'dfrom', 'required']) !!}
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
                        <th class="col-md-2" id="dt">{{ $langs['tdate'] }}</th>
                        <th class="col-md-4" id="nt">{{ $langs['note'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['debit'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['credit'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['balance'] }}</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
						//  filter wise acc_id based data collection 
						isset($data['acc_id']) && $data['acc_id'] > 0 ?  
						$tran=DB::table('acc_coas')->where('com_id', $com_id)->where('id', $data['acc_id'])->groupBy('acc_coas.id')->get() : 
						$tran=array(); 
						//DB::table('acc_coas')->where('acc_coas.com_id', $com_id)->select('acc_coas.id as id')
						//->join('acc_trandetails', 'acc_coas.id', '=','acc_trandetails.acc_id')->groupBy('acc_coas.id')->get();
						
						$cur='Tk'; $debit=0; $credit=0; $balance=0; $ttl=0; //$balances='';
						
				?>
                  @foreach($tran as $item)
                  			<?php 
							
								$acchead= $data['acc_id']=='' ? "<h4>".$acccoa[$item->id]."</h4>" : '';
								// opening balance calculation
								$d_opbs=''; $c_opbs=''; $d_opb=''; $c_opb=''; $obcur=''; $opbs='';

								$opb=$tran=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
								->where('acc_trandetails.acc_id', $item->id)
								->where('acc_trandetails.sh_id',$data['sh_id'])
								->where('acc_tranmasters.tdate','<', $data['dfrom'])
								->sum('acc_trandetails.amount');

								// opening balance text
								$opbalance=$opb>0 ? "<span class='pull-right'>Opening Balance</span>" : '' ;
								// Opening balance calculation and format
								$opb>0 ? $d_opbs=$opb : $c_opbs=$opb;  $ob_dcur='';  $ob_ccur=''; 
								$d_opbs!='' ? $d_opb=number_format($d_opbs, 2) : '';
								$c_opbs!='' ? $c_opb=number_format($c_opbs, 2) : '';
								$d_opbs!='' ? $ob_dcur=$cur : $ob_dcur=''; 
								$c_opbs!='' ? $ob_ccur=$cur : $ob_ccur=''; 
								
								$opb >0 ? $opbs=number_format($opb, 2).' Dr' : ''; 
								$opb <0 ? $opbs=substr(number_format($opb, 2),1).' Cr' : ''; 
								$opb >0 ? $obcur=$cur : '';
								?>
                                    <tr>
                                        <td colspan="2"><?php echo $acchead.$opbalance ?></td>
                                        <td id="cur">{{  $ob_dcur }}</td><td class=" text-right">{{ $d_opb }}</td>
                                        <td id="cur">{{  $ob_ccur }}</td><td class=" text-right">{{ $c_opb }}</td>
                                        <td id="cur">{{  $obcur }}</td><td class=" text-right">{{ $opbs }}</td>
                                    </tr>
								<?php
								
							// account-wise data 
							$details=DB::table('acc_trandetails')->where('acc_id', $item->id)->orderBy('acc_trandetails.id')->get() ;
							if (isset($data['dfrom'])):
								// account and date-wise data
								$details=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
								->where('acc_trandetails.acc_id', $item->id)
								->where('acc_trandetails.sh_id',$data['sh_id'])
								->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
								->orderBy('acc_tranmasters.tdate')
								->get();
							endif;
							 
							$balances='';$balance=0; $ttl_debit=''; $ttl_credit=''; $ttl_balances='';
							$opb!='' ? $balance=$opb : '';  $tdcur=''; $tccur='';
							$opb> 0 ? $ttl_debit=$opb :  $ttl_credit=$opb;
							?>
                        
                        @foreach($details as $item)
                        <?php 
								$subhead=DB::table('acc_subheads')->where('id',$item->sh_id)->first();
								$item->sh_id>0 ? $subhead=$subhead->name.', ' : '';
								$acchead=DB::table('acc_coas')->where('id',$item->tranwiths_id)->first();
								$item->acc_id>0 ? $subhead=$acchead->name : '';
								
								$ilc=DB::table('acc_lcimports')->where('id',$item->ilc_id)->first();
								isset($ilc) && $item->id>0 ? $ilc=' ,'.$ilc->lcnumber : $ilc='';

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
							
							$person=''; $master->person!='' ? $person=', ' .$master->person  : $person=''; //echo $ttl_credit;
							
							$period=''; $item->m_id>0 ? $period=$months[$item->m_id].'-'.$item->year : $period='';
							$person!='' ? $period=', for '.$period : ''; 
						?>
                         <tr>
                            <td>{{ $master->tdate }} / vn-{{ $master->vnumber }}</td>
                            <td>{{ $subhead }} {{ $master->note }} {{ $ilc }} {{ $person.$period }}</td>
                            <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }}</td>
                            <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $credit }}</td>
                            <td id="cur">{{ $cur }}</td><td class=" text-right">{{ $balances }}</td>
                             </tr>
                        @endforeach  
                        <?php 
							$ttl_debit>0 ? $ttl_debit = number_format($ttl_debit, 2) : ''; 
							$ttl_credit<0 ? $ttl_credit=substr(number_format($ttl_credit,2),1) : ''; 
						?>
                        <tr>
                        	<td colspan="2" class="text-right">Total</td>
                        	<td id="cur">{{ $tdcur }}</td><td class=" text-right">{{ $ttl_debit }}</td>
                            <td id="cur">{{ $tccur }}</td><td class=" text-right">{{ $ttl_credit }}</td>
                            <td id="cur"></td><td class=" text-right">{{ $ttl_balances }}</td>
                        </tr> 

                   @endforeach 
                   		
                        <!--<tr><td colspan="6" class=" text-right">Total</td><td id="cur">{{ $cur }}<td class=" text-right">{{ $ttl }}</td></tr> -->

                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Transaction->Ledger</td><td class="text-right">Report generated by: {{ $user_name }}</td></tr>
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

