@extends('app')

@section('htmlheader_title', $langs['create_role'])

@section('contentheader_title', $langs['create_role'])

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
    
    {!! Form::open(['route' => 'roles.store', 'class' => 'form-horizontal']) !!}

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
        {!! Form::label('level', $langs['level'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
        {!! Form::number('level', null, ['class' => 'form-control', 'min' => '0', 'required']) !!}
        </div>
    </div>

    <div class="form-group permission">
        <label class="col-sm-3 control-label" for="">{{ $langs['permissions'] }}</label>
        <div class="col-sm-9">        
        @foreach($permissions as $permission)
            @if( !in_array($permission->id, $skip_permissions) )
            <div class="checkbox checkbox-inline">
                <label>
                    {!! Form::checkbox('perms[]', $permission->id) !!} {{ $permission->display_name }}
                </label>
            </div>
            @endif
        @endforeach
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
        {!! Form::submit($langs['create'], ['class' => 'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop