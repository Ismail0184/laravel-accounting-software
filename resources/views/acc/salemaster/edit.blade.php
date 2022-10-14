@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Salemaster')

@section('contentheader_title', $langs['edit'] . ' Salemaster')

@section('main-content')
    
    {!! Form::model($salemaster, ['route' => ['salemaster.update', $salemaster->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

    				<div class="form-group">
                        {!! Form::label('invoice', $langs['invoice'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('invoice', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('sdate', $langs['sdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('sdate', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('client_id', $langs['client_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('client_id', $client, null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('client', $langs['client'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           {!! Form::text('client', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('client_address', $langs['client_address'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('client_address', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('mt_id', $langs['mt_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('mt_id', $mteams ,null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('outlet_id', $langs['outlet_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('outlet_id', $outlets,null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
	 				<div class="form-group">
                        {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('amount', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
	 				<div class="form-group">
                        {!! Form::label('currency_id', $langs['currency_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('currency_id', $currency, null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('discount', $langs['discount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('discount', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('vat_tax', $langs['vat_tax'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('vat_tax', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('pre_due', $langs['pre_due'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('pre_due', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('paid', $langs['paid'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('paid', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('balance', $langs['balance'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('balance', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('wh_id', $langs['wh_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('wh_id', $whs ,null, ['class' => 'form-control', ]) !!}
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
@section('custom-scripts')

  <script>
  jQuery(document).ready(function($) {        
		    $( "#sdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
	
  </script>

@endsection

@endsection
