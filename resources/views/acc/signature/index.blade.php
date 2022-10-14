@extends('app')

@section('htmlheader_title', 'Signatures')

@section('contentheader_title', 'Signatures')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_signature'))
            <a href="{{ URL::route('signature.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Signature</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="signature-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['designation'] }}</th>
                        <th>{{ $langs['mobile'] }}</th>
                        <th>{{ $langs['email'] }}</th>
                        <th>{{ $langs['website'] }}</th>
                        @if (Entrust::can('update_signature'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_signature'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($signatures as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/signature', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->designation }}</td>
                        <td>{{ $item->mobile }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->website }}</td>
                        @if (Entrust::can('update_signature'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('signature.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_signature'))
                        <td width="80">{!! Form::open(['route' => ['signature.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#signature-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_signature")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_signature")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
