@extends('app')

@section('htmlheader_title', 'Staff Categories')

@section('contentheader_title', 'Staff Categories')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('trashed_staff_category'))
            <a href="{{ url('staff-category/trashed') }}" class="btn btn-danger pull-right btn-sm trash-btn"><i class="fa fa-trash "></i></a>
            @endif
            @if (Entrust::can('create_staff_category'))
            <a href="{{ URL::route('staff-category.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Staff Category</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="staff-category-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_staff_category'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_staff_category'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($staff_categories as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        @if (Entrust::can('update_staff_category'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('staff-category.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_staff_category'))
                        <td width="80">{!! Form::open(['route' => ['staff-category.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#staff-category-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_staff_category")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_staff_category")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
