@extends('app')

@section('contentheader_title', 'Transfer')

@section('main-content')
	<style>
    	#sl, #vn { width:80px; text-align:center }
		#dt, #user { width:100px; text-align:center }
		#amt { width:100px; text-align:right }
		#acc_id { width:200px; }
    </style>
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
					
					$option=DB::table('acc_options')->where('com_id',$com_id)->first(); 
					$currency_id=''; isset($option) && $option->id > 0 ? $currency_id=$option->currency_id : $currency_id='';
					$check_id=''; isset($option) && $option->id > 0 ? $check_id=$option->tcheck_id : $check_id='';
		?>
    <div class="box">
        <div class="box-header"><h3 style="margin:0px; padding:0px">{{ $com_name }}</h3></div>
             <table id="tranmaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th >{{ $langs['sl'] }}</th>
                        <th id="vn">{{ $langs['sis_id'] }}</th>
                        <th id="dt">{{ $langs['tdate'] }}</th>
                         <th id="dt">{{ $langs['ttype'] }}</th>
                        <th id="nt">{{ $langs['note'] }}</th>
                        <th id="">{{ $langs['payfrom'] }}</th>
                        <th class="text-right">{{ $langs['amount'] }}</th>
                         <th id="">{{ $langs['sis_accid'] }}</th>
                         <th id="">{{ $langs['userid'] }}</th>
                        <!--@if (Entrust::can('update_tranmaster'))
                        <th></th>
                        @endif-->
                        @if (Entrust::can('delete_tranmaster'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                <?php 
					$tranmasters=DB::table('acc_tranmasters')
					->join('acc_trandetails', 'acc_tranmasters.id', '=', 'acc_trandetails.tm_id')
					->where('acc_trandetails.sis_action','')->where('sis_id',$com_id)->get();
				?>
                @foreach($tranmasters as $item)
                    {{-- */$x++;/* --}}
                     <?php 
					 	$tdid=DB::table('acc_trandetails')->select('acc_trandetails.id as id')
						->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
						->where('acc_trandetails.sis_id',$com_id)->where('acc_tranmasters.vnumber',$item->vnumber)
						->where('acc_trandetails.sis_action','')->first(); 
						$td_id=''; isset($tdid) && $tdid->id >0 ? $td_id=$tdid->id : $td_id=''; //echo $td_accid;

						$td=DB::table('acc_trandetails')->where('com_id',$com_id)->where('tm_id',$item->id)->first(); 
						$td_accid=''; isset($td) && $td->id >0 ? $td_accid=$td->acc_id : $td_accid=''; //echo $td_accid;
						
						$coa=''; $coa=DB::table('acc_coas')->where('id',$td_accid)->first(); 
						$coa_name=''; isset($coa) && $coa->id>0 ? $coa_name=$coa->name : $coa_name='';
						if ($coa_name!=''):
						 	$item->note!='' ? $item->note=$coa_name. ', '.$item->note :  $item->note=$coa_name;
						endif;	
						$tranwith=DB::table('acc_coas')->where('id',$item->tranwith_id)->first(); 
						$tranwith_name=''; isset($tranwith) && $tranwith->id>0 ? $tranwith_name=$tranwith->name : $coa_name='';

						$acc=DB::table('acc_coas')->where('id',$tdid->id)->first(); 
						$acc_name=''; isset($acc) && $acc->id>0 ? $acc_name=$acc->name : $acc_name='';

						$sis_acc=DB::table('acc_coas')->where('id',$item->sis_accid)->first(); 
						$sis_acc_name=''; isset($sis_acc) && $sis_acc->id>0 ? $sis_acc_name=$sis_acc->name : $sis_acc_name='';
						$item->tmamount> 0 ? $item->tmamount	=number_format($item->tmamount,2): '';	

						$tr_with=DB::table('acc_companies')->where('id',$item->com_id)->first(); 
						$tr_with_name=''; isset($tr_with) && $tr_with->id > 0 ? $tr_with_name=$tr_with->name : $tr_with_name='';
						 ?>
                   <tr>
				    {!! Form::open(['route' => 'lcinfo.store', 'class' => 'form-horizontal']) !!}
                        <td width="50">{{ $x }}</td>
                        <td id="vn"><a href="{{ url('/tranmaster/voucher', $item->id) }}">{{ $tr_with_name }}</a></td>
                        <td id="dt">{{ $item->tdate }}</td>
                        <td id="dt">{{ $item->ttype }}</td>
                        <td id="nt">{{ $item->note }}</td>
                        <td id="acc_id">{{ $tranwith_name }}</td>
                        <td id="amt">{{ $item->tmamount }}</td>
                        <td id="tp">{{  $sis_acc_name }}</td>
                        <td id="tp">{{  $users[$item->user_id] }}</td>
<!--                    @if (Entrust::can('update_tranmaster'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('tranmaster.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
-->                        @if (Entrust::can('checked_tranmaster'))
                        <td width="200px">
                            {!! Form::submit($langs['accept'], ['class' => 'btn btn-primary btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                        @endif
                        <?php 
							$vnumber = DB::table('acc_tranmasters')->where('com_id',$com_id)->max('vnumber')+1;  
							$coas=DB::table('acc_coas')->where('com_id',$com_id)->where('name',$tr_with_name)->first(); 
							isset($coas) && $coas->id> 0 ? $tr_with_id=$coas->id : $tr_with_id='';
							
							$tmamount=''; $item->amount >0 ? $tmamount=$item->amount : $tmamount=substr($item->amount,1);
						?>
                        {!! Form::hidden('vnumber', $vnumber, ['class' => 'form-control']) !!}
                        {!! Form::hidden('currency_id', $currency_id, ['class' => 'form-control']) !!}
                        {!! Form::hidden('check_id', $check_id, ['class' => 'form-control']) !!}
                        {!! Form::hidden('tranwith_id', $tr_with_id, ['class' => 'form-control']) !!}
                        {!! Form::hidden('tdate', $item->tdate, ['class' => 'form-control']) !!}
                        {!! Form::hidden('acc_id', $item->sis_accid, ['class' => 'form-control']) !!}
                        {!! Form::hidden('tranwiths_id', $tr_with_id, ['class' => 'form-control']) !!}
                        {!! Form::hidden('ttype', 'Journal', ['class' => 'form-control']) !!}
                        {!! Form::hidden('amount', $item->amount, ['class' => 'form-control']) !!}
                        {!! Form::hidden('note', 'Transferred from '.$tr_with_name, ['class' => 'form-control']) !!}
                        {!! Form::hidden('lc_id', '', ['class' => 'form-control']) !!}
                        {!! Form::hidden('tmamount', $tmamount, ['class' => 'form-control']) !!}
                        {!! Form::hidden('td_id', $td_id, ['class' => 'form-control']) !!}
                        
                  {!!  Form::close() !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#tranmaster-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null, null, null<?php  if (Entrust::can("delete_tranmaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
