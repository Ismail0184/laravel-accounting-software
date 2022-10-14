@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Govt. Salary')

@section('contentheader_title', $langs['create_new'] . ' Govt. Salary')

@section('main-content')

    {!! Form::open(['route' => 'govt-salary.store', 'class' => 'form-horizontal']) !!}
    
    <div class="form-group">
        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    <div class="form-group">
        {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('amount', null, ['class' => 'form-control', 'required']) !!}
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
