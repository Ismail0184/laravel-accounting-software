@extends('app')

@section('htmlheader_title', 'Conditions')

@section('contentheader_title', 'Conditions')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_condition'))
            <a href="{{ URL::route('condition.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Condition</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="condition-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['topic_id'] }}</th>
                        @if (Entrust::can('update_condition'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_condition'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($conditions as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/condition', $item->id) }}">{{ $item->name }}</a></td>
                        <td>@if(isset($item->topic->name)){{ $item->topic->name }}@endif</td>
                        @if (Entrust::can('update_condition'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('condition.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_condition'))
                        <td width="80">{!! Form::open(['route' => ['condition.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#condition-table").dataTable({
    		"aoColumns": [ null, null, null<?php if (Entrust::can("update_condition")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_condition")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
