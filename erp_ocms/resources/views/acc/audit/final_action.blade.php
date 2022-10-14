@extends('app')

@section('htmlheader_title', 'Audits')

@section('contentheader_title', 'Audit Notice')

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
                        <th id="">Audit Reply</th>
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
                        <td>{{ 'Voucher No:'.$item->vnumber }}<br>{{ 'Note: '.$notes}} <br /> {{ 'Amount:' .$tmamount }} </td>
                        <td>{{ $item->note}}</td>
                        <td>{{ $users[$item->sendto] }}</td>
                        <td>{{ $audit_action[$item->audit_action] }}</td>
                        <td width="80">{!! Form::open(['route' => ['audit.update', $item->id], 'method' => 'PATCH']) !!}
                        	{!! Form::hidden('flag', 'fa' ,null, ['class' => 'form-control']) !!}
                            {!! Form::submit('Found Correct', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#audit-table").dataTable({
    		"aoColumns": [ null, null, null, null, null<?php if (Entrust::can("update_audit")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_audit")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
