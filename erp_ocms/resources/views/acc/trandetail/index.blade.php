@extends('app')

@section('htmlheader_title', 'Trandetails')

@section('contentheader_title', 'Trandetails')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_trandetail'))
            <a href="{{ URL::route('trandetail.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Trandetail</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="trandetail-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_trandetail'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_trandetail'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($trandetails as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/trandetail', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_trandetail'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('trandetail.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_trandetail'))
                        <td width="80">{!! Form::open(['route' => ['trandetail.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#trandetail-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_trandetail")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_trandetail")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
