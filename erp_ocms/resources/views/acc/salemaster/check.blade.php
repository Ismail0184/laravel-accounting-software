@extends('app')

@section('htmlheader_title', 'Salemasters')

@section('contentheader_title', 'Sales Check')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';

		Session::has('olt_id') ? $olt_id=Session::get('olt_id') : $olt_id='' ;  
		$outlet=DB::table('acc_outlets')->where('id',$olt_id)->first(); 
		$outlet_name=''; isset($outlet) && $outlet->id >0 ? $outlet_name=$outlet->name : $outlet_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}/{{ $outlet_name }}</h3>
            @if (Entrust::can('create_salemaster'))
            <a href="{{ URL::route('salemaster.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Sale</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="salemaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['invoice'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th>{{ $langs['mt_id'] }}</th>
                        <th class="text-right">{{ $langs['amount'] }}</th>
                        @if (Entrust::can('delete_salemaster'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($salemasters as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                    <?php 
						$client=DB::table('acc_clients')->where('com_id',$com_id)->where('id', $item->client_id)->first();
						$client_name=''; isset($client) && $client->id > 0 ? $client_name=$client->name : $client_name='';
						
						$item->client_id==0 ?  $client_name=$item->client : '';
						
						$mteam=DB::table('acc_mteams')->where('com_id',$com_id)->where('id', $item->mt_id)->first();
						$mteam_name=''; isset($mteam) && $mteam->id > 0 ? $mteam_name=$mteam->name : $mteam_name='';
						
						$sale=DB::table('acc_saledetails')->where('sm_id', $item->id)->first();
						$disabled=''; isset($sale) && $sale->id> 0 ? $disabled='disabled' : $disabled='';
					?>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/salemaster/invoice?flag='. $item->id) }}">{{ $item->sdate }}/Inv: {{ $item->invoice }}</a></td>
                        <td>{{ $client_name }}</td>
                        <td>{{ $mteam_name }}</td>
                        <td class="text-right"><a href="{{ url('salemaster/invoice?flag='.$item->id) }}">{{ $item->samount }}</a></td>
                        @if (Entrust::can('delete_salemaster'))
                        <td width="80"><!--{!! Form::model(['url' => ['salemaster/checked', $item->id], 'method' => 'UPDATE']) !!}-->
                  			{!! Form::model($salemasters, ['url' => ['salemaster/checked', $item->id], 'method' => 'UPDATE', 'class' => 'form-horizontal tranmaster']) !!}
                            {!! Form::hidden('check_action', 1, ['class' => 'form-control']) !!}
                            {!! Form::hidden('check_note', 'checked', ['class' => 'form-control']) !!}
                            {!! Form::submit('Data Check', ['class' => 'btn btn-update btn-block fa', 'title' => $langs['check'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
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
        $("#salemaster-table").dataTable({
    		"aoColumns": [ null, null, null,  null<?php if (Entrust::can("update_salemaster")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_salemaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
