@extends('app')

@section('htmlheader_title', 'Trandetail')

@section('contentheader_title', 'Voucher')
<style>
	#col {  min-height:100px; padding-top:50px; width:23%; float:left}
	#inner { border:1px solid #300; min-height:60px; padding:10px; margin:3px}
	#details tr td { border: 1px solid #000; border-collapse: collapse;} 
	#details tr th { border: 1px solid #000; border-collapse: collapse;} 
	#details tr { min-height:80px}
	#cur { width:30px}
	#sl { width:80px}
	#lebel { width:170px; text-align:right}
	#lebel2 { width:170px; text-align:left}
	#note { height:200px}
	
	tr { height:50px; }
</style>
@section('main-content')
    <div class="container">
        <div class="box">
        <div class="box-header">
            <a href="{{ url('tranmaster/voucher_print/'.$tranmaster->id) }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a><!--
            <a href="{{ url('tranmaster/voucher_pdf/'.$tranmaster->id) }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('tranmaster/voucher_pdf/'.$tranmaster->id) }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('tranmaster/voucher_excel/'.$tranmaster->id) }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('tranmaster/voucher_csv/'.$tranmaster->id) }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('tranmaster/voucher_word/'.$tranmaster->id) }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>-->

            </div><!-- /.box-header -->
            <div class="box-body">
            <?php 
				$months=array(''=>'Select ...', 1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');
				Session::has('com_id') ? 
				$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

				$nam=''; //echo $tranmaster->tranwith_id;
				$group=DB::table('acc_coas')->where('id', $tranmaster->tranwith_id)->first(); 
				$group_id=''; isset($group) && $group->id > 0 ? $group_id=$group->group_id : $group_id='';
				
				$coa=DB::table('acc_coas')->where('id', $group_id)->first(); 
				$acc_name=''; isset($coa) && $coa->id > 0 ? $acc_name=$coa->name : $acc_name='';

				$nam='';
				if ($acc_name=='Cash Account'):
					$nam='Cash';
				elseif ($acc_name=='Bank Account'):
					$nam='Bank';
				endif;
				 
				$vn='';
				if ($tranmaster->ttype=="Payment"):
				 	$vn="Debit Voucher";  
				 elseif($tranmaster->ttype=="Receipt"):
				 	$vn="Credit Voucher";
				 elseif ($tranmaster->ttype=="Journal"):
				 	$vn="Journal Voucher"; 
				 elseif ($tranmaster->ttype=="Contra"):
				 	$vn="Contra Voucher";
				 endif;

				$tranwith=DB::table('acc_coas')->where('id', $tranmaster->tranwith_id)->first(); 
				$tranwith_name=''; isset($tranwith) && $tranwith->id > 0 ? $tranwith_name=$tranwith->name : $tranwith_name='';

				Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
				$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
				$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';			?>
            <table class="table table-bordered">
                <tr><th colspan="4"><h2><span class="pull-left">{{ $com_name }}</span><span class="pull-right">{{ $vn }}</span></h2></th></tr>
                <tr><th colspan="4"><h3 class="text-center">{{ $nam }} {{ $tranmaster->ttype }}</h3></th></tr>
                <tr>
                    <th id="lebel">{{ $langs['vnumber'] }} :</th><th>{{ $tranmaster->vnumber }}</th><th  id="lebel">{{ $langs['tdate'] }} :</th><th id="lebel2">{{ $tranmaster->tdate }}</th>
                </tr>
                @if ($tranmaster->ttype!="Journal")
                <tr>
                    <th id="lebel" >{{ $langs['person'] }} :</th><th>{{ $tranmaster->person }}</th><th id="lebel">{{ $langs['tranwith_id'] }} :</th><th id="lebel2">{{ $tranwith_name }}</th>
            	</tr>
                @endif
        </table><br>
        <h4>Transaction Details</h4>
        <table class="table" id="details">
               <?php 
			   		$details=DB::table('acc_trandetails')
					->where('tm_id', $tranmaster->id)
					->get(); 
			   ?>
                   <tr>
                    	<th class="text-center" id="sl">{{ $langs['sl'] }}</th>
                        <th>{{ $langs['acc_id'] }}</th>
                        <th class="text-right" colspan="2">{{ $langs['debit'] }}</th>
                        <th class="text-right" colspan="2">{{ $langs['credit'] }}</th>
                    </tr>
               <?php $ttl='';   ?>
               {{-- */$x=0;/* --}}
               @foreach( $details as $item)
               {{-- */$x++;/* --}}
               <?php 
					$credit=''; $item->amount< 0 ? $credit=number_format(substr($item->amount,1),2): ''; 
					$debit=''; $item->amount> 0 ? $debit=number_format($item->amount,2): ''; 
					$dcur=''; $item->amount> 0 ? $dcur=$tranmaster->currency->name : '';
					$ccur=''; $item->amount< 0 ? $ccur=$tranmaster->currency->name : '';
					
					$item->amount> 0 ? $ttl += $item->amount :'';  $amount=number_format($item->amount, 2); 
					$coa=DB::table('acc_coas')->where('id',$item->acc_id)->first();
					$coa_name=''; isset($coa) && $coa->id >0 ? $coa_name=$coa->name : $coa_name='';		
					
						$item->acc_id>0 ?
						$coa = DB::table('acc_coas')->where('com_id',$com_id)->where('id',$item->acc_id)->first() : ''; 
						isset($coa) && $coa->id>0  ? $acc_head=$coa->name : $acc_head='' ; 
						
						$subhead='';
						$item->sh_id>0 ? 
						$subhead = DB::table('acc_subheads')->where('com_id',$com_id)->where('id',$item->sh_id)->first(): '';
						$subhead=='' ? '' : $acc_head = $acc_head.', '.$subhead->name; 

						$dep='';
						$item->dep_id>0 ? 
						$dep = DB::table('acc_departments')->where('com_id',$com_id)->where('id',$item->dep_id)->first(): '';
						$dep=='' ? '' : $acc_head = $acc_head.', Department of '.$dep->name; 

						$item->c_number!='' ? $coa_name = $coa_name.', Checque No:'.$item->c_number : ''; 
						$item->b_name!='' ? $coa_name = $coa_name.', Branch Name: '.$item->b_name : ''; 
						$item->c_date!='0000-00-00' ? $coa_name = $coa_name.', Checque Date: '.$item->c_date : '';		

						$item->m_id>0 ? $m_name=$months[$item->m_id] : $m_name='';
						$m_name!='' ? $acc_head = $acc_head.', Period for '.$m_name.'-'. $item->year : '';

			   ?>
                <tr>
                    <td class="text-center">{{ $x }}</td>
                    <td >{{ $coa_name }}</td>
                    <td id="cur">{{ $dcur }}</td>
                    <td class="text-right">{{ $debit }}</td>
                    <td id="cur">{{ $ccur }}</td>
                    <td class="text-right">{{ $credit }}</td>
                </tr>
                @endforeach
                <?php 
				$ttl!=0 ? $ttls = number_format($ttl,2) : $ttls ='';  
				$tranmaster->check_action==0 ? $check_name='Waiting' : $check_name=$users[$tranmaster->check_id];
				$tranmaster->appr_action==0 ? $appr_name='Waiting' : $appr_name=$users[$tranmaster->appr_id];
				?>
                <tr>
                	<td colspan="6" class="text-right">Total {{ Terbilang::make($ttl) }} </td>
                	
                </tr>
                <tr id="note"><td colspan="6">Note:<br />{{ $acc_head }}<br>{{ $tranmaster->note }}</td></tr>
        </table>
         	<div class="row" style="padding:5px">
                <div class="col-sm-3 text-center" id="col">{{ $tranmaster->user->name }}
                    <div id="inner">Inputed By</div>
                </div>
            	<div class="col-sm-3 text-center" id="col">{{ $check_name }}
            		<div id="inner">Checked By</div>
                </div>
            	<div class="col-sm-3 text-center" id="col">{{ $appr_name }}
            		<div id="inner">Approved By</div>
                </div>
            	<div class="col-sm-3 text-center" id="col"><br>
            		<div id="inner">Received By</div>
                </div>
            </div>     
    </div>
    </div>
</div>
@endsection
