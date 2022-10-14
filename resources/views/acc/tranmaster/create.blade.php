@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Tranmaster')

@section('contentheader_title', $langs['create_new'] . ' Transaction')

@section('main-content')
	<?php 
	Session::has('com_id') ? 
	$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
	Session::has('ttdate') ?  $tdate=Session::get('ttdate'): $tdate=date('Y-m-d');
	Session::has('techeck_id') ?  $techeck_id=Session::get('techeck_id'): $techeck_id=''; //echo $techeck_id.'osama';

		isset($_GET['t']) ? $ttype=$_GET['t'] : $ttype=''; //$acc = DB::table('acc_coas')->where('name','Bank and Cash')->first(); echo  $acc->id;
	 $option=DB::table('acc_options')->where('com_id',$com_id)->first();
	 isset($option) && $option->id> 0 ? $tcheck_id=$option->tcheck_id : $tcheck_id='';
	 isset($option) && $option->id> 0 ? $currency_id=$option->currency_id : $currency_id='';
	 
	$vnumber = DB::table('acc_tranmasters')->where('com_id',$com_id)->max('vnumber')+1;  $max_id = DB::table('acc_tranmasters')->max('id')+1; 
	?>
    {!! Form::open(['route' => 'tranmaster.store', 'class' => 'form-horizontal tranmaster']) !!}
    
					<div class="form-group">
                        {!! Form::label('tdate', $langs['tdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('tdate', $tdate, ['class' => 'form-control', 'required']) !!}
                        	{!! Form::hidden('id', $max_id) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('ttype', $langs['ttype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('ttype', array(''=>'Select ...', 'Payment'=>'Payment', 'Receipt'=>'Receipt', 'Journal'=>'Journal', 'Contra'=>'Contra', 'Opening'=>'Opening Balance'), $ttype, ['class' => 'form-control', 'required', 'id'=>'ttype']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('tranwith_id', $langs['tranwith_id'], ['class' => 'col-sm-3 control-label', 'id'=>'lbl']) !!}
                         <a href="{{ URL::route('acccoa.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            @if($ttype=='Journal')
                            {!! Form::select('tranwith_id', $acccoa, null, ['class' => 'form-control', 'required']) !!}
                            @else
                            {!! Form::select('tranwith_id', $coa, null, ['class' => 'form-control select2', 'required']) !!}
                            @endif
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('sh_id', $langs['sh_id'], ['class' => 'col-sm-3 control-label']) !!}
                         <a href="{{ URL::route('subhead.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::select('sh_id', $sh, null, ['class' => 'form-control select2']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('req_id', $langs['req_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <a href="{{ URL::route('prequisition.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::select('req_id', $reqs,null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('person', $langs['person'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('person', null, ['class' => 'form-control', ]) !!}
                            {!! Form::hidden('currency_id', $currency_id, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
                    @if($techeck_id=='0')
                    <div class="form-group">
                        {!! Form::label('check_id', $langs['tcheck_id'], ['class' => 'col-sm-3 control-label']) !!}
                         <a href="{{ URL::route('option.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::select('check_id', $users, $tcheck_id, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
                    @else
					<div class="form-group">
                        {!! Form::label('techeck_id', $langs['techeck_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('techeck_id', $users, $techeck_id, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
                    @endif

					<!--
                       {!! Form::select('currency_id', array('' => 'Select ...', 1 => 'DOLLAR', 2 => 'EURO', 3=>'Taka'),null, ['class' => 'form-control', 'required', 'style' => 'width: 100px;']) !!}

                    <div class="form-group">
                        {!! Form::label('check_action', $langs['check_action'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('check_action', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('check_note', $langs['check_note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('check_note', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('appr_id', $langs['appr_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('appr_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('appr_note', $langs['appr_note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('appr_note', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					
					<div class="form-group">
                        {!! Form::label('com_id', $langs['com_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('com_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('proj_id', $langs['proj_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('proj_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>-->


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit($langs['created'], ['class' => 'btn btn-primary form-control']) !!}
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

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".tranmaster").validate();
		$( "#tdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
    jQuery(document).ready(function($) {        
		 $("#ttype").change(function() {
            $.getJSON("{{ url('tranmaster/bankcash')}}/" + $("#ttype").val(), function(data) {
                var $courts = $("#tranwith_id");
                $courts.empty();
                $.each(data, function(index, value) {
                    $courts.append('<option value="' + index +'">' + value + '</option>');
                });
            $("#tranwith_id").trigger("change");
            });
        });
		
		$('#ttype').change(function(){
			var value = $(this).val();
			if(value=='Payment'){
				$('label#lbl').html('Source of fund: ');
			} else if(value=='Receipt') {
				$('label#lbl').html('Where to Deoposit: ');
			} else {
				$('label#lbl').html('Credit By: ');
				
				}
			//alert(value);
		});
    });

var x = document.getElementById("ttype");
x.addEventListener("change", myFocusFunction, true);

function myFocusFunction() {
    document.getElementById("lbl").text = 'Source of Fund';  
}

</script>

@endsection
