@extends('app')

@section('htmlheader_title', 'Countries')

@section('contentheader_title', 'Countries')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_country'))
            <a href="{{ URL::route('country.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Country</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="country-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_country'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_country'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($countries as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/country', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_country'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('country.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_country'))
                        <td width="80">{!! Form::open(['route' => ['country.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#country-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_country")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_country")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
