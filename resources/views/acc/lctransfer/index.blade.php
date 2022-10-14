@extends('app')

@section('htmlheader_title', 'Lctransfers')

@section('contentheader_title', 'Lc Tsransfers')

@section('main-content')

	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		$edit_disabled='';
		
		$option=DB::table('acc_options')->where('com_id',$com_id)->first(); 
		$currency_id=''; isset($option) && $option->id > 0 ? $currency_id=$option->currency_id : $currency_id='';
		$cur=DB::table('acc_currencies')->where('id',$currency_id)->first();
		$cur_name=''; isset($cur) && $cur->id > 0 ? $cur_name=$cur->name : $cur_name=''; 
		$tlctd_id=''; isset($option) && $option->id > 0 ? $tlctd_id=$option->tlctd_id : $tlctd_id='';

		?>

    <div class="box">
        <div class="box-header">
            <h3 style="margin:0px; padding:0px" class="pull-left">{{ $com_name }}</h3>
            @if (Entrust::can('create_lctransfer'))
        	<a href="{{ url('/tranmaster/tranmasterhelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            <a href="{{ URL::route('lctransfer.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Lctransfer</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="lctransfer-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th>{{ $langs['lc_id'] }}</th>
                        <th>{{ $langs['lcamount'] }}</th>
                        <th>{{ $langs['tlcdate'] }}</th>
                        <th>{{ $langs['com_rate'] }}</th>
                        <th>{{ $langs['camount'] }}</th>
                        <th>{{ $langs['tran'] }}</th>
                        <th>{{ $langs['shipment'] }}</th>
                        @if (Entrust::can('update_lctransfer'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_lctransfer'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($lctransfers as $item)
                    {{-- */$x++;/* --}}
                    <?php 
						$lc=DB::table('acc_lcinfos')->where('id',$item->lc_id)->first();
						isset($lc) && $lc->id>0 ?  $lc_id =$lc->id : $lc_id =0;
						
						$lc_number=''; isset($lc) && $lc->id>0 ? $lc_number=$lc->lcnumber : $lc_number='';
						$lc_value=''; isset($lc) && $lc->id>0 ? $lc_value=$lc->lcamount : $lc_value=''; //echo $lc_value;
						$cur_id=''; isset($lc) && $lc->id>0 ? $cur_id=$lc->currency_id : $cur_id='';
						$currency=DB::table('acc_currencies')->where('id',$cur_id)->first();
						$currency_name=''; isset($currency) && $currency->id>0 ? $currency_name=$currency->name : $currency_name='';
						
						$client=DB::table('acc_clients')->where('id',$item->client_id)->first();
						$client_name=''; isset($client) && $client->id>0 ? $client_name=$client->name : $client_name='';
						$item->bamount> 0 ? $item->bamount=number_format($item->bamount,2) : '';
					
					$find=DB::table('acc_trandetails')->where('com_id',$com_id)
					->where('acc_id',$tlctd_id)->where('lc_id', $item->lc_id)->first(); 
					$find_data='no';isset($find) && $find->id>0 ? $find_data='yes' : $find_data='no';
					$vn='';isset($find) && $find->id>0 ? $vn=$find->tm_id : $vn='';

					//DB::table('a')->first();
					
					$ship=DB::table('acc_trandetails')->where('com_id',$com_id)
					->where('acc_id',$option->mlctc_id)->where('lc_id', $item->id)->count('acc_id');  

					$shipvn=DB::table('acc_trandetails')->where('com_id',$com_id)->where('acc_id',$option->mlctc_id)->where('lc_id', $item->id)
					->Latest()->first();  
					$ship_vn=''; isset($shipvn) && $shipvn->id > 0 ? $ship_vn=$shipvn->tm_id : $ship_vn=''; 


					?>
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/lctransfer/report?buyer_id='. $item->id) }}">{{ $client_name }}</a></td>
                        <td>{{ $lc_number }}</td>
                        <td>{{ $lc_value.'('.$currency_name.')' }}</td>
                        <td>{{ $item->tlcdate }}</td>
                        <td>{{ $item->com_rate }}</td>
                        <td>{{ $item->camount }}</td>
                        @if ($find_data=='no')	 
                        	<td><a href="{{ url('/lctransfer', $item->id) }}">Traansaction</a></td>
                        @else
                        	<td><a href="{{ url('/tranmaster/voucher', $vn) }}">Voucher</a></td>
                        @endif
                        	@if ($ship=='2')
                         		<th><a href="{{ url('/tranmaster/voucher', $ship_vn) }}">Voucher</a></th>
                            @else
                                @if ($find_data=='yes')	 
                                	<th><a href="{{ url('/lctransfer', $item->id) }}">{{ $langs['shipment'] }}</a></th>
                                @else
                                	<th>{{ $langs['shipment'] }}</th>
                                @endif
                         	@endif
                         $endif
                            
                        @if (Entrust::can('update_lctransfer'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('lctransfer.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_lctransfer'))
                        <td width="80">{!! Form::open(['route' => ['lctransfer.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#lctransfer-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null<?php if (Entrust::can("update_lctransfer")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_lctransfer")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
