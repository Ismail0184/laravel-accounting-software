@extends('app')

@section('htmlheader_title', 'Currencies')

@section('contentheader_title', 'Currencies')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_acc-currency'))
            <a href="{{ URL::route('acc-currency.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Currency</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="currency-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_acc-currency'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_acc-currency'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($currencies as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/currency', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_acc-currency'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('acc-currency.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_acc-currency'))
                        <td width="80">{!! Form::open(['route' => ['acc-currency.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#currency-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_acc-currency")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_acc-currency")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
