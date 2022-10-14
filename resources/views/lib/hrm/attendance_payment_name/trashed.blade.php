@extends('app')

@section('htmlheader_title', 'Trashed Attendance payment names')

@section('contentheader_title', 'Trashed Attendance payment names')

@section('main-content')

    <div class="box">
        <div class="box-header">
            <a href="{{ URL::route('attendance-payment-name.index') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['back_to'] }} Attendance payment name</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="attendance-payment-name-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($attendance_payment_names as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        <td width="80">{!! Form::open(array('action' => array('Lib\Hrm\AttendancePaymentNameController@restore', $item->id))) !!}
                            {!! Form::submit($langs['restore'], ['class' => 'btn btn-warning btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
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
    		"aoColumns": [ null, null, { "bSortable": false } ]
    	});
    } );
</script>

@endsection
