@extends('app')

@section('htmlheader_title', 'Line Information')

@section('contentheader_title', 'Line Information')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('trashed_lineinfo'))
            <a href="{{ url('lineinfo/trashed') }}" class="btn btn-danger pull-right btn-sm trash-btn"><i class="fa fa-trash "></i></a>
            @endif
            @if (Entrust::can('create_lineinfo'))
            <a href="{{ URL::route('lineinfo.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Lineinfo</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="lineinfo-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_lineinfo'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_lineinfo'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($lineinfos as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        @if (Entrust::can('update_lineinfo'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('lineinfo.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_lineinfo'))
                        <td width="80">{!! Form::open(['route' => ['lineinfo.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#lineinfo-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_lineinfo")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_lineinfo")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
