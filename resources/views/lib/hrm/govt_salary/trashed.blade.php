@extends('app')

@section('htmlheader_title', 'Govt. Salaries')

@section('contentheader_title', 'Govt. Salaries')

@section('main-content')

    <div class="box">
        <div class="box-header">
            <a href="{{ URL::route('govt-salary.index') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['back_to'] }} Govt. Salaries</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="govt-salary-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['amount'] }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($govt_salaries as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->amount }}</td>
                        <td width="80">{!! Form::open(array('action' => array('Lib\Hrm\GovtSalaryController@restore', $item->id))) !!}
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
        $("#govt-salary-table").dataTable({
    		"aoColumns": [ null, null, null, { "bSortable": false } ]
    	});
    } );
</script>

@endsection
