@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Budget')

@section('contentheader_title', $langs['edit'] . ' Budget')

@section('main-content')
    {!! Form::model($budget, ['route' => ['budget.update', $budget->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('name', array(''=>'Select ...','Revenue Budget'=>'Revenue Budget','Capital Budget'=>'Capital Budget','Cash Flow Budget'=>'Cash Flow Budget','Special Budget'=>'Special Budget'), null, ['class' => 'form-control', 'required','maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('btype', $langs['btype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('btype',array(''=>'Select ...', 'Monthly'=>'Monthly', 'Yearly'=>'Yearly', 'Quarterly'=>'Quarterly'), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('byear', $langs['byear'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('byear', null, ['class' => 'form-control', 'required','number']) !!}
                        </div>    
                    </div>					
					<div class="form-group">
                        {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('acc_id', $accounts, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('amount', null, ['class' => 'form-control', 'required', 'number']) !!}
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
