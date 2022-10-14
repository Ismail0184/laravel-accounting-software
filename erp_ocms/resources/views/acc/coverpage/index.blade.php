@extends('app')

@section('htmlheader_title', 'Coverpages')

@section('contentheader_title', 'Coverpages')

@section('main-content')

    <div class="box">
        <div class="box-header">
            <h3 class="pull-left com">{{ $company->name }}</h3>
            @if (Entrust::can('create_coverpage'))
            <a href="{{ URL::route('coverpage.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Coverpage</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="coverpage-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['header'] }}</th>
                        <th>{{ $langs['mtitle'] }}</th>
                        <th>{{ $langs['subtitle'] }}</th>
                        <th>{{ $langs['estyear'] }}</th>
                        <th>{{ $langs['breif'] }}</th>
                        <th>{{ $langs['footer'] }}</th>
                        @if (Entrust::can('update_coverpage'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_coverpage'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($coverpages as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/coverpage', $item->id) }}">{{ $item->header }}</a></td>
                        <td>{{ $item->mtitle }}</td>
                        <td>{{ $item->subtitle }}</td>
                        <td>{{ $item->estyear }}</td>
                        <td>{{ $item->breif }}</td>
                        <td>{{ $item->footer }}</td>
                        @if (Entrust::can('update_coverpage'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('coverpage.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_coverpage'))
                        <td width="80">{!! Form::open(['route' => ['coverpage.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#coverpage-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_coverpage")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_coverpage")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
