@extends('app')

@section('htmlheader_title', 'Importmasters')

@section('contentheader_title', 'Import')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		$sl_id='';$cur_id='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/importmaster/importmasterhelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_importmaster'))
            <a href="{{ URL::route('importmaster.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Import</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="importmaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['invoice'] }}</th>
                        <th>{{ $langs['lcimport_id'] }}</th>
                        <th>{{ $langs['lcdate'] }}</th>
                        <th>{{ $langs['supplier_id'] }}</th>
                        <th>{{ $langs['lcvalue'] }}</th>
                        @if (Entrust::can('update_importmaster'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_importmaster'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($importmasters as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                    	<?php 
							$lcimport = DB::table('acc_lcimports')->where('id',$item->lcimport_id)->first(); 
							$lcdate='';$lcvalue=''; $lcnumber='';
							if (isset($lcimport) && $lcimport->id >0 ):
								$lcnumber=$lcimport->lcnumber; 
								$lcvalue=$lcimport->lcvalue!='' ? number_format($lcimport->lcvalue,2) : '' ; 
								$lcdate=$lcimport->lcdate; 
								$sl_id=$lcimport->supplier_id; 
								$cur_id=$lcimport->currency_id; 
							endif;
							  $supllier=DB::table('acc_suppliers')->where('com_id',$com_id)->where('id',$sl_id)->first();
							  $supllier_name=''; isset($supllier) && $supllier->id > 0 ? $supllier_name=$supllier->name : $supllier_name='';

							  $currency=DB::table('acc_currencies')->where('id',$cur_id)->first();
							  $currency_name=''; isset($currency) && $currency->id > 0 ? $currency_name=$currency->name : $currency_name='';

							$imd=DB::table('acc_importdetails')->where('com_id',$com_id)->where('im_id',$item->id)->first();
							$disabled=''; isset($imd) && $imd->id > 0 ? $disabled='disabled' : '';

						?>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/importmaster', $item->id) }}">{{ $item->invoice }}</a></td>
                        <td>{{ $lcnumber }}</td>
                        <td>{{ $lcdate }}</td>
	                    <td>{{ $supllier_name }}</td>
                        <td>{{ $lcvalue.' ('.$currency_name.')' }}</td>
                        
                        @if (Entrust::can('update_importmaster'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('importmaster.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_importmaster'))
                        <td width="80">{!! Form::open(['route' => ['importmaster.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', $disabled, 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#importmaster-table").dataTable({
    		"aoColumns": [ null, null, null, null, null<?php if (Entrust::can("update_importmaster")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_importmaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
