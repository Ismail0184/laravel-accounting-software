@extends('app')

@section('htmlheader_title', 'Reconciliations')

@section('contentheader_title', 'Reconciliations')

@section('main-content')
    <div class="box">
            <div class="box-header">
            <a href="{{ url('reconciliation/report_print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
<!--            <a href="{{ url('reconciliation/report_pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('reconciliation/report_pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('reconciliation/report_excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('reconciliation/report_csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('reconciliation/report_word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
-->
            </div><!-- /.box-header -->
        <table class="table borderless">
        <?php
			// data collection filter method by session	
			$data=array('acc_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');

			Session::has('rdto') ? 
			$data=array('acc_id'=>Session::get('racc_id'),'dfrom'=>Session::get('rdfrom'),'dto'=>Session::get('rdto')) : ''; 

			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h2 align="center">'.$com_name.'</h2></td></tr>';
			
			$debit=''; $credit=''; $balance=0;
			$months=array(''=>'Select ...', 1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');

			$bank=DB::table('acc_coas')->where('com_id',$com_id)->where('id',$data['acc_id'])->first();
			$bank_name=''; isset($bank) && $bank->id > 0 ? $bank_name=$bank->name : $bank_name='';

			$period=$data['dfrom'].' to '.$data['dto']; //echo $opening_date;
			
						// opening balance calculation
			$d_opbs=''; $c_opbs=''; $d_opb=''; $c_opb=''; $obcur=''; $opbs=''; $cur='Tk';

			$opb=$tran=DB::table('acc_trandetails')
			->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
			->where('acc_trandetails.acc_id', $data['acc_id'])
			->where('acc_trandetails.com_id',$com_id)
			->where('acc_tranmasters.tdate','<=', $data['dto'])
			->sum('acc_trandetails.amount'); 
			//echo $opb.'-osama';
			$debit_ttl='';$credit_ttl='';$balance_ttl='';$debit_ttls='';$credit_ttls='';$balance_ttls='';$ccur='';
			// opening balance text
			$opbalance=$opb!='' ? "<span class='pull-right'>Balance as per Our Bank Ledger</span>" : '' ;
			// Opening balance calculation and format
			$opb>0 ? $d_opbs=$opb : $c_opbs=substr($opb,1);  $ob_dcur='';  $ob_ccur=''; 
			$opb!='' ? $balance=$opb : '';
			$d_opbs!='' ? $d_opb=number_format($d_opbs, 2) : '';
			$c_opbs!='' ? $c_opb=number_format($c_opbs, 2) : '';
			$d_opbs!='' ? $ob_dcur=$cur : $ob_dcur=''; 
			$c_opbs!='' ? $ob_ccur=$cur : $ob_ccur=''; 
			
			$opb >0 ? $opbs=number_format($opb, 2).' Dr' : ''; 
			$opb <0 ? $opbs=substr(number_format($opb, 2),1).' Cr' : ''; 
			$opb >0 ? $obcur=$cur : '';
			
			$opb >0 ? $debit_ttl=$opb : $credit_ttl=substr($opb,1); 
			
		?>
        <tr><td class="text-center">
            <h4>Bank Reconciliation Statement</h4>
            <h4>{{ $bank_name}}</h4>
            <h5>{{ $period }}</h5>
        </td></tr>
        </table>
            <table id="reconciliation-table" class="table table-bordered table-striped">
                <thead>

                <tr><td colspan="9"><a href="{!! url('/reconciliation/report?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'reconciliation/recfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $coa, null, ['class' => 'form-control select2', 'required']) !!}
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
               </td></tr>                    <tr>
                        <th>{{ $langs['tdate'] }}</th>
                        <th>{{ $langs['acc_id'] }}</th>
                        <th>{{ $langs['note'] }}</th>
                        <th class="text-right" colspan="2">{{ $langs['debit'] }}</th>
						<th class="text-right" colspan="2">{{ $langs['credit'] }}</th>
                        <th class="text-right" colspan="2">{{ $langs['balance'] }}</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="3"><b><?php echo $opbalance ?></b></td>
                    <td id="cur">{{  $ob_dcur }}</td><td class=" text-right">{{ $d_opb }}</td>
                    <td id="cur">{{  $ob_ccur }}</td><td class=" text-right">{{ $c_opb }}</td>
                    <td id="cur">{{  $obcur }}</td><td class=" text-right">{{ $opbs }}</td>
                </tr>
                {{-- */$x=0;/* --}}
                <?php 
					$reconciliations=DB::table('acc_reconciliations')->where('com_id',$com_id)
					->whereBetween('tdate', [$data['dfrom'], $data['dto']])->get(); 
				?>
                @foreach($reconciliations as $item)
                    {{-- */$x++;/* --}}
                    <?php 
						$bank=DB::table('acc_coas')->where('com_id',$com_id)->where('id',$item->acc_id)->first();
						$bank_name=''; isset($bank) && $bank->id > 0 ? $bank_name=$bank->name : $bank_name='';

						$coa=DB::table('acc_coas')->where('com_id',$com_id)->where('id',$item->tranwith_id)->first();
						$coa_name=''; isset($coa) && $coa->id > 0 ? $coa_name=$coa->name : $coa_name='';
						
						$item->ttype=='Receipt' ? $debit=$item->amount : $debit='';
						$item->ttype=='Payment' ? $credit=$item->amount : $credit='';
						
						$item->ttype=='Receipt' ? $debit_ttl += $item->amount  : ''; //echo $debit_ttl ;
						$item->ttype=='Payment' ? $credit_ttl += $item->amount  : ''; //echo $credit_ttl;
						
						$item->ttype=='Receipt' ? $balance= $balance+$item->amount : $balance= $balance-$item->amount;
						
						$balance >0 ? $balances=number_format($balance,2).' Dr' : $balances=substr(number_format($balance,2),1).' Cr';
						
						$debit!='' & $debit>0 ? $dcur=$cur :  $dcur='';
						$credit!=''  ? $ccur=$cur :  $ccur='';
						$balance!='' ? $bcur=$cur : $bcur='';
					?>
                    <tr>
                        <td>{{ $item->tdate }}</td>
                        <td>{{ $coa_name }}</td>
                        <td>{{ $item->note }}</td>
                        <td>{{ $dcur }}</td><td class="text-right">{{ $debit }}</td>
                       	<td>{{ $ccur }}</td> <td class="text-right">{{ $credit }}</td>
                        <td>{{ $bcur }}</td><td class="text-right">{{ $balances }}</td>
                    </tr>
                @endforeach
                <?php 
					$balance_ttl=$debit_ttl-$credit_ttl;
					$debit_ttl!='' ? $debit_ttls=number_format($debit_ttl,2) : '';
					$credit_ttl!='' ? $credit_ttls=number_format($credit_ttl,2) : '';
					$balance_ttl >0 ? $balance_ttls=number_format($balance_ttl,2).' Dr' : 
					$balance_ttls=substr(number_format($balance_ttl,2),1).' Cr';
					$debit_ttl!='' ? $dcur=$cur : $dcur='';
					$credit_ttl!='' ? $ccur=$cur : $dcur='';
					$balance_ttl!='' ? $bcur=$cur : $bcur='';
				?>
                <tr>
                    <td colspan="3" class="text-right"></td>
                    <td>{{ $dcur }}</td><td class="text-right">{{ $debit_ttls }}</td>
                    <td>{{ $ccur }}</td><td class="text-right">{{ $credit_ttls }}</td>
                    <td></td><td class="text-right"></td>
                </tr>
                <tr><td colspan="7" class="text-right"><b>Balance as per Bank Statement</b></td><td>{{ $bcur }}</td><td class="text-right">{{ $balance_ttls }}</td></tr>
                </tbody>
            </table>
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