@extends('app')

@section('contentheader_title', $langs['edit'] . ' Acccoa')

@section('main-content')
    
    {!! Form::model($acccoa, ['method' => 'PATCH', 'route' => ['acccoa.update', $acccoa->id], 'class' => 'form-horizontal']) !!}
					<?php 
						$value='';
						isset($coadetails) ? $value= $coadetails->id :  $value=''; 
						
					?>
    				    				
                    <div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>    
                    </div><div class="form-group">
                        {!! Form::label('group_id', $langs['group_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('group_id', null, ['class' => 'form-control']) !!}-->
                            {!! Form::select('group_id', $group ,null,['class' => 'form-control select2']) !!}
                        </div>    
                    </div><div class="form-group">
                        {!! Form::label('topGroup_id', $langs['topGroup_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('topGroup_id', null, ['class' => 'form-control']) !!}-->
                            {!! Form::select('topGroup_id',  $topGroup ,null,['class' => 'form-control']) !!}
                        </div>    
                    </div><div class="form-group">
                        {!! Form::label('atype', $langs['atype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('topGroup_id', null, ['class' => 'form-control']) !!}-->
                            {!! Form::select('atype', array('Group'=>'Group','Account'=>'Account Head'), null, ['class' => 'form-control']) !!}
                        </div>  
                    </div><div class="form-group">
                        {!! Form::label('sl', $langs['sl'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('sl', null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
                    <!--<div class="form-group">
                        {!! Form::label('user_id', $langs['user_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           {!! Form::text('user_id', Auth::user()->id, ['class' => 'form-control']) !!}
                        </div>    
                    </div>-->
                    {!! Form::hidden('user_id', Auth::user()->id) !!}
<!--                    <div class="form-group">
                        {!! Form::label('detail_id', $langs['detail_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('detail_id', $value, ['class' => 'form-control']) !!}
                        </div>    
                    </div><div class="form-group">
                        {!! Form::label('cond_id', $langs['cond_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('cond_id', null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
-->
    
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
