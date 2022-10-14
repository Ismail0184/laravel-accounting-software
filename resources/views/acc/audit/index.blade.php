@extends('app')

@section('htmlheader_title', 'Audits')

@section('contentheader_title', 'Audits')

@section('main-content')
	<style>
    	#ttile { width:200px}
		#vn { width:300px}
		#user { width:100px}
		#action { width:100px}
    </style>
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
	?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/audit/audithelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_audit'))
            <a href="{{ URL::route('audit.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Audit</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="audit-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th id="title">{{ $langs['title'] }}</th>
                        <th id="vn">{{ $langs['vnumber'] }}</th>
                        <th id="note">{{ $langs['note'] }}</th>
                        <th id="user">{{ $langs['sendto'] }}</th>
                        <th id="action">{{ $langs['audit_action'] }}</th>
                        @if (Entrust::can('update_audit'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_audit'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                <?php $audit_action=array( ''=>'select ...', '1'=>'Audit Claim', '2'=>'Explain'); ?>
                {{-- */$x=0;/* --}}
                @foreach($audits as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->title }}</td>
                        <?php  
							$notes=''; $tmamount='';
							$note=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('id', $item->vnumber)->first(); 
							if (isset($note) && $note->id > 0 ):
								$notes=$note->note;
								$tmamount=$note->tmamount;
							endif;
						?>
                        <td>{{ 'Voucher No:'.$item->vnumber }}<br>{{ 'Note: '.$notes }} <br /> {{ 'Amount:' .$tmamount }} </td>
                        <td>{{ $item->note}}</td>
                        <td>{{ $users[$item->sendto] }}</td>
                        <td>{{ $audit_action[$item->audit_action] }}</td>
                        @if (Entrust::can('update_audit'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('audit.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_audit'))
                        <td width="80">{!! Form::open(['route' => ['audit.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#audit-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null<?php if (Entrust::can("update_audit")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_audit")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
