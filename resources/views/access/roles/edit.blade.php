@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Roles')

@section('contentheader_title', $langs['edit'] . ' Roles')

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

    {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

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
        {!! Form::text('level', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
        {!! Form::hidden('level', $role->level) !!}
        </div>
    </div>

    <div class="form-group permission">
        <label class="col-sm-3 control-label" for="">{{ $langs['permissions'] }}</label>
        <div class="col-sm-9">
        @foreach($permissions as $permission)
            <?php $checked = in_array($permission->id, $rolePerms->lists('id')); ?>
                @if( !in_array($permission->id, $skip_permissions) )
                <div class="checkbox checkbox-inline">
                    <label>
                        {!! Form::checkbox('perms[]', $permission->id, $checked) !!} {{ $permission->display_name }}
                    </label>
                </div>
                @endif
        @endforeach
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
        {!! Form::submit($langs['update'], ['class' => 'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop