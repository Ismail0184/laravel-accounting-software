@extends('app')

@section('htmlheader_title', 'Cprocesses')

@section('contentheader_title', 'Cprocesses')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_cprocess'))
            <a href="{{ URL::route('cprocess.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Cprocess</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="cprocess-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_cprocess'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_cprocess'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($cprocesses as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/cprocess', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_cprocess'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('cprocess.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_cprocess'))
                        <td width="80">{!! Form::open(['route' => ['cprocess.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#cprocess-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_cprocess")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_cprocess")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
