@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Setting')

@section('contentheader_title', $langs['create_new'] . ' Setting')

@section('main-content')

    {!! Form::open(['route' => 'setting.store', 'class' => 'form-horizontal setting']) !!}
    
    				<div class="form-group">
                        {!! Form::label('gname', $langs['gname'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('gname', null, ['class' => 'form-control', 'required', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('ccount', $langs['ccount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ccount', null, ['class' => 'form-control', 'required', 'interger', 'max'=>10]) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('onem', $langs['onem'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('onem',array ('' => 'Select ...', 1=>'Accounting'), null, ['class' => 'form-control', 'required', 'interger']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('m1', $langs['m1'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('m1', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('m2', $langs['m2'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('m2', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('m3', $langs['m3'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('m3', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('m4', $langs['m4'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('m4', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('m5', $langs['m5'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('m5', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('m6', $langs['m6'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('m6', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('m7', $langs['m7'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('m7', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('m8', $langs['m8'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('m8', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('m9', $langs['m9'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('m9', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', 'required']) !!}
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
        $(".setting").validate();
    });
        
</script>

@endsection
