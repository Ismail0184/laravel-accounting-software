@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Fund Requisitions')

@section('contentheader_title', $langs['edit'] . ' Fund Requisitions')

@section('main-content')
    
    {!! Form::model($frequisition, ['route' => ['frequisition.update', $frequisition->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

    				<div class="form-group">
                        {!! Form::label('pr_id', $langs['pr_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}-->
                             {!! Form::select('pr_id', $prequisitions, null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('ramount', $langs['ramount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ramount', null, ['class' => 'form-control', 'required','number']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('currency_id', $langs['currency_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('currency_id', $currency, null, ['class' => 'form-control', 'required','number']) !!}
                        </div>    
                    </div>

					<div class="form-group">
                        {!! Form::label('check_id', $langs['check_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           <!-- {!! Form::text('check_id', null, ['class' => 'form-control', 'required']) !!}-->
                            {!! Form::select('check_id', $users, null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<!--
                    <div class="form-group">
                        {!! Form::label('check_action', $langs['check_action'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('check_action', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('check_note', $langs['check_note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('check_note', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<!--<div class="form-group">
                        {!! Form::label('appr_id', $langs['appr_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('appr_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('aamount', $langs['aamount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('aamount', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('appr_action', $langs['appr_action'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('appr_action', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>-->

    
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

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".form-horizontal").validate();
    });
        
</script>

@endsection