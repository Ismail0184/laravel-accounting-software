@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Coacondition')

@section('contentheader_title', $langs['create_new'] . ' Coacondition')

@section('main-content')
	<?php 
		$acc_id='';
		isset($_GET['acc_id']) &&  $_GET['acc_id']>0 ?
		$acc_id=$_GET['acc_id'] : $acc_id='';
	?>
    {!! Form::open(['route' => 'coacondition.store', 'class' => 'form-horizontal']) !!}
    
    				<div class="form-group">
                        {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('acc_id', $acccoa, $acc_id, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('interval', $langs['interval'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('interval', array(''=> 'Select ...', 1=>'Monthly', 2=> 'Yearly'), null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>					
                   	<div class="form-group">
                        {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('amount', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('osl', $langs['osl'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('osl', array(''=> 'Select ...', 1=>'Yes', 2=> 'No'),null, ['class' => 'form-control',]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('depreciation', $langs['depreciation'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('depreciation', array(''=> 'Select ...', 1=>'Yes', 2=> 'No'),null, ['class' => 'form-control',]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('dep_formula', $langs['dep_formula'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('dep_formula', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('dep_interval', $langs['dep_interval'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('dep_interval', array(''=> 'Select ...', 1=>'Monthly', 2=> 'Yearly'), null, ['class' => 'form-control', ]) !!}
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
