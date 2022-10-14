@extends('app')

@section('htmlheader_title', 'Invenmasters')

@section('contentheader_title', 'Inventory')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		$wh_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="invenmaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['vnumber'] }}</th>
                        <th>{{ $langs['itype'] }}</th>
                        <th>{{ $langs['person'] }}</th>
                        <th>{{ $langs['note'] }}</th>
                        <th>{{ $langs['wh_id'] }}</th>
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
					if ( isset($trans) && $trans->war_id>0):
						$wh=DB::table('acc_warehouses')->where('com_id',$com_id)->where('id',$trans->war_id)->first();
						$wh_name=''; isset($wh) && $wh->id> 0 ? $wh_name=$wh->name : $wh_name='';
					endif;
				?>
                    {{-- */$x++;/* --}}
                    <tr>
                  {!! Form::model($invenmasters, ['url' => ['invenmaster/checked', $item->id], 'method' => 'UPDATE', 'class' => 'form-horizontal tranmaster']) !!}
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/invenmaster/invoice?flag='. $item->id) }}">{{ $item->idate }}/VNo: {{ $item->vnumber }}</a></td>
                        <td>{{ $itype[$item->itype] }}</td>
                        <td>{{ $item->person }}</td>
                        <td>{{ $item->note }}</td>
                        <td>{{ $wh_name }}</td>
                        @if (Entrust::can('delete_invenmaster'))
                        <td width="200px">
                        	{!! Form::text('check_note', 'ok', ['class' => 'form-control', 'required','maxlength'=>200 , 'style'=>'width:200px']) !!}
							{!! Form::select('check_action', array(''=>'Select ...', '1' => 'Check', '2' => 'Reject', '3' => 'Later'), null, ['class' => 'form-control' , 'required', 'style'=>'width:200px']) !!}                            
                            {!! Form::submit($langs['check'], ['class' => 'btn btn-primary btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                        @endif
                  {!!  Form::close() !!}</td>
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
