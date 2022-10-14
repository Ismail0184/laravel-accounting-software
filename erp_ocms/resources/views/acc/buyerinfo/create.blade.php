@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Buyer')

@section('contentheader_title', $langs['create_new'] . ' Buyer')

@section('main-content')
<?php 
/*Mail::send('emails.welcome', ['key' => 'value'], function($message)
{
    $data = array(
        'name' => "Learning Laravel",
    );

    Mail::send('emails.welcome', $data, function ($message) {

        $message->from('hasanhabib2009@gmail.com', 'Learning Laravel');

        $message->to('hasan@ocmsbd.com')->subject('Learning Laravel test email');

    });
});*/

?>
    {!! Form::open(['route' => 'buyerinfo.store', 'class' => 'form-horizontal']) !!}
					<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 100,]) !!}
                        </div>    
                    </div>					
                    <div class="form-group">
                        {!! Form::label('contact', $langs['contact'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('contact', null, ['class' => 'form-control', 'required', 'maxlength' => 100]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('address', $langs['address'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('address', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('country_id', $langs['country_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                             {!! Form::select('country_id', $country, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('email', $langs['email'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('email', null, ['class' => 'form-control', 'required', 'maxlength' => 60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('phone', $langs['phone'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('phone', null, ['class' => 'form-control', 'maxlength' => 40]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('skype', $langs['skype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('skype', null, ['class' => 'form-control', 'maxlength' => 40,]) !!}
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

<script>
  jQuery(document).ready(function($) {        
       // $(".form-horizontal").validate();

    });
	
  </script>

@endsection