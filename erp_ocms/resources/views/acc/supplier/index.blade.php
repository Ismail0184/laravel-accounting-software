@extends('app')

@section('htmlheader_title', 'Suppliers')

@section('contentheader_title', 'Suppliers')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		
		Session::put('sdfrom', date('Y-01-01'));
		Session::put('sdto', date('Y-m-d'));

		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/supplier/supplierhelp') }}" class="btn btn-primary pull-right btn-sm trash-btn">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_supplier'))
            <a href="{{ URL::route('supplier.create') }}" title="{{ $langs['add_new'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-plus"></i></a>
            <a href="{{ url('supplier/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('supplier/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('supplier/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('supplier/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('supplier/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="supplier-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['contact'] }}</th>
                        <th>{{ $langs['address'] }}</th>
                        <th>{{ $langs['country_id'] }}</th>
                        <th>{{ $langs['email'] }}</th>
                        @if (Entrust::can('update_supplier'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_supplier'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                <?php //$country=array('' => 'Select ...', 1 => 'UK', 2 => 'USA'); ?>
                {{-- */$x=0;/* --}}
                @foreach($suppliers as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/importmaster/supplier?supplier_id='. $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->contact }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $country[$item->country_id] }}</td>
                        <td>{{ $item->email }}</td>
                        @if (Entrust::can('update_supplier'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('supplier.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_supplier'))
                        <td width="80">{!! Form::open(['route' => ['supplier.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#supplier-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null<?php if (Entrust::can("update_supplier")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_supplier")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
