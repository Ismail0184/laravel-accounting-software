@extends('app')

@section('htmlheader_title', 'Tranmasters')

@section('contentheader_title', 'Transaction Reminder')

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

						$coas=''; $coa=DB::table('acc_coas')->where('id',$item->master->tranwith_id)->first(); 
						isset($coa) && $coa->id>0 ? $coas=$coa->name : $coas='';
						$amount=DB::table('acc_trandetails')->where('com_id',$com_id)->where('rmndr_id',$item->rmndr_id)->sum('amount');  
					?>
                    @if($amount!=0)
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td id="vnumber">
                        <a href="{{ url('/tranmaster/voucher', $item->tm_id) }}">{{ $item->master->tdate. '/ VNo: '. $item->master->vnumber }}</a>
                        </td>
                        <td>{{ $item->master->note }}, Reminder :  {{ $item->rmndr_id }},  {{ $item->rmndr_note }}, by {{ $item->rmndr_date }}</td>
                        <td id="acc_head">{{ $coas }}</td>
                        <td id="amount">{{ $item->master->tmamount }}</td>
                        <td id="mod">{{ $item->master->ttype }}</td>
                    </tr>
                    @endif
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
