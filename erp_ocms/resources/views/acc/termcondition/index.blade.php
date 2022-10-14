@extends('app')

@section('htmlheader_title', 'Termconditions')

@section('contentheader_title', 'Termconditions')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_termcondition'))
            <a href="{{ URL::route('termcondition.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Termcondition</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="termcondition-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['condition_id'] }}</th>
                        @if (Entrust::can('update_termcondition'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_termcondition'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($termconditions as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/termcondition', $item->id) }}">{{ $item->condition->name }}</a></td>
                        @if (Entrust::can('update_termcondition'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('termcondition.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_termcondition'))
                        <td width="80">{!! Form::open(['route' => ['termcondition.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#termcondition-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_termcondition")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_termcondition")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
