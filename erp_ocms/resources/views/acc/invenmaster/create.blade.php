@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Invenmaster')

@section('contentheader_title', $langs['create_new'] . ' Invenmaster')

@section('main-content')
	<?php 
	Session::has('com_id') ? 
	$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

	isset($_GET['f']) ? $ttype=$_GET['f'] : $ttype='';
	$option=DB::table('acc_options')->where('com_id',$com_id)->first();
	$icheck_id=''; isset($option) && $option->id > 0 ? $icheck_id=$option->icheck_id : $icheck_id='';
	$cwh_id=''; isset($option) && $option->id > 0 ? $cwh_id=$option->cwh_id : $cwh_id='';
	
	$vnumber = DB::table('acc_invenmasters')->where('com_id',$com_id)->max('vnumber')+1;  $max_id = DB::table('acc_invenmasters')->where('com_id',$com_id)->max('id')+1; ?>

    {!! Form::open(['route' => 'invenmaster.store', 'class' => 'form-horizontal invenmaster']) !!}
    
    				<div class="form-group">
                        {!! Form::label('vnumber', $langs['vnumber'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('vnumber', $vnumber,  ['class' => 'form-control', 'required', 'number']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('idate', $langs['idate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('idate', date('Y-m-d') , ['class' => 'form-control', 'required', 'date']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('client_id', $langs['client_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('client_id', $client ,null, ['class' => 'form-control select2']) !!}
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
                        {!! Form::label('itype', $langs['itype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('itype',array('' => 'select ...', 'Receive' => 'Receive', 'Issue' => 'Issue', 'Opening' => 'Opening') ,$ttype, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('person', $langs['person'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('person', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
<!--
					<div class="form-group">
                        {!! Form::label('wh_id', $langs['wh_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('wh_id', $warehouses ,$cwh_id, ['class' => 'form-control', 'required', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('req_id', $langs['req_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('req_id', $prequisitions,null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
-->					<div class="form-group">
                        {!! Form::label('check_id', $langs['check_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('check_id',$users, $icheck_id, ['class' => 'form-control', 'required']) !!}
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

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".invenmaster").validate();
		$( "#idate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();

    });
        
</script>

@endsection
