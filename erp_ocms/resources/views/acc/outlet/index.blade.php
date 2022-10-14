@extends('app')

@section('htmlheader_title', 'Outlets')

@section('contentheader_title', 'Outlets')

@section('main-content')
    <style>
    	#setted { background-color:#CCF}
    </style>

	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';

		Session::has('olt_id') ? 
		$olt_id=Session::get('olt_id') : $olt_id='' ; //echo $olt_id.'osama';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/outlet/outlethelp') }}" class="btn btn-primary pull-right btn-sm trash-btn">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_outlet'))
            <a href="{{ URL::route('outlet.create')}}" title="{{ $langs['add_new'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-plus"></i></a>
            <a href="{{ url('outlet/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('outlet/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('outlet/pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('outlet/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('outlet/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('outlet/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="outlet-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['emp_id'] }}</th>
                        <th>{{ $langs['address'] }}</th>
                        <th>{{ $langs['mobile'] }}</th>
                        <th>{{ $langs['email'] }}</th>
                        <th>{{ $langs['setting'] }}</th>
                        @if (Entrust::can('update_outlet'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_outlet'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <?php 
				$outlets=DB::table('acc_uoutlets')
				->join('acc_outlets', 'acc_uoutlets.olt_id', '=', 'acc_outlets.id')
				->where('acc_outlets.com_id',$com_id)
				->where('acc_uoutlets.com_id',$com_id)
				->where('acc_uoutlets.users_id', Auth::id())->get();
				
				 $employee=array(''=>'Select ...', '1'=>'Hasan Habib'); 
				 ?>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($outlets as $item)
                <?php 
						$olt_id== $item->id ? $setting='setted' : $setting=''; 
						//$item->otype==1 ? $disabled='disabled' : $disabled='';
				?>
                    {{-- */$x++;/* --}}
                    <tr id="{{ $setting }}">
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/outlet', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $employee[$item->emp_id] }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->mobile }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                         {!! Form::open(['url' => 'outlet/filter', 'class' => 'form-horizontal']) !!}
                                <div class="col-sm-10">
                                {!! Form::hidden('olt_id',$item->id ) !!}
                                {!! Form::submit($langs['setting'], ['class' => 'btn btn-primary form-control']) !!}
                                </div>    
                         {!! Form::close() !!}
                         </td>
                        @if (Entrust::can('update_outlet'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('outlet.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_outlet'))
                        <td width="80">{!! Form::open(['route' => ['outlet.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#outlet-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null<?php if (Entrust::can("update_outlet")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_outlet")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
