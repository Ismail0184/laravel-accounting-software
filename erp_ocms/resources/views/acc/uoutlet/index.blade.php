@extends('app')

@section('htmlheader_title', 'Uoutlets')

@section('contentheader_title', 'Uoutlets')

@section('main-content')
    <style>
    	#setted { background-color:#CCF}
    </style>

<?php 
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		
		Session::has('olt_id') ? 
		$olt_id=Session::get('olt_id') : $olt_id='' ; //echo $com_id.'osama';


?>
    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_uoutlet'))
            <a href="{{ URL::route('uoutlet.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Uoutlet</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="uoutlet-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['designation'] }}</th>
                        <th>{{ $langs['olt_id'] }}</th>
                        <th>{{ $langs['users_id'] }}</th>
                        <th>{{ $langs['setting'] }}</th>
                        @if (Entrust::can('update_uoutlet'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_uoutlet'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($uoutlets as $item)
                    {{-- */$x++;/* --}}
                    <?php

						$outlet=DB::table('acc_outlets')->where('id',$item->olt_id)->where('com_id',$com_id)->first();
						$outlet_name=''; isset($outlet) && $outlet->id > 0 ? $outlet_name=$outlet->name : $outlet_name='';
					 ?>
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/uoutlet', $item->id) }}">{{ $item->designation }}</a></td>
                        <td>{{ $outlet_name }}</td>
                        <td>{{ $users[$item->users_id] }}</td>
                        <td>{{ $item->setting }}</td>
                        @if (Entrust::can('update_uoutlet'))</td>
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('uoutlet.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_uoutlet'))
                        <td width="80">{!! Form::open(['route' => ['uoutlet.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#uoutlet-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_uoutlet")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_uoutlet")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
