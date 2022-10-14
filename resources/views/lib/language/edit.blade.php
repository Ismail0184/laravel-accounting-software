@extends('app')

@section('htmlheader_title', 'Edit Language')

@section('contentheader_title', 'Edit Language')

@section('main-content')

    {!! Form::model($language, ['method' => 'PATCH', 'route' => ['language.update', $language->id], 'class' => 'form-horizontal']) !!}

    <div class="form-group">
        {!! Form::label('code', 'Code: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    
    <div class="form-group">
        {!! Form::label('value', 'Value: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('value', null, ['class' => 'form-control', 'required']) !!}
        </div>    
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
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
