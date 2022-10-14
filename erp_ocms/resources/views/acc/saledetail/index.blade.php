@extends('app')

@section('htmlheader_title', 'Saledetails')

@section('contentheader_title', 'Saledetails')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_saledetail'))
            <a href="{{ URL::route('saledetail.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Saledetail</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="saledetail-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['item_id'] }}</th>
                        @if (Entrust::can('update_saledetail'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_saledetail'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($saledetails as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/saledetail', $item->id) }}">{{ $item->item_id }}</a></td>
                        @if (Entrust::can('update_saledetail'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('saledetail.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_saledetail'))
                        <td width="80">{!! Form::open(['route' => ['saledetail.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#saledetail-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_saledetail")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_saledetail")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
