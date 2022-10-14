@extends('app')

@section('htmlheader_title', 'Buyers')

@section('contentheader_title', 'Buyers')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_buyer'))
            <a href="{{ URL::route('buyer.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Buyer</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="buyer-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['agent'] }}</th>
                        <th>{{ $langs['cperson'] }}</th>
                        <th>{{ $langs['address'] }}</th>
                        <th>{{ $langs['email'] }}</th>
                        <th>{{ $langs['web'] }}</th>
                        @if (Entrust::can('update_buyer'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_buyer'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($buyers as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/buyer', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->agent }}</td>
                        <td>{{ $item->cperson }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->web }}</td>
                        @if (Entrust::can('update_buyer'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('buyer.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_buyer'))
                        <td width="80">{!! Form::open(['route' => ['buyer.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#buyer-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null<?php if (Entrust::can("update_buyer")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_buyer")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
