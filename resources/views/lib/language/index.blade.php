@extends('app')

@section('htmlheader_title', 'Language')

@section('contentheader_title', 'Language')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_language'))
            <a href="{{ URL::route('language.create') }}" class="btn btn-primary pull-right btn-sm">Add New Language</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="language-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Code</th>
                        <th>Value</th>
                        @if (Entrust::can('update_language'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_language'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($languages as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->value }}</td>
                        @if (Entrust::can('update_language'))
                         <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('language.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
<!--                       <td width="80"><a href="{{ url('/language/'.$item->id.'/edit') }}"><button type="submit" class="btn btn-primary btn-block">Update</button></a> </td> 
-->                        @endif
                        @if (Entrust::can('delete_language'))
                        <td width="80">{!! Form::open(['route' => ['language.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#language-table").dataTable({
    		"aoColumns": [ null, null, null<?php if (Entrust::can("update_language")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_language")): ?>, { "bSortable": false }<?php endif ?> ] 
    	});
    } );
</script>

@endsection
