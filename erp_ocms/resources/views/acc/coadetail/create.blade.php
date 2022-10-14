@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Coadetail')

@section('contentheader_title', $langs['create_new'] . ' Coadetail')

@section('main-content')
	<?php 
		$id='';
		isset($_GET['id']) ? $id=$_GET['id'] : $id='';
		
		$acc_id = DB::table('acc_coadetails')->where('acc_id', $id)->first(); //echo $coa_id->id;
		if(isset($acc_id->id)):
		 	echo Redirect::to('coadetail/'.$acc_id->id.'/edit');
		 endif
	?>
    {!! Form::open(['route' => 'coadetail.store', 'class' => 'form-horizontal']) !!}
    
    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('acc_id', $coas ,$id, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('contact', $langs['contact'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('contact', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('address1', $langs['address1'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('address1', null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('address2', $langs['address2'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('address2', null, ['class' => 'form-control' ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('email', $langs['email'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('email', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('phone', $langs['phone'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('phone', null, ['class' => 'form-control' ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('accountGroup', $langs['accountGroup'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('accountGroup_id', $coa_group, null, ['class' => 'form-control' ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('businessN', $langs['businessn'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('businessN', null, ['class' => 'form-control' ]) !!}
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
