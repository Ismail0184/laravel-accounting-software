@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Salary')

@section('contentheader_title', $langs['create_new'] . ' Salary')

@section('main-content')
	<?php 
		isset($_GET['emp_id']) ? $emp_id=$_GET['emp_id'] :  $emp_id=''; 
		isset($_GET['m_id']) ? $m_id=$_GET['m_id'] :  $m_id=''; 
		isset($_GET['year']) ? $year=$_GET['year'] :  $year=''; 
		
	?>
    {!! Form::open(['route' => 'salary.store', 'class' => 'form-horizontal salary']) !!}
    
    				<div class="form-group">
                        {!! Form::label('emp_id', $langs['emp_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('emp_id', $employees, $emp_id, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('otime', $langs['otime'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('otime', null, ['class' => 'form-control', 'required']) !!}
                            {!! Form::hidden('m_id', $m_id, ['class' => 'form-control', 'required']) !!}
                            {!! Form::hidden('year', $year, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('hday', $langs['hday'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('hday', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('wday', $langs['wday'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('wday', null, ['class' => 'form-control', 'required']) !!}
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
        $(".salary").validate();
    });
        
</script>

@endsection
