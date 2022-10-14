@extends('app')

@section('htmlheader_title', 'Lc')

@section('contentheader_title', 'Lc Information')
@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';

		$option=DB::table('acc_options')->where('com_id',$com_id)->first(); 
		$currency_id=''; isset($option) && $option->id > 0 ? $currency_id=$option->currency_id : $currency_id='';
		$cur=DB::table('acc_currencies')->where('id',$currency_id)->first();
		$cur_name=''; isset($cur) && $cur->id > 0 ? $cur_name=$cur->name : $cur_name=''; 
		$mlctd_id=''; isset($option) && $option->id > 0 ? $mlctd_id=$option->mlctd_id : $mlctd_id='';


		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/lcinfo/lchelp') }}" class="btn btn-primary pull-right btn-sm trash-btn">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_lcinfo'))
            <a href="{{ URL::route('lcinfo.create') }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-plus"></i></a>
            <a href="{{ url('lcinfo/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('lcinfo/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('lcinfo/pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('lcinfo/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('lcinfo/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('lcinfo/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
            @endif
            

        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="lcinfo-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['lcnumber'] }}</th>
                        <th>{{ $langs['lcdate'] }}</th>
                        <th>{{ $langs['shipmentdate'] }}</th>
                        <th>{{ $langs['buyer_id'] }}</th>
                        <th>{{ $langs['country_id'] }}</th>
                        <th>{{ $langs['lcamount'] }}</th>
                        <th>{{ $langs['crateto'] }}</th>
                        <th>{{ $langs['tran'] }}</th>
                        @if (Entrust::can('update_lcinfo'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_lcinfo'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($lcinfos as $item)
                    {{-- */$x++;/* --}}
                    <?php 
					$find=DB::table('acc_trandetails')->where('com_id',$com_id)
					->where('acc_id',$mlctd_id)->where('lc_id', $item->id)->first(); 
					$find_data='no';isset($find) && $find->id>0 ? $find_data='yes' : $find_data='no';
					$vn='';isset($find) && $find->id>0 ? $vn=$find->tm_id : $vn='';
					
					$buyer=DB::table('acc_buyerinfos')->where('com_id',$com_id)->where('id',$item->buyer_id)->first();
					$buyer_name=''; isset($buyer) && $buyer->id > 0 ? $buyer_name=$buyer->name : $buyer_name='';
					
					?>
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/lcinfo/costsheet?id='. $item->id) }}">{{ $item->lcnumber }}</a></td>
                        <td>{{ $item->lcdate }}</td>
                        <td>{{ $item->shipmentdate }}</td>
                        <td><a href="{{ url('/lcinfo/report?buyer_id='. $item->buyer_id) }}">{{ $buyer_name }}</a></td>
                        <td><a href="{{ url('/lcinfo/report?country_id='. $item->country_id) }}">{{ $item->country->name }}</a></td>
                        <td>{{ $item->lcamount.' ('. $item->currency->name  .')' }}</td>
                        <td>{{ $item->crateto.' '.$cur_name  }}</td>
                        @if ($find_data=='no')	 
                        	<td><a href="{{ url('/lcinfo', $item->id) }}">Traansaction</a></td>
                        @else
                        	<td><a href="{{ url('/tranmaster/voucher', $vn) }}">Voucher</a></td>
                        @endif
                        @if (Entrust::can('update_lcinfo'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('lcinfo.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_lcinfo'))
                        <td width="80">{!! Form::open(['route' => ['lcinfo.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#lcinfo-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null, null<?php if (Entrust::can("update_lcinfo")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_lcinfo")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
