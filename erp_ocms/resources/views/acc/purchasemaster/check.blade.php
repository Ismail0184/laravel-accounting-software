@extends('app')

@section('htmlheader_title', 'Purchasemasters')

@section('contentheader_title', 'Purchase')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="purchasemaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['invoice'] }}</th>
                        <th>{{ $langs['pdate'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th class="text-right">{{ $langs['amount'] }}</th>
                        @if (Entrust::can('delete_purchasemaster'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($purchasemasters as $item)
                	<?php $clients=DB::table('acc_clients')->where('id',$item->client_id)->first(); 
					$client=''; isset($clients) && $clients->id >0 ? $client=$clients->name : $client='';
					$item->client_id==0 && $item->client!='' ? $client=$item->client: '';
					?>
                    {{-- */$x++;/* --}}
                    <tr>

                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/purchasemaster', $item->id) }}">{{ $item->invoice }}</a></td>
                        <td>{{ $item->pdate }}</td>
                        <td>{{ $client }}</td>
                        <td class="text-right">{{ $item->amount }}</td>
                        @if (Entrust::can('delete_purchasemaster'))
                        <td width="80"><!--{!! Form::model(['url' => ['salemaster/checked', $item->id], 'method' => 'UPDATE']) !!}-->
                  			{!! Form::model($purchasemasters, ['url' => ['purchasemaster/checked', $item->id], 'method' => 'UPDATE', 'class' => 'form-horizontal tranmaster']) !!}
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
        $("#purchasemaster-table").dataTable({
    		"aoColumns": [ null, null, null, null<?php if (Entrust::can("update_purchasemaster")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_purchasemaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
