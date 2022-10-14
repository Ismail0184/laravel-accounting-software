@extends('app')

@section('htmlheader_title', 'Lcmodes')

@section('contentheader_title', 'LC Modes')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_lcmode'))
            <a href="{{ URL::route('lcmode.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Lcmode</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="lcmode-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_lcmode'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_lcmode'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($lcmodes as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/lcmode', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_lcmode'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('lcmode.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_lcmode'))
                        <td width="80">{!! Form::open(['route' => ['lcmode.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#lcmode-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_lcmode")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_lcmode")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
