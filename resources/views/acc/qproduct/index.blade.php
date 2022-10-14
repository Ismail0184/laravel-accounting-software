@extends('app')

@section('htmlheader_title', 'Qproducts')

@section('contentheader_title', 'Quotation products')

@section('main-content')
    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_qproduct'))
            <h3 class="pull-left com">{{ $company->name }}</h3>
            <a href="{{ URL::route('qproduct.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Qproduct</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="qproduct-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['quotation_id'] }}</th>
                        <th>{{ $langs['prod_id'] }}</th>
                        <th>{{ $langs['qty'] }}</th>
                        <th>{{ $langs['rate'] }}</th>
                        @if (Entrust::can('update_qproduct'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_qproduct'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($qproducts as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/qproduct', $item->id) }}">{{ $item->quotation->name }}</a></td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->rate }}</td>
                        @if (Entrust::can('update_qproduct'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('qproduct.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_qproduct'))
                        <td width="80">{!! Form::open(['route' => ['qproduct.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#qproduct-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_qproduct")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_qproduct")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
