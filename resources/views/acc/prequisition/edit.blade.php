@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Purchase Requisition')

@section('contentheader_title', $langs['edit'] . ' Purchase Requisition')

@section('main-content')
    <?php 
		
	?>
    {!! Form::model($prequisition, ['route' => ['prequisition.update', $prequisition->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required','maxlength'=>100]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('description', $langs['description'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'required','maxlength'=>255]) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('ramount', $langs['ramount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ramount', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('currency_id', $langs['currency_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('currency_id', $currency, null, ['class' => 'form-control', 'required', 'number']) !!}
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
                            {!! Form::select('rtypes', array('n' => 'Normal', 'u' => 'Urgent', 'tu' => 'Top Urgent'), null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('check_id', $langs['check_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('check_id', $users, null, ['class' => 'form-control']) !!}
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

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".form-horizontal").validate();
    });
        
</script>

@endsection