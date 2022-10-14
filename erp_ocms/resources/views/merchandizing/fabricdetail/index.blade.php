@extends('app')

@section('htmlheader_title', 'Fabricdetails')

@section('contentheader_title', 'Fabricdetails')

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_fabricdetail'))
            <a href="{{ URL::route('fabricdetail.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Fabricdetail</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="fabricdetail-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['jobno'] }}</th>
                        <th>{{ $langs['gtype_id'] }}</th>
                        <th>{{ $langs['pogarment_id'] }}</th>
                        <th>{{ $langs['diatype_id'] }}</th>
                        <th>{{ $langs['dia_id'] }}</th>
                        <th>{{ $langs['gsm_id'] }}</th>
                        <th>{{ $langs['ftype_id'] }}</th>
                        <th>{{ $langs['ycount_id'] }}</th>
                        <th>{{ $langs['consumption'] }}</th>
                        <th>{{ $langs['wastage'] }}</th>
						<th>{{ $langs['details'] }}</th>
                        @if (Entrust::can('update_fabricdetail'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_fabricdetail'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($fabricdetails as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->jobno }}</td>
                        <td>@if(isset($item->gtype->name)){{ $item->gtype->name }}@endif</td>
                        <td>@if(isset($item->pogarment->name)){{ $item->pogarment->name }}@endif</td>
                        <td>@if(isset($diatypes[$item->diatype_id])){{ $diatypes[$item->diatype_id] }}@endif</td>
                        <td>@if(isset($item->dia->name)){{ $item->dia->name }}@endif</td>
                        <td>@if(isset($item->gsm->name)){{ $item->gsm->name }}@endif</td>
                        <td>@if(isset($item->ftype->name)){{ $item->ftype->name }}@endif</td>
                        <td>@if(isset($item->ycount->name)){{ $item->ycount->name }}@endif</td>
                        <td>{{ $item->consumption }}</td>
                        <td>{{ $item->wastage }}</td>
                        <td><a href="{{ url('/fabricmaster', $item->id) }}">Color and Size</a></td>
                        @if (Entrust::can('update_fabricdetail'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('fabricdetail.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_fabricdetail'))
                        <td width="80">{!! Form::open(['route' => ['fabricdetail.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#fabricdetail-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_fabricdetail")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_fabricdetail")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
