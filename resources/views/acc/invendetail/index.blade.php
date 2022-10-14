@extends('app')

@section('htmlheader_title', 'Invendetails')

@section('contentheader_title', 'Invendetails')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_invendetail'))
            <a href="{{ URL::route('invendetail.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Invendetail</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="invendetail-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['item_id'] }}</th>
                        <th>{{ $langs['qty'] }}</th>
                        <th>{{ $langs['rate'] }}</th>
                        <th>{{ $langs['amount'] }}</th>
                        @if (Entrust::can('update_invendetail'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_invendetail'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($invendetails as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/invendetail', $item->id) }}">{{ $products[$item->item_id] }}</a></td>
                        <td>{{ $item->qty .' ('. $units[$item->unit_id].')'}}</td>
                        <td>{{ $item->rate }}</td>
                        <td>{{ $item->amount }}</td>

                        @if (Entrust::can('update_invendetail'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('invendetail.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_invendetail'))
                        <td width="80">{!! Form::open(['route' => ['invendetail.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit($langs['delete'], ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#invendetail-table").dataTable({
    		"aoColumns": [ null, null, null, null, null<?php if (Entrust::can("update_invendetail")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_invendetail")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
