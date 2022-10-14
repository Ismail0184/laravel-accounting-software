@extends('app')

@section('htmlheader_title', 'Styles')

@section('contentheader_title', 'Styles')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/style/stylehelp') }}" class="btn btn-primary pull-right btn-sm trash-btn">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_style'))
            <a href="{{ URL::route('style.create') }}" title="{{ $langs['add_new'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-plus"></i></a>
            <a href="{{ url('style/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('style/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('style/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('style/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('style/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>

            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="style-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['ordernumber'] }}</th>
                        <th>{{ $langs['stylevalue'] }}</th>
                        <th>{{ $langs['styleqty'] }}</th>
                        <th>{{ $langs['description'] }}</th>
                        @if (Entrust::can('update_style'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_style'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                <?php $unit=array('' => 'Select ...', 1 => 'PCS', 2 => 'Dozen'); $currency=array('' => 'Select ...', 1 => 'DOLLAR', 2 => 'EURO'); ?>
                {{-- */$x=0;/* --}}
                @foreach($styles as $item)
                 <?php  
				 	$order = DB::table('acc_orderinfos')->where('id',$item->ordernumber)->first();
					$lc = DB::table('acc_lcinfos')->where('id',$order->lcnumber)->first(); //echo $lc->currency_id;
				   ?>
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/style', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $orders[$item->ordernumber] }}</td>
                        <td>{{ $item->stylevalue .' ('. $currency[$lc->currency_id].')' }}</td>
                        <td>{{ $item->styleqty .' ('. $unit[$item->unit_id].')' }}</td>
                        <td>{{ $item->description }}</td>
                        
                        @if (Entrust::can('update_style'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('style.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_style'))
                        <td width="80">{!! Form::open(['route' => ['style.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#style-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null<?php if (Entrust::can("update_style")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_style")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
