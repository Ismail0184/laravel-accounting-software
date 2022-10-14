@extends('app')

@section('htmlheader_title', 'Salemasters')

@section('contentheader_title', 'Sales')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';

		Session::has('olt_id') ? $olt_id=Session::get('olt_id') : $olt_id='' ;  
		$outlet=DB::table('acc_outlets')->where('id',$olt_id)->first(); 
		$outlet_name=''; isset($outlet) && $outlet->id >0 ? $outlet_name=$outlet->name : $outlet_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}/{{ $outlet_name }}</h3>
            @if (Entrust::can('create_salemaster'))
            <a href="{{ URL::route('salemaster.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Sale</a>
            @endif
        	<a href="{{ url('/salemaster?flag=filter') }}" class="btn btn-primary pull-left btn-sm">{{ $langs['filter'] }}</a>
            <?php
            						$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'salemaster/ifilter', 'class' => 'form-horizontal']) !!}
            				<table><tr><td style="width:400px">
                    		<div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  date('Y-m-01'), ['class' => 'form-control', 'id'=>'dfrom', 'required']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dto', $langs['dto'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dto',  date('Y-m-d'), ['class' => 'form-control', 'id'=>'dto', 'required']) !!}
                                </div>    
                            </div>                            
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-3">
                                {!! Form::submit($langs['find'], ['class' => 'btn btn-primary form-control']) !!}
                                </div>    
                            </div>
                            </td></tr></table>
                          {!! Form::close() !!}
                     @endif
               

        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="salemaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['invoice'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th>{{ $langs['mt_id'] }}</th>
                        <th>{{ $langs['amount'] }}</th>
                        <th>{{ $langs['note'] }}</th>
                        @if (Entrust::can('update_salemaster'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_salemaster'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($salemasters as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                    <?php 
						$client=DB::table('acc_clients')->where('com_id',$com_id)->where('id', $item->client_id)->first();
						$client_name=''; isset($client) && $client->id > 0 ? $client_name=$client->name : $client_name='';
						
						$item->client_id==0 ?  $client_name=$item->client : '';
						
						$mteam=DB::table('acc_mteams')->where('com_id',$com_id)->where('id', $item->mt_id)->first();
						$mteam_name=''; isset($mteam) && $mteam->id > 0 ? $mteam_name=$mteam->name : $mteam_name='';
						
						$sale=DB::table('acc_saledetails')->where('sm_id', $item->id)->first();
						$disabled=''; isset($sale) && $sale->id>0 ? $disabled='disabled' : $disabled='';
					?>
                        <td width="50">{{ $x }}</td>
                        @if($item->check_action==1)
                        <td>{{ $item->sdate }}/Inv: {{ $item->invoice }}</td>
                        @else
                        <td><a href="{{ url('/salemaster', $item->id) }}">{{ $item->sdate }}/Inv: {{ $item->invoice }}</a></td>
                        @endif
                        <td>{{ $client_name }}</td>
                        <td>{{ $mteam_name }}</td>
                        <td><a href="{{ url('salemaster/invoice?flag='.$item->id) }}">Invoice: {{ $item->samount }} / Piad: {{ $item->paid }}</a></td>
                        <td>{{ $item->note }}</td>
                        @if (Entrust::can('update_salemaster'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('salemaster.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_salemaster'))
                        <td width="80">{!! Form::open(['route' => ['salemaster.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', $disabled,  'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#salemaster-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null<?php if (Entrust::can("update_salemaster")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_salemaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
	
			$( "#dfrom" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
        $( "#dto" ).datepicker({ dateFormat: "yy-mm-dd" }).val();

</script>

@endsection
