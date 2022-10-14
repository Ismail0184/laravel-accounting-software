@extends('app')

@section('htmlheader_title', 'Districts')

@section('contentheader_title', 'Districts')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('trashed_district'))
            <a href="{{ url('district/trashed') }}" class="btn btn-danger pull-right btn-sm trash-btn"><i class="fa fa-trash "></i></a>
            @endif
            @if (Entrust::can('create_district'))
            <a href="{{ URL::route('district.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} District</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="district-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_district'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_district'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($districts as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        @if (Entrust::can('update_district'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('district.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_district'))
                        <td width="80">{!! Form::open(['route' => ['district.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#district-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_district")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_district")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
