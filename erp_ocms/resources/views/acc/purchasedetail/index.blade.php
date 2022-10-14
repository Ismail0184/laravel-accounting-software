@extends('app')

@section('htmlheader_title', 'Purchasedetails')

@section('contentheader_title', 'Purchasedetails')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_purchasedetail'))
            <a href="{{ URL::route('purchasedetail.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Purchasedetail</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="purchasedetail-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_purchasedetail'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_purchasedetail'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($purchasedetails as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/purchasedetail', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_purchasedetail'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('purchasedetail.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_purchasedetail'))
                        <td width="80">{!! Form::open(['route' => ['purchasedetail.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#purchasedetail-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_purchasedetail")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_purchasedetail")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
