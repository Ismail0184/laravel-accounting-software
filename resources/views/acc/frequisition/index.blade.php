@extends('app')

@section('htmlheader_title', 'Fund Requisitions')

@section('contentheader_title', 'Fund Requisitions')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/frequisition/frequisitionhelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_frequisition'))
            <a href="{{ URL::route('frequisition.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Fund Requisitions</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="frequisition-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['pr_id'] }}</th>
                        <th>{{ $langs['description'] }}</th>
                        <th class="text-right">{{ $langs['ramount'] }}</th>
                        <th class="text-right">{{ $langs['aamount'] }}</th>
                        <th >{{ $langs['check_id'] }}</th>
                        <th >{{ $langs['appr_id'] }}</th>
                        @if (Entrust::can('update_frequisition'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_frequisition'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($frequisitions as $item)
                <?php $item->check_action==1 ? $disabled="disabled" : $disabled=""; ?>
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/frequisition', $item->id) }}">{{ $item->preq->name }}</a></td>
                        <td>{{ $item->preq->description }}</td>
                        <td class="text-right">{{ $item->ramount. '('. $item->currency->name .')' }}</td>
                        <td class="text-right">{{ $item->aamount. '('. $item->currency->name .')' }}</td>
                        <td>{{ $item->check->name }}</td>
                        <td>{{ $item->approve->name }}</td>
                        @if (Entrust::can('update_frequisition'))
                        <td width="80"><a class="btn btn-primary btn-block {{ $disabled }}" href="{{ URL::route('frequisition.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_frequisition'))
                        <td width="80">{!! Form::open(['route' => ['frequisition.destroy', $item->id], 'method' => 'DELETE']) !!}
                            @if ($disabled=="disabled")
                            	{!! Form::submit($langs['delete'], ['class' => 'btn btn-danger btn-block disabled', 'onclick' => 'return confirm("Are you sure?");']) !!}
                            @else
                           	 	{!! Form::submit($langs['delete'], ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                            @endif
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
        $("#frequisition-table").dataTable({
    		"aoColumns": [ null, null, null,null ,null,null,null<?php if (Entrust::can("update_frequisition")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_frequisition")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
