@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Orderinfo')

@section('contentheader_title', $langs['create_new'] . ' Orderinfo')

@section('main-content')

    {!! Form::open(['route' => 'orderinfo.store', 'class' => 'form-horizontal']) !!}
    
    				<div class="form-group">
                        {!! Form::label('lcnumber', $langs['lcnumber'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('lcnumber', $lcs, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('ordernumber', $langs['ordernumber'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ordernumber', null, ['class' => 'form-control', 'required', 'maxlength' => 60]) !!}
                        </div>    
                    </div>					
                    <div class="form-group">
                        {!! Form::label('ordervalue', $langs['ordervalue'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ordervalue', null, ['class' => 'form-control', 'required', 'number']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('orderqty', $langs['orderqty'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('orderqty', null, ['class' => 'form-control', 'required', 'number']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('unit_id', $langs['unit_id'], ['class' => 'col-sm-3 control-label']) !!}
 						<a href="{{ URL::route('acc-unit.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::select('unit_id', $units, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('productdetails', $langs['productdetails'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('productdetails', null, ['class' => 'form-control', ]) !!}
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
