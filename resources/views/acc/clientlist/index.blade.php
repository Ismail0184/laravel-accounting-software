@extends('app')

@section('htmlheader_title', 'Clientlists')

@section('contentheader_title', 'Client lists')

@section('main-content')

    <div class="box">
        <div class="box-header">
            <h3 class="pull-left com">{{ $company->name }}</h3>
            @if (Entrust::can('create_clientlist'))
            <a href="{{ URL::route('clientlist.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Clientlist</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="clientlist-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['group_name'] }}</th>
                        <th>{{ $langs['product'] }}</th>
                        @if (Entrust::can('update_clientlist'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_clientlist'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($clientlists as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/clientlist', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->group_name }}</td>
                        <td>{{ $item->product }}</td>
                        @if (Entrust::can('update_clientlist'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('clientlist.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_clientlist'))
                        <td width="80">{!! Form::open(['route' => ['clientlist.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#clientlist-table").dataTable({
    		"aoColumns": [ null, null, null, null<?php if (Entrust::can("update_clientlist")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_clientlist")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
