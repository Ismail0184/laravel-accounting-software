@extends('app')

@section('htmlheader_title', 'Lcimports')

@section('contentheader_title', 'Lc for import')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/lcimport/lcimporthelp') }}" class="btn btn-primary pull-right btn-sm trash-btn">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_lcimport'))
            <a href="{{ URL::route('lcimport.create')}}" title="{{ $langs['add_new'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-plus"></i></a>
            <a href="{{ url('lcimport/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('lcimport/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('lcimport/pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('lcimport/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('lcimport/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('lcimport/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="lcimport-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['lcnumber'] }}</th>
                        <th>{{ $langs['lcdate'] }}</th>
                        <th>{{ $langs['shipmentdate'] }}</th>
                        <th>{{ $langs['lcvalue'] }}</th>
                        <th>{{ $langs['country_id'] }}</th>
                        @if (Entrust::can('update_lcimport'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_lcimport'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                <?php //$country=array('' => 'Select ...', 1 => 'UK', 2 => 'USA'); ?>
                {{-- */$x=0;/* --}}
                @foreach($lcimports as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/lcimport', $item->id) }}">{{ $item->lcnumber }}</a></td>
                        <td>{{ $item->lcdate }}</td>
                        <td>{{ $item->shipmentdate }}</td>
                        <td>{{ $item->lcvalue }}</td>
                        <td>{{ $country[$item->country_id] }}</td>
                        @if (Entrust::can('update_lcimport'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('lcimport.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_lcimport'))
                        <td width="80">{!! Form::open(['route' => ['lcimport.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#lcimport-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null<?php if (Entrust::can("update_lcimport")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_lcimport")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
