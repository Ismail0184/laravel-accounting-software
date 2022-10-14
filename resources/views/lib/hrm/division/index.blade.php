@extends('app')

@section('htmlheader_title', 'Divisions')

@section('contentheader_title', 'Divisions')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('trashed_division'))
            <a href="{{ url('division/trashed') }}" class="btn btn-danger pull-right btn-sm trash-btn"><i class="fa fa-trash "></i></a>
            @endif
            @if (Entrust::can('create_division'))
            <a href="{{ URL::route('division.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Division</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="division-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_division'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_division'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($divisions as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        @if (Entrust::can('update_division'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('division.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_division'))
                        <td width="80">{!! Form::open(['route' => ['division.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#division-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_division")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_division")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
