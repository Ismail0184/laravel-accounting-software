@extends('app')

@section('htmlheader_title', 'Grades')

@section('contentheader_title', 'Grades')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('trashed_grade'))
            <a href="{{ url('grade/trashed') }}" class="btn btn-danger pull-right btn-sm trash-btn"><i class="fa fa-trash "></i></a>
            @endif
            @if (Entrust::can('create_grade'))
            <a href="{{ URL::route('grade.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Grade</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="grade-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_grade'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_grade'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($grades as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        @if (Entrust::can('update_grade'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('grade.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_grade'))
                        <td width="80">{!! Form::open(['route' => ['grade.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#grade-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_grade")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_grade")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
