@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Employee basic info')

@section('contentheader_title', $langs['edit'] . ' Employee basic info')

@section('main-content')
    
    {!! Form::model($employee_basic_info, ['route' => ['employee-basic-info.update', $employee_basic_info->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

    <div class="form-group">
        {!! Form::label('fullname', $langs['fullname'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('fullname', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('father_name', $langs['father_name'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('father_name', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('mother_name', $langs['mother_name'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('mother_name', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('husband_name', $langs['husband_name'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('husband_name', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('no_of_child', $langs['no_of_child'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('no_of_child', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('dob', $langs['dob'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('dob', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('nid', $langs['nid'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('nid', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('bcn', $langs['bcn'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('bcn', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('nationality', $langs['nationality'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('nationality', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('passport', $langs['passport'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('passport', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('sex', $langs['sex'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('sex', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('marital_status', $langs['marital_status'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('marital_status', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>

    
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit($langs['update'], ['class' => 'btn btn-primary form-control']) !!}
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
