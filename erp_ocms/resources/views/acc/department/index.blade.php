@extends('app')

@section('htmlheader_title', 'Departments')

@section('contentheader_title', 'Departments')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_department'))
            <a href="{{ URL::route('department.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Department</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="department-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_department'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_department'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($departments as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/department', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_department'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('department.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_department'))
                        <td width="80">{!! Form::open(['route' => ['department.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#department-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_department")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_department")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
