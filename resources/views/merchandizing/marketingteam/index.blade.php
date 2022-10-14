@extends('app')

@section('htmlheader_title', 'Marketingteams')

@section('contentheader_title', 'Marketing Teams')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_marketingteam'))
            <a href="{{ URL::route('marketingteam.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Marketingteam</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="marketingteam-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['designtion'] }}</th>
                        <th>{{ $langs['address'] }}</th>
                        <th>{{ $langs['mobile'] }}</th>
                        <th>{{ $langs['email'] }}</th>
                        @if (Entrust::can('update_marketingteam'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_marketingteam'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($marketingteams as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/marketingteam', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->designation }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->mobile }}</td>
                        <td>{{ $item->email }}</td>
                        @if (Entrust::can('update_marketingteam'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('marketingteam.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_marketingteam'))
                        <td width="80">{!! Form::open(['route' => ['marketingteam.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#marketingteam-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null<?php if (Entrust::can("update_marketingteam")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_marketingteam")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
