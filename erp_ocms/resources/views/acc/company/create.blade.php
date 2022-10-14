@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Company')

@section('contentheader_title', $langs['create_new'] . ' Company')

@section('main-content')

    {!! Form::open(['route' => 'company.store', 'class' => 'form-horizontal company']) !!}
    
    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength'=>100]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('oaddress', $langs['oaddress'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('oaddress', null, ['class' => 'form-control', 'required', 'maxlength'=>255]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('faddress2', $langs['faddress2'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('faddress2', null, ['class' => 'form-control', 'maxlength'=>255]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('mobile', $langs['mobile'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('mobile', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('phone', $langs['phone'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('phone', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('fax', $langs['fax'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('fax', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('email', $langs['email'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('email', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('web', $langs['web'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('web', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('stablish', $langs['stablish'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('stablish', null, ['class' => 'form-control', 'date']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('businessn', $langs['businessn'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('businessn', null, ['class' => 'form-control', 'maxlength'=>255]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('md', $langs['md'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('md', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('chair', $langs['chair'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('chair', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('d1', $langs['d1'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('d1', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('d2', $langs['d2'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('d2', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('d3', $langs['d3'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('d3', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('ctype', $langs['ctype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('ctype', array(''=>'Select', '0'=>'Sample', '1'=>'Original'),null, ['class' => 'form-control', 'required']) !!}
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
        $(".company").validate();
		$( "#stablish" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
