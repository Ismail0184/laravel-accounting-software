@extends('app')

@section('htmlheader_title', 'Sub Sections')

@section('contentheader_title', 'Sub Sections')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('trashed_sub_section'))
            <a href="{{ url('sub-section/trashed') }}" class="btn btn-danger pull-right btn-sm trash-btn"><i class="fa fa-trash "></i></a>
            @endif
            @if (Entrust::can('create_sub_section'))
            <a href="{{ URL::route('sub-section.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Sub Section</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="sub_section-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_sub_section'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_sub_section'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($sub_sections as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        @if (Entrust::can('update_sub_section'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('sub-section.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_sub_section'))
                        <td width="80">{!! Form::open(['route' => ['sub-section.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#sub_section-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_sub_section")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_sub_section")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
