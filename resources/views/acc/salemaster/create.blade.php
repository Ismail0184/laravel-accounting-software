@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Salemaster')

@section('contentheader_title', $langs['create_new'] . ' Salemaster')

@section('main-content')

    {!! Form::open(['route' => 'salemaster.store', 'class' => 'form-horizontal']) !!}
     				<?php  
						Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
						Session::has('sdate') ? $sdate=Session::get('sdate') : $sdate=date('Y-m-d') ;

						Session::has('olt_id') ? 
						$olt_id=Session::get('olt_id') : $olt_id='' ;
						$option=DB::table('acc_options')->where('com_id',$com_id)->first();
						$option_scheck_id=''; isset($option) && $option->id > 0 ? $option_scheck_id=$option->scheck_id : $option_scheck_id='';
						$option_outlet=''; isset($option) && $option->id > 0 ? $option_outlet=$option->olb : $option_outlet='';
						$option_cwh=''; isset($option) && $option->id > 0 ? $option_cwh=$option->cwh_id : $option_cwh='';
						$max_id = DB::table('acc_salemasters')->where('com_id',$com_id)->max('id')+1; 	
						$max_invoice = DB::table('acc_salemasters')->where('com_id',$com_id)->max('invoice')+1;  
						?>
    				<div class="form-group">
                        {!! Form::label('invoice', $langs['invoice'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('invoice', $max_invoice, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('sdate', $langs['sdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('sdate', $sdate, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('client_id', $langs['client_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('client_id', $client, null, ['class' => 'form-control select2',]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('client', $langs['client'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           {!! Form::text('client', null, ['class' => 'form-control client', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('client_address', $langs['client_address'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           {!! Form::text('client_address', null, ['class' => 'form-control address', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('mt_id', $langs['mt_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('mt_id', $mteams ,null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('wh_id', $langs['wh_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('wh_id', $whs ,$option_cwh, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('check_id', $langs['check_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('check_id', $users, $option_scheck_id, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
                    @if($option_outlet==1)
                        <div class="form-group">
                            {!! Form::label('outlet_id', $langs['outlet_id'], ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6"> 
                                {!! Form::select('outlet_id', $outlets, $olt_id, ['class' => 'form-control', 'readonly']) !!}
                            </div>    
                        </div>
                    @endif
                        <!--Company information-->
					<!--<div class="form-group">
                        {!! Form::label('vat_tax', $langs['vat_tax'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('vat_tax', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('pre_due', $langs['pre_due'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('pre_due', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('paid', $langs['paid'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('paid', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('balance', $langs['balance'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('balance', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
-->

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
		    $( "#sdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();

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
