@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Outlet')

@section('contentheader_title', $langs['create_new'] . ' Outlet')

@section('main-content')

    {!! Form::open(['route' => 'outlet.store', 'class' => 'form-horizontal']) !!}
    
    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required','maxlength'=>100]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('emp_id', $langs['emp_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('emp_id', array(''=>'Select ...', '1'=>'Hasan Habib'), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('address', $langs['address'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('address', null, ['class' => 'form-control', 'required','maxlength'=>255]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('mobile', $langs['mobile'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('mobile', null, ['class' => 'form-control', 'required','maxlength'=>40]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('email', $langs['email'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('email', null, ['class' => 'form-control', 'email', 'required','maxlength'=>40]) !!}
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
