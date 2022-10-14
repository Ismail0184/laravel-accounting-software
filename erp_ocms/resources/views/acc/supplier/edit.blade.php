@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Supplier')

@section('contentheader_title', $langs['edit'] . ' Supplier')

@section('main-content')
    
    {!! Form::model($supplier, ['route' => ['supplier.update', $supplier->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength'=>100]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('contact', $langs['contact'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('contact', null, ['class' => 'form-control', 'required', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('address', $langs['address'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('address', null, ['class' => 'form-control', 'required' , 'maxlength'=>255]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('country_id', $langs['country_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('country_id', null, ['class' => 'form-control', 'required']) !!}-->
                             {!! Form::select('country_id', $country, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('email', $langs['email'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('email', null, ['class' => 'form-control', 'maxlength'=>60, 'required', 'email']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('phone', $langs['phone'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('skype', $langs['skype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('skype', null, ['class' => 'form-control']) !!}
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
