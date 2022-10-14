@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Style')

@section('contentheader_title', $langs['create_new'] . ' Style')

@section('main-content')

    {!! Form::open(['route' => 'style.store', 'class' => 'form-horizontal']) !!}
    
    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('ordernumber', $langs['ordernumber'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('ordernumber', $orders,null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('stylevalue', $langs['stylevalue'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('stylevalue', null, ['class' => 'form-control', 'required', 'number']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('styleqty', $langs['styleqty'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('styleqty', null, ['class' => 'form-control', 'required', 'number']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('unit_id', $langs['unit_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('unit_id',array('' => 'Select ...', '1' => 'PCS', '2' => 'Dozen'), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('description', $langs['description'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('description', null, ['class' => 'form-control', ]) !!}
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
