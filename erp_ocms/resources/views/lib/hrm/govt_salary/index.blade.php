@extends('app')

@section('htmlheader_title', 'Govt. Salaries')

@section('contentheader_title', 'Govt. Salaries')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('trashed_govt_salary'))
            <a href="{{ url('govt-salary/trashed') }}" class="btn btn-danger pull-right btn-sm trash-btn"><i class="fa fa-trash "></i></a>
            @endif
            @if (Entrust::can('create_govt_salary'))
            <a href="{{ URL::route('govt-salary.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Govt. Salary</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="govt-salary-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['amount'] }}</th>
                        @if (Entrust::can('update_govt_salary'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_govt_salary'))
                        <th></th>
                        @endif
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
                        @if (Entrust::can('update_govt_salary'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('govt-salary.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_govt_salary'))
                        <td width="80">{!! Form::open(['route' => ['govt-salary.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#govt-salary-table").dataTable({
    		"aoColumns": [ null, null, null<?php if (Entrust::can("update_govt_salary")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_govt_salary")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
