@extends('app')

@section('htmlheader_title', 'B2bs')

@section('contentheader_title', 'B2bs')

@section('main-content')

	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		$edit_disabled='';
		
		$option=DB::table('acc_options')->where('com_id',$com_id)->first(); 
		$currency_id=''; isset($option) && $option->id > 0 ? $currency_id=$option->currency_id : $currency_id='';
		$b2btd_id=''; isset($option) && $option->id > 0 ? $b2btd_id=$option->b2btd_id : $b2btd_id='';
		
		
		$delivery_vn='';$delivery=''; $find_data='no';
		?>

    <div class="box">
        <div class="box-header">
            <h3 style="margin:0px; padding:0px" class="pull-left">{{ $com_name }}</h3>
        	<a href="{{ url('/tranmaster/tranmasterhelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_b2b'))
            <a href="{{ URL::route('b2b.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} B2b</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="b2b-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['blcnumber'] }}</th>
                        <th>{{ $langs['lc_id'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th>{{ $langs['bdate'] }}</th>
                        <th>{{ $langs['acc_id'] }}</th>
                        <th class="text-right">{{ $langs['bamount'] }}</th>
                        <th>{{ $langs['tran'] }}</th>
                        <th>Delivery</th>
                        @if (Entrust::can('update_b2b'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_b2b'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($b2bs as $item)
                    {{-- */$x++;/* --}}
                    <?php  
						$lc=DB::table('acc_lcinfos')->where('id',$item->lc_id)->first();
						$lc_number=''; isset($lc) && $lc->id>0 ? $lc_number=$lc->lcnumber : $lc_number='';
						$lc_currency_id=''; isset($lc) && $lc->id > 0 ? $lc_currency_id=$lc->currency_id : $lc_currency_id=''; 
						
						$cur=DB::table('acc_currencies')->where('id',$lc_currency_id)->first();
						$cur_name=''; isset($cur) && $cur->id > 0 ? $cur_name=$cur->name : $cur_name=''; 

						$client=DB::table('acc_clients')->where('id',$item->client_id)->first();
						$client_name=''; isset($client) && $client->id>0 ? $client_name=$client->name : $client_name='';
						$item->bamount> 0 ? $item->bamount=number_format($item->bamount,2) : '';

						$find=DB::table('acc_trandetails')->where('com_id',$com_id)
						->where('acc_id',$b2btd_id)->where('b2b_id', $item->id)->first(); 
						isset($find) && $find->id>0 ? $find_data='yes' : $find_data='no';
						$vn='';isset($find) && $find->id>0 ? $vn=$find->tm_id : $vn='';

						$coa=DB::table('acc_coas')->where('com_id',$com_id)->where('id', $item->acc_id)->first(); 
						$coa_name=''; isset($coa) && $coa->id > 0 ? $coa_name=$coa->name : $coa_name='';

						$del=DB::table('acc_trandetails')->where('com_id',$com_id)
						->where('acc_id',$item->acc_id)->where('lc_id', $item->id)->first();  //echo $item->acc_id; 
						isset($del) && $del->id > 0 ? $delivery='yes' : $delivery='';
						isset($del) && $del->id > 0 ? $delivery_vn=$del->tm_id : $delivery_vn=''; //echo $delivery;
					?>
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->blcnumber }}</td>
                        <td><a href="{{ url('/b2b/report?lc_id='. $item->lc_id) }}">{{ $lc_number }}</a></td>
                        <td><a href="{{ url('/b2b/report?client_id='. $item->client_id) }}">{{ $client_name }}</a></td>
                        <td>{{ $item->bdate }}</td>
                        <td>{{ $coa_name }}</td>
                        <td class="text-right">{{ $item->bamount.' ('.$cur_name.')' }}</td>
                        @if ($find_data=='no')	 
                        	<td><a href="{{ url('/b2b', $item->id) }}">Traansaction</a></td>
                            <td>Product Delivery</td>
                        @else
                        	<td><a href="{{ url('/tranmaster/voucher', $vn) }}">Voucher</a></td>
                            @if ($delivery=='')
                            <td><a href="{{ url('/b2b', $item->id) }}">Product Delivery</a></td>
                            @else
                            <td><a href="{{ url('/tranmaster/voucher', $delivery_vn) }}">Product Delivered</a></td>
                            @endif
                        @endif
                        
                        @if (Entrust::can('update_b2b'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('b2b.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_b2b'))
                        <td width="80">{!! Form::open(['route' => ['b2b.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#b2b-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null, null<?php if (Entrust::can("update_b2b")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_b2b")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
