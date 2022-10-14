@extends('app')

@section('htmlheader_title', 'Pogarments')

@section('contentheader_title', 'Pogarments')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_pogarment'))
            <a href="{{ URL::route('pogarment.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Pogarment</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="pogarment-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_pogarment'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_pogarment'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($pogarments as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/pogarment', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_pogarment'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('pogarment.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_pogarment'))
                        <td width="80">{!! Form::open(['route' => ['pogarment.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#pogarment-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_pogarment")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_pogarment")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
