@extends('app')

@section('htmlheader_title', 'Clients')

@section('contentheader_title', 'Clients')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
            @if (Entrust::can('create_client'))
            <a href="{{ url('/client/clienthelp') }}" class="btn btn-primary pull-right btn-sm trash-btn">{{ $langs['help'] }}</a>
            <a href="{{ URL::route('client.create')}}" title="{{ $langs['add_new'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-plus"></i></a>
            <a href="{{ url('client/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
<!--            <a href="{{ url('client/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('client/pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('client/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('client/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('client/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
-->            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="client-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['contact'] }}</th>
                        <th>{{ $langs['address'] }}</th>
                        <th>{{ $langs['email'] }}</th>
                        <th>{{ $langs['phone'] }}</th>
                        <th>{{ $langs['businessn'] }}</th>
                        @if (Entrust::can('update_client'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_client'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($clients as $item)
                    {{-- */$x++;/* --}}
                    <?php 
						$sale=DB::table('acc_salemasters')->where('client_id',$item->id)->first();
						isset($sale) && $sale->id>0 ? $sale_has='disabled' : $sale_has='';
					?>
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/client', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->contact }} </td>
                        <td>{{ $item->address1 }} </td>
                        <td>{{ $item->email }} </td>
                        <td>{{ $item->phone }} </td>
                        <td>{{ $item->businessn }} </td>
                        @if (Entrust::can('update_client'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('client.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_client'))
                        <td width="80">{!! Form::open(['route' => ['client.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', $sale_has, 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#client-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null<?php if (Entrust::can("update_client")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_client")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
