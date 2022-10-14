@extends('app')

@section('htmlheader_title', 'Fletters')

@section('contentheader_title', 'Forwarding letters')

@section('main-content')

    <div class="box">
        <div class="box-header">
            <h3 class="pull-left com">{{ $company->name }}</h3>
            @if (Entrust::can('create_fletter'))
            <a href="{{ URL::route('fletter.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Fletter</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="fletter-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}	</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th>{{ $langs['qdate'] }}</th>
                        <th>{{ $langs['attention'] }}</th>
                        <th>{{ $langs['designtion'] }}</th>
                        <th>{{ $langs['address'] }}</th>
                        <th>{{ $langs['subject'] }}</th>
                        @if (Entrust::can('update_fletter'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_fletter'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($fletters as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/fletter', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->client }}</td>
                        <td>{{ $item->qdate }}</td>
                        <td>{{ $item->attention }}</td>
                        <td>{{ $item->designtion }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->subject }}</td>
                        @if (Entrust::can('update_fletter'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('fletter.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_fletter'))
                        <td width="80">{!! Form::open(['route' => ['fletter.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#fletter-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_fletter")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_fletter")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
