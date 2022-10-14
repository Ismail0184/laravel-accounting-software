@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Purchase Requisition')

@section('contentheader_title', $langs['create_new'] . ' Requisition')

@section('main-content')

    {!! Form::open(['route' => 'prequisition.store', 'class' => 'form-horizontal']) !!}
    			<?php 		
					Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
					$option=DB::table('acc_options')->where('com_id',$com_id)->first();
					$check_id=''; isset($option) && $option->id > 0 ? $check_id=$option->rcheck_id : $check_id='';
					$cur_id=''; isset($option) && $option->id > 0 ? $cur_id=$option->currency_id : $cur_id='';
				?>
    				<div class="form-group">
                        {!! Form::label('name', $langs['title'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required','maxlength'=>100]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('description', $langs['cor'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'required','maxlength'=>255]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('ramount', $langs['ramount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ramount', null, ['class' => 'form-control', 'required', 'number']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('currency_id', $langs['currency_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('currency_id', $currency, $cur_id, ['class' => 'form-control', 'required', 'number']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('acc_id', $acccoa, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('rtypes', $langs['rtypes'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('rtypes', array(''=>'Select ...', 'n' => 'Normal', 'u' => 'Urgent', 'tu' => 'Top Urgent'), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('check_id', $langs['check_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('check_id', $users, $check_id, ['class' => 'form-control', 'required']) !!}
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

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".form-horizontal").validate();
    });
        
</script>

@endsection