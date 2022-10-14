@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Purchasemaster')

@section('contentheader_title', $langs['edit'] . ' Purchase')

@section('main-content')
    
    {!! Form::model($purchasemaster, ['route' => ['purchasemaster.update', $purchasemaster->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

    				<div class="form-group">
                        {!! Form::label('invoice', $langs['invoice'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('invoice', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('pdate', $langs['pdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('pdate', null, ['class' => 'form-control', 'required']) !!}
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
                            {!! Form::text('client', null, ['class' => 'form-control']) !!}
                            {!! Form::text('client_address', null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('wh_id', $langs['wh_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('wh_id', $whs, null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('note', $langs['note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('note', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('paid', $langs['paid'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('paid', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<!--					<div class="form-group">
                        {!! Form::label('discount', $langs['discount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('discount', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('vat_tax', $langs['vat_tax'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('vat_tax', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('transport', $langs['transport'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('transport', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('previous_due', $langs['previous_due'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('previous_due', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('balance', $langs['balance'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('balance', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
-->					<div class="form-group">
                        {!! Form::label('check_id', $langs['check_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('check_id', $users, null, ['class' => 'form-control', ]) !!}
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

@section('custom-scripts')

<script>
  jQuery(document).ready(function($) {        
        $(".form-horizontal").validate();
		    $( "#pdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();

    });
	
  </script>

@endsection