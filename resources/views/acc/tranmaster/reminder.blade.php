@extends('app')

@section('htmlheader_title', 'Tranmasters')

@section('contentheader_title', 'Transaction')

@section('main-content')
<style>
	#vnumber { width:120px; text-align:center}
	#tdate { width:80px}
	#amount { width:80px; text-align:right; padding-right:10px}
	#acc_head { width:150px; }
	#mod { width:80px; }
</style>
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		$edit_disabled='';
		?>

    <div class="box">
        <div class="box-header"><h3 style="margin:0px; padding:0px">{{ $com_name }}</h3>
               
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="tranmaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['vnumber'] }}</th>
                        <th>{{ $langs['note'] }}</th>
                        <th>{{ $langs['tranwith_id'] }}</th>
                        <th>{{ $langs['amount'] }}</th>
                        <th>{{ $langs['ttype'] }}</th>
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($tranmasters as $item)
                    {{-- */$x++;/* --}}
                    <?php 
						$edit_disabled=''; $tmamount='';
						
						$check_delete = DB::table('acc_trandetails')
						->where('tm_id',$item->id)
						->first(); 
						isset($check_delete->tm_id) && $check_delete->tm_id>0 ? $disabled="disabled" : $disabled="";
						$coas=''; $coa=DB::table('acc_coas')->where('id',$item->tranwith_id)->first(); isset($coa) && $coa->id>0 ? $coas=$coa->name : $coas='';
						
						$item->tmamount > 0 ? $tmamount=number_format($item->tmamount,2): '';
						$item->tmamount < 0 ? $tmamount=number_format(substr($item->tmamount,1),2) : '';						
						
						$td=DB::table('acc_trandetails')->where('tm_id',$item->id)->first(); 
						
						$td_accid=''; isset($td) && $td->id >0 ? $td_accid=$td->acc_id : $td_accid=''; //echo $td_accid;
						
						$coa=''; $coa=DB::table('acc_coas')->where('id',$td_accid)->first(); 
						$coa_name=''; isset($coa) && $coa->id>0 ? $coa_name=$coa->name : $coa_name='';
						if ($coa_name!=''):
						 	$item->note!='' ? $item->note=$coa_name . ', '.$item->note :  $item->note=$coa_name;
						 endif;
						 
						  
					?>
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td id="vnumber">
                        <a href="{{ url('/tranmaster/voucher', $item->id) }}">{{ $item->master()->tdate. '/ VNo: '. $item->master()->vnumber }}</a>
                        </td>
                        <td>{{ $item->note }}</td>
                        <td id="acc_head">{{ $coas }}</td>
                        <td id="amount">{{ $tmamount }}</td>
                        @if($item->check_action=='0')
                         <td id="mod">{{ $item->amount }}</td>
                        @else
                         <td id="mod">{{ $item->ttype }}</td>
                            <?php $edit_disabled="disabled"; ?>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#tranmaster-table").dataTable({
    		"aoColumns": [ null, null, null, null<?php if (Entrust::can("update_tranmaster")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_tranmaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
		$( "#dfrom" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
        $( "#dto" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    } );
</script>

@endsection
