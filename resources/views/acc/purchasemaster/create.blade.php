@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Purchasemaster')

@section('contentheader_title', $langs['create_new'] . ' Purchase')

@section('main-content')
 	<?php  
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		$invoice = DB::table('acc_purchasemasters')->where('com_id',$com_id)->max('invoice')+1; 	

		$option=DB::table('acc_options')->where('com_id',$com_id)->first();
		$option_pcheck_id=''; isset($option) && $option->id > 0 ? $option_pcheck_id=$option->pcheck_id : $option_pcheck_id='';
		$option_cwh_id=''; isset($option) && $option->id > 0 ? $option_cwh_id=$option->cwh_id : $option_cwh_id='';
	
		
		?>
    {!! Form::open(['route' => 'purchasemaster.store', 'class' => 'form-horizontal puchase']) !!}
    
    				<div class="form-group">
                        {!! Form::label('invoice', $langs['invoice'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('invoice', $invoice, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('pdate', $langs['pdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('pdate', date('Y-m-d'), ['class' => 'form-control', 'required', 'id' => 'pdate']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('client_id', $langs['client_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('client_id', $client, null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('client', $langs['client'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('client', null, ['class' => 'form-control client']) !!}
                            {!! Form::text('client_address', null, ['class' => 'form-control address']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('wh_id', $langs['wh_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('wh_id', $whs, $option_cwh_id, ['class' => 'form-control', 'required' ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('check_id', $langs['check_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('check_id', $users, $option_pcheck_id, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit($langs['create'], ['class' => 'btn btn-primary form-control']) !!}
        </div>    
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@endsection
@section('custom-scripts')

<script>
  jQuery(document).ready(function($) {        
		    $( "#pdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
        	$(".puchase").validate();
    
			$('#client_id').on('change', function () {
			if ($(this).val() == '') {
				$('.client').prop("disabled", false);
				$('.address').prop("disabled", false);
			} else {
				$('.client').prop("disabled", true);
				$('.address').prop("disabled", true);
			}
		});

	});
	
  </script>

@endsection