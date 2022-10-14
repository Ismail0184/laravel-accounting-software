@extends('app')

@section('htmlheader_title', 'Pomasters')

@section('contentheader_title', 'PO Details')

@section('main-content')
  <?php 		Session::has('jobno') ?  $jobno=Session::get('jobno') : $jobno=''; ?>      
   <div class="box">
        <div class="box-header">
            <h3 class="pull-left mp">@if(isset( $company->name)){{ $company->name }}@endif</h3>
            @if (Entrust::can('create_pomaster') && $jobno!='')
            <a href="{{ URL::route('pomaster.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Pomaster</a>
            @endif
            <form class="navbar-form navbar-left" role="search" action="{{  url('/pomaster/find') }}">
            <div class="form-group col-sm-offset-2">
                <input type="text" class="form-control" placeholder="Job No" name="jobno" id="jobno"><input type="text" class="form-control" placeholder="PO No" name="pono" id="pono">
                <button type="submit" class="btn btn-default">Find</button>
            </div>
			</form>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="pomaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['jobno'] }}</th>
                        <th>{{ $langs['pono'] }}</th>
                        <th>{{ $langs['po_rcvd_date'] }}</th>
                        <th>{{ $langs['factory_ship_date'] }}</th>
                        <th>{{ $langs['shipment_date'] }}</th>
                        <th>{{ $langs['qty'] }}</th>
                        <th>{{ $langs['color_count'] }}</th>
                        <th>{{ $langs['size_count'] }}</th>
                        <th>{{ $langs['port_id'] }}</th>
                        @if (Entrust::can('update_pomaster'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_pomaster'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($pomasters as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->jobno }}</td>
                        <td>{{ $item->pono }}</td>
                        <td>{{ $item->po_rcvd_date }}</td>
                        <td>{{ $item->factory_ship_date }}</td>
                        <td>{{ $item->shipment_date }}</td>
                        <td>{{ $item->qty }}/@if(isset($item->unit->name)){{ $item->unit->name }}@endif</td>
                        <td>{{ $item->color_count }}</td>
                        <td>{{ $item->size_count }}</td>
                        <td><a href="{{ url('/pomaster', $item->id) }}">Add New Port</a></td>
                        @if (Entrust::can('update_pomaster'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('pomaster.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_pomaster'))
                        <td width="80">{!! Form::open(['route' => ['pomaster.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#pomaster-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null, null, null, null<?php if (Entrust::can("update_pomaster")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_pomaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
