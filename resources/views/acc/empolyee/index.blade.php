@extends('app')

@section('htmlheader_title', 'Empolyees')

@section('contentheader_title', 'Employees')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_empolyee'))
            <a href="{{ URL::route('empolyee.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Empolyee</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="empolyee-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['designation_id'] }}</th>
                        <th>{{ $langs['department_id'] }}</th>
                        <th>{{ $langs['gsalary'] }}</th>
                        @if (Entrust::can('update_empolyee'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_empolyee'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($empolyees as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->name }}</td>
                        <td>@if(isset($item->designation->name)){{ $item->designation->name }}@endif</td>
                        <td>@if(isset($item->department->name)){{ $item->department->name }}@endif</td>
                        <td><a href="{{ url('/empolyee/salary') }}">{{ $item->gsalary }}</a></td>

                        @if (Entrust::can('update_empolyee'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('empolyee.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_empolyee'))
                        <td width="80">{!! Form::open(['route' => ['empolyee.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa disabled', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#empolyee-table").dataTable({
    		"aoColumns": [ null, null, null, null, null<?php if (Entrust::can("update_empolyee")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_empolyee")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
