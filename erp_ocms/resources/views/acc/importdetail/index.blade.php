@extends('app')

@section('htmlheader_title', 'Importdetails')

@section('contentheader_title', 'Importdetails')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_importdetail'))
            <a href="{{ URL::route('importdetail.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Importdetail</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="importdetail-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_importdetail'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_importdetail'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($importdetails as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/importdetail', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_importdetail'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('importdetail.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_importdetail'))
                        <td width="80">{!! Form::open(['route' => ['importdetail.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#importdetail-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_importdetail")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_importdetail")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
