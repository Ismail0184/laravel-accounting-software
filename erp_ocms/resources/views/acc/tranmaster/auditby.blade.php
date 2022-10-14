@extends('app')

@section('contentheader_title', 'Transaction Audit')

@section('main-content')
	<style>
    	 #vn { width:120px; text-align:center }
		#dt, #user { width:100px; text-align:center }
		#nt { width:200px}
		#amt { width:100px; text-align:right }
		#acc_id { width:200px; }
    </style>
    <?php 
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		$option=DB::table('acc_options')->where('com_id',$com_id)->first();
		$option_auditor=''; isset($option) && $option->id > 0 ? $option_auditor=$option->audit_id : $option_auditor='';
		if(Auth::id()!=$option_auditor):
			echo "You are not Auditor !";
			$tranmasters=array();
		else:
			//$tranmasters=DB::table('acc_tranmasters')->where('com_id')->where('appr_action',1)->get();
		endif;
	?>
    <div class="box">
        <div class="box-header">

            
        </div><!-- /.box-header -->
        <div class="box-body">
             <table id="tranmaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th >{{ $langs['sl'] }}</th>
                        <th id="vn">{{ $langs['vnumber'] }}</th>
                        <th id="nt">{{ $langs['note'] }}</th>
                        <th id="acc_id">{{ $langs['sfund'] }}</th>
                        <th id="amt">{{ $langs['amount'] }}</th>
                        <th id="tp">{{ $langs['ttype'] }}</th>
                        <th id="tp">{{ $langs['inputby'] }}</th>
                        @if (Entrust::can('delete_tranmaster'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($tranmasters as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td id="vn"><a href="{{ url('/tranmaster/voucher', $item->id) }}">{{ $item->tdate.'/ VNo: '.$item->vnumber }}</a></td>
                        <td id="nt">{{ $item->note }}</td>
                        <td id="acc_id">{{ $acccoa[$item->tranwith_id] }}</td>
                        <td id="amt">{{ $item->tmamount }}</td>
                        <td id="tp">{{ $item->ttype }}</td>
                        <td id="tp">{{ $users[$item->user_id] }}</td>
                        @if (Entrust::can('delete_tranmaster'))
                        <td width="200px">
                        	{!! Form::model($tranmasters, ['url' => ['tranmaster/audited', $item->id], 'method' => 'UPDATE', 'class' => 'form-horizontal tranmaster']) !!}
                        	{!! Form::text('audit_note', null, ['class' => 'form-control', 'required','maxlength'=>200, 'style'=>'width:200px']) !!}
							{!! Form::select('audit_action', array(''=>'Select ...', '1' => 'Audited', '2' => 'Inquiry'), null, ['class' => 'form-control' , 'required', 'style'=>'width:200px']) !!}                            
                            {!! Form::submit($langs['audit'], ['class' => 'btn btn-primary btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#tranmaster-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, nulll<?php  if (Entrust::can("delete_tranmaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
