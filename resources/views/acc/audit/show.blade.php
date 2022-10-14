@extends('app')

@section('htmlheader_title', 'Audits')

@section('contentheader_title', 'Audits')

@section('main-content')
    <div class="box">
        <div class="box-header">
        </div><!-- /.box-header -->
        <div class="box-body">
            <?php  
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			
			//$note=DB::table('acc_tranmasters')->where('vnumber', $audit->vnumber)->first(); 
			$notes=''; $tmamount='';$vnumber='';
			$note=DB::table('acc_tranmasters')->where('com_id',$com_id)->where('id', $audit->vnumber)->first(); 
			if (isset($note) && $note->id > 0 ):
				$vnumber=$note->vnumber;
				$notes=$note->note;
				$tmamount=$note->tmamount;
			endif;
				
			
			?>
			<?php $audit_action=array( ''=>'select ...', '1'=>'Audit Claim', '2'=>'Explain'); ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" >
                    <tr>
                        <td>{{ $langs['title'] }} : </td><td>{{ $audit->title }}</td>
                    </tr>
                    <tr>
                        <td>{{ $langs['note'] }} :</td> <td>{{ $notes }}</td>
                    </tr>
                    <tr>
                        <td>Transaction Details :</td><td>{{ 'Voucher No:'.$audit->vnumber }}<br>{{ 'Note: '.$notes }} <br /> {{ 'Amount:' .$tmamount }}</td>
                    </tr>
                    <tr>
                        <td>{{ $langs['inputby'] }} : </td><td>{{ $users[$note->user_id] }}</td>
                    </tr>
                    <tr>
                       <td>{{ $langs['check_id'] }} : </td><td>{{ $users[$note->check_id] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $langs['audit_action'] }} : </td><td>{{ $audit_action[$audit->audit_action] }}</td>
                    </tr>
                    <tr>
                        <td>Auditor : </td><td>{{ $users[$audit->user_id] }}</td>
                    </tr>
                </table>
            </div>
                        {!! Form::model($audit, ['route' => ['audit.update', $audit->id], 'method' => 'PATCH', 'class' => 'form-horizontal audit']) !!}
        
                            <div class="form-group">
                                {!! Form::label('reply_note', $langs['reply_note'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                	{!! Form::hidden('flag', 'y' ,null, ['class' => 'form-control', 'required']) !!}
                                    {!! Form::textarea('reply_note', null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>
        
                            
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-3">
                                    {!! Form::submit($langs['reply'], ['class' => 'btn btn-primary form-control']) !!}
                                </div>
                            </div>
                    {!! Form::close() !!}

            
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
