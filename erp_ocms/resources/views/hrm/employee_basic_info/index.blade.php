@extends('app')

@section('htmlheader_title', 'Employee basic infos')

@section('contentheader_title', 'Employee basic infos')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('trashed_employee_basic_info'))
            <a href="{{ url('employee-basic-info/trashed') }}" class="btn btn-danger pull-right btn-sm trash-btn"><i class="fa fa-trash "></i></a>
            @endif
            @if (Entrust::can('create_employee_basic_info'))
            <a href="{{ URL::route('employee-basic-info.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Employee basic info</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="employee-basic-info-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['employee_code'] }}</th>
                        @if (Entrust::can('update_employee_basic_info'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_employee_basic_info'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($employee_basic_infos as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/employee-basic-info', $item->id) }}">{{ $item->fullname }}</a></td>
                        <td>{{ $item->employee_code }}</td>
                        @if (Entrust::can('update_employee_basic_info'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('employee-basic-info.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_employee_basic_info'))
                        <td width="80">{!! Form::open(['route' => ['employee-basic-info.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#employee-basic-info-table").dataTable({
    		"aoColumns": [ null, null, null<?php if (Entrust::can("update_employee_basic_info")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_employee_basic_info")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
