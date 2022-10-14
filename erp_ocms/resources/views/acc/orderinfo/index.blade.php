@extends('app')

@section('htmlheader_title', 'Orderinfos')

@section('contentheader_title', 'Order information')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/orderinfo/orderinfohelp') }}" class="btn btn-primary pull-right btn-sm trash-btn">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_orderinfo'))
            <a href="{{ URL::route('orderinfo.create') }}" title="{{ $langs['add_new'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-plus"></i></a>
            <a href="{{ url('orderinfo/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('orderinfo/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('orderinfo/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('orderinfo/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('orderinfo/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>

            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="orderinfo-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['ordernumber'] }}</th>
                        <th>{{ $langs['lcnumber'] }}</th>
                        <th>{{ $langs['ordervalue'] }}</th>
                        <th>{{ $langs['orderqty'] }}</th>
                        <th>{{ $langs['productdetails'] }}</th>
                        @if (Entrust::can('update_orderinfo'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_orderinfo'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
               <?php //$unit=array('' => 'Select ...', 1 => 'PCS', 2 => 'Dozen'); $currency=array('' => 'Select ...', 1 => 'DOLLAR', 2 => 'EURO'); ?>
                {{-- */$x=0;/* --}}
                @foreach($orderinfos as $item)
                 <?php  
				 	$lc = DB::table('acc_lcinfos')->where('com_id',$com_id)->where('id',$item->lcnumber)->first(); 
					$lc_id=''; isset($lc) && $lc->id > 0 ? $lc_currency_id=$lc->currency_id : $lc_currency_id=''; 
				 	$units = DB::table('acc_units')->where('id',$item->unit_id)->first(); 
					isset($units) && $units ->id>0 ? $unit=$units->name: $unit='';    
					$currencys = DB::table('acc_currencies')->where('id',$lc_currency_id)->first();  
					isset($currencys) && $currencys ->id>0 ? $currency=$currencys->name: $currency='';    
				 ?>
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/lcinfo/costsheet?id='. $item->lcnumber .'&ord_id='. $item->id) }}">{{ $item->ordernumber }}</a></td>
                        <td><a href="{{ url('/lcinfo/costsheet?id='. $item->lcnumber) }}">{{ $lcs[$item->lcnumber] }}</a></td>
                        <td>{{ $item->ordervalue.' ('.$currency.')'}}</td>
                        <td>{{ $item->orderqty .' ('.$unit.')'}}</td>
                        <td>{{ $item->productdetails }}</td>
                        @if (Entrust::can('update_orderinfo'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('orderinfo.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                       @endif
                        @if (Entrust::can('delete_orderinfo'))
                        <td width="80">{!! Form::open(['route' => ['orderinfo.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#orderinfo-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null<?php if (Entrust::can("update_orderinfo")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_orderinfo")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
