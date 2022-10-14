@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Lcimport')

@section('contentheader_title', $langs['create_new'] . ' Lcimport')

@section('main-content')

    {!! Form::open(['route' => 'lcimport.store', 'class' => 'form-horizontal']) !!}
    
    				<div class="form-group">
                        {!! Form::label('lcnumber', $langs['lcnumber'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('lcnumber', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('lcdate', $langs['lcdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('lcdate', null, ['class' => 'form-control', 'required', 'id' => 'lcdate']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('shipmentdate', $langs['shipmentdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('shipmentdate', null, ['class' => 'form-control', 'required', 'id' => 'shipmentdate']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('expdate', $langs['expdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('expdate', null, ['class' => 'form-control', 'required', 'id' => 'expdate']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('supplier_id', $langs['supplier_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('supplier_id', $supplier, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('country_id', $langs['country_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                             {!! Form::select('country_id', $country, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('lcvalue', $langs['lcvalue'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('lcvalue', null, ['class' => 'form-control', 'required', 'number']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('currency_id', $langs['currency_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('currency_id', $currency, null, ['class' => 'form-control', 'required']) !!}
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
@section('custom-scripts')

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#lcdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
	 $( "#shipmentdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
	  $( "#expdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
  });
  </script>

@endsection