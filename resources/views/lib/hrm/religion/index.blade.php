@extends('app')

@section('htmlheader_title', 'Religions')

@section('contentheader_title', 'Religions')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('trashed_religion'))
            <a href="{{ url('religion/trashed') }}" class="btn btn-danger pull-right btn-sm trash-btn"><i class="fa fa-trash "></i></a>
            @endif
            @if (Entrust::can('create_religion'))
            <a href="{{ URL::route('religion.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Religion</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="religion-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_religion'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_religion'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($religions as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        @if (Entrust::can('update_religion'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('religion.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_religion'))
                        <td width="80">{!! Form::open(['route' => ['religion.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#religion-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_religion")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_religion")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
