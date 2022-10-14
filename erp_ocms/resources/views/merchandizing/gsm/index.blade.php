@extends('app')

@section('htmlheader_title', 'Gsms')

@section('contentheader_title', 'Gsms')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_gsm'))
            <a href="{{ URL::route('gsm.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Gsm</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="gsm-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_gsm'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_gsm'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($gsms as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/gsm', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_gsm'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('gsm.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_gsm'))
                        <td width="80">{!! Form::open(['route' => ['gsm.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#gsm-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_gsm")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_gsm")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
