@extends('app')

@section('htmlheader_title', 'Trashed Employee basic infos')

@section('contentheader_title', 'Trashed Employee basic infos')

@section('main-content')

    <div class="box">
        <div class="box-header">
            <a href="{{ URL::route('employee-basic-info.index') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['back_to'] }} Employee basic infos</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="employee-basic-info-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($employee_basic_infos as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/employee-basic-info', $item->id) }}">{{ $item->name }}</a></td>
                        <td width="80">{!! Form::open(array('action' => array('Hrm\EmployeeBasicInfoController@restore', $item->id))) !!}
                            {!! Form::submit($langs['restore'], ['class' => 'btn btn-warning btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
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
    		"aoColumns": [ null, null, { "bSortable": false } ]
    	});
    } );
</script>

@endsection
