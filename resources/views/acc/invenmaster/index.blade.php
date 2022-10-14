@extends('app')

@section('htmlheader_title', 'Invenmasters')

@section('contentheader_title', 'Inventory')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/invenmaster/invenhelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_invenmaster'))
            <a href="{{ URL::route('invenmaster.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Inventory</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="invenmaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['vnumber'] }}</th>
                        <th>{{ $langs['itype'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th>{{ $langs['note'] }}</th>
                        @if (Entrust::can('update_invenmaster'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_invenmaster'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                <?php $itype=array('' => 'select ...', 'Receive' => 'Receive', 'Issue' => 'Issue', 'Opening' => 'Opening'); ?>
                {{-- */$x=0;/* --}}
                @foreach($invenmasters as $item)
                <?php 
					$trans=DB::table('acc_invendetails')->where('com_id',$com_id)->where('im_id',$item->id)->first();
					$disabled=''; isset($trans) && $trans->id > 0 ? $disabled="disabled" : $disabled='';

					$wh=DB::table('acc_warehouses')->where('com_id',$com_id)->where('id',$item->wh_id)->first();
					$wh_name=''; isset($wh) && $wh->id> 0 ? $wh_name=$wh->name : $wh_name='';

					$cleint_name='';
					strlen($item->client)>0 ? $cleint_name=$item->client : 
					$cleint=DB::table('acc_clients')->where('com_id',$com_id)->where('id',$item->client_id)->first();
					isset($cleint) && $cleint->id> 0 ? $cleint_name=$cleint->name : $cleint_name='';
					
					$item->check_action==1 ? $edit_disabled='disabled' : $edit_disabled='';
				?>
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>
                        @if($edit_disabled == '' )
                        	<a href="{{ url('/invenmaster', $item->id) }}">{{ $item->idate }}/VNo: {{ $item->vnumber }}</a>
                        @else
                        	{{ $item->idate }}/VNo: {{ $item->vnumber }} 
                        @endif
                        </td>
                        <td>{{ isset($itype[$item->itype]) ? $itype[$item->itype] : '' }}</td>
                        <td>{{ $cleint_name }}</td>
                        <td>{{ $item->note }}</td>
                        @if (Entrust::can('update_invenmaster'))
                        <td width="80">
                        	<a class="btn btn-edit btn-block {{ $edit_disabled }}" title="{{ $langs['edit'] }}" href="{{ URL::route('invenmaster.edit', $item->id) }}"><i class="fa fa-edit"></i></a>
                        </td> 
                        @endif
                        @if (Entrust::can('delete_invenmaster'))
                        <td width="80">{!! Form::open(['route' => ['invenmaster.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa',$disabled, 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#invenmaster-table").dataTable({
    		"aoColumns": [ null, null, null, null, null<?php if (Entrust::can("update_invenmaster")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_invenmaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
