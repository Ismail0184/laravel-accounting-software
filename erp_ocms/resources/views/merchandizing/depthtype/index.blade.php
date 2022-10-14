@extends('app')

@section('htmlheader_title', 'Depthtypes')

@section('contentheader_title', 'Depthtypes')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_depthtype'))
            <a href="{{ URL::route('depthtype.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Depthtype</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="depthtype-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_depthtype'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_depthtype'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($depthtypes as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/depthtype', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_depthtype'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('depthtype.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_depthtype'))
                        <td width="80">{!! Form::open(['route' => ['depthtype.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#depthtype-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_depthtype")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_depthtype")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
