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
        	<a href="{{ url('/purchasemaster/purchasemasterhelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_purchasemaster'))
            <a href="{{ URL::route('purchasemaster.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Purchase</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="purchasemaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['pdate'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th>{{ $langs['address'] }}</th>
                        <th class="text-right">{{ $langs['amount'] }}</th>
                        <th>{{ $langs['wh_id'] }}</th>
                        <th>{{ $langs['note'] }}</th>
                        @if (Entrust::can('update_purchasemaster'))
                        <th></th>
                        @endif
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
					$client_address=''; isset($clients) && $clients->id >0 ? $client_address=$clients->address1 : $client_address='';
					$item->client_id==0 && $item->client_address!='' ? $client_address=$item->client_address: '';
					
					$pd=DB::table('acc_purchasedetails')->where('com_id',$com_id)->where('pm_id',$item->id)->first();
					$disabled=''; isset($pd) && $pd->id > 0 ? $disabled='disabled' : '';
					?>
                    {{-- */$x++;/* --}}
                    <tr>

                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/purchasemaster', $item->id) }}">{{ $item->pdate }}/Inv:{{ $item->invoice }}</a></td>
                        <td>{{ $client }}</td>
                         <td>{{ $client_address }}</td>
                        <td class="text-right">Bill:{{ $item->amount }} / Paid:{{ $item->paid }}</td>
                        <td >@if(isset($item->wh->name)){{ $item->wh->name }}@endif</td>
                        <td >{{ $item->note }}</td>
                        @if (Entrust::can('update_purchasemaster'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('purchasemaster.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_purchasemaster'))
                        <td width="80">{!! Form::open(['route' => ['purchasemaster.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa',$disabled, 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
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
    		"aoColumns": [ null, null, null, null, null, null, null<?php if (Entrust::can("update_purchasemaster")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_purchasemaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
