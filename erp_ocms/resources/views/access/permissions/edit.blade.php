@extends('app')

@section('htmlheader_title', $langs['edit_permission'])

@section('contentheader_title', $langs['edit_permission'])

@section('main-content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($permission, ['route' => ['permissions.update', $permission->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

    <div class="form-group">
        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('display_name', $langs['display_name'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
        {!! Form::text('display_name', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('description', $langs['description'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('route', $langs['route'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
        {!! Form::text('route', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
        {!! Form::submit($langs['update'], ['class' => 'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop