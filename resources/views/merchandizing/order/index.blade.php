@extends('app')

@section('htmlheader_title', 'Orders')

@section('contentheader_title', 'Order Information')

@section('main-content')
<style>
	.mp { margin:0px; padding:0px}
</style>
    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_order'))
            <h3 class="pull-left mp">@if(isset( $company->name)){{ $company->name }}@endif</h3>
            <a href="{{ URL::route('order.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Order</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="order-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['jobno'] }}</th>
                        <th>{{ $langs['orderno'] }}</th>
                        <th>{{ $langs['buyer_id'] }}</th>
                        <th>{{ $langs['price'] }}</th>
                        <th>{{ $langs['bd_id'] }}</th>
                        <th>{{ $langs['incoterm_id'] }}</th>
                        <th>{{ $langs['document'] }}</th>
                        @if (Entrust::can('update_order'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_order'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($orders as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->jobno }}</td>
                        <td>{{ $item->orderno }}</td>
                        <td>@if(isset($item->buyer->name)){{ $item->buyer->name }}@endif</td>
                        <td>{{ $item->price }}/@if(isset($item->currency->name)){{ $item->currency->name }}@endif</td>
                        <td><a href="{{ url('/order', $item->id) }}">@if(isset($item->breakdown->name)){{ $item->breakdown->name }}@endif </a></td>
                        <td>@if(isset($item->incoterm->name)){{ $item->incoterm->name }}@endif</td>
                        <td><a href="{{ url('/fileentry',$item->orderno.'?module=merch') }}">File Upload</a></td>
                        @if (Entrust::can('update_order'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('order.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_order'))
                        <td width="80">{!! Form::open(['route' => ['order.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#order-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null, null<?php if (Entrust::can("update_order")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_order")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
