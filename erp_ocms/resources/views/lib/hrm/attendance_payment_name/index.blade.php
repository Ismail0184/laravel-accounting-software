@extends('app')

@section('htmlheader_title', 'Attendance payment names')

@section('contentheader_title', 'Attendance payment names')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('trashed_attendance_payment_name'))
            <a href="{{ url('unit/trashed') }}" class="btn btn-danger pull-right btn-sm trash-btn"><i class="fa fa-trash "></i></a>
            @endif
            @if (Entrust::can('create_attendance_payment_name'))
            <a href="{{ URL::route('attendance-payment-name.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Attendance payment name</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="attendance-payment-name-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_attendance_payment_name'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_attendance_payment_name'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($attendance_payment_names as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        @if (Entrust::can('update_attendance_payment_name'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('attendance-payment-name.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_attendance_payment_name'))
                        <td width="80">{!! Form::open(['route' => ['attendance-payment-name.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#attendance-payment-name-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_attendance_payment_name")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_attendance_payment_name")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
