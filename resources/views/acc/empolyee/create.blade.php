@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Empolyee')

@section('contentheader_title', $langs['create_new'] . ' Employee')

@section('main-content')
	<?php 
 				Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
               $sl = DB::table('acc_empolyees')->where('com_id',$com_id)->max('sl')+1;  
    ?>

    {!! Form::open(['route' => 'empolyee.store', 'class' => 'form-horizontal empolyee']) !!}
    
    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('designation_id', $langs['designation_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <a href="{{ URL::route('desigtn.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::select('designation_id', $designations, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('jdate', $langs['jdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('jdate', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('gsalary', $langs['gsalary'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('gsalary', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('bsalary', $langs['bsalary'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('bsalary', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('hrent', $langs['hrent'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('hrent', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('tran', $langs['tran'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('tran', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('enter', $langs['enter'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('enter', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('mexp', $langs['mexp'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('mexp', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('lunch', $langs['lunch'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('lunch', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('mobile', $langs['mobile'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('mobile', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('sallow', $langs['sallow'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('sallow', null, ['class' => 'form-control',]) !!}
                        </div>    
                    </div>

					<div class="form-group">
                        {!! Form::label('department_id', $langs['department_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <a href="{{ URL::route('department.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::select('department_id', $departments, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('sh_id', $langs['sh_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <a href="{{ URL::route('subhead.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::select('sh_id', $subheads, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('sl', $langs['sl'], ['class' => 'col-sm-3 control-label']) !!}
                        <a href="{{ URL::route('subhead.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::text('sl',  $sl, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('active', $langs['active'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('active', array('0'=>'Active','1'=>'Inactive'), null, ['class' => 'form-control', 'required']) !!}
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
        $(".empolyee").validate();
		$( "#jdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();

		  $(function () {
			  $("#gsalary").bind('input', function() {
				$("#bsalary").val(($("#gsalary").val())*55/100);
				$("#hrent").val($("#bsalary").val()*54.55/100);
				$("#tran").val($("#bsalary").val()*12.73/100);
				$("#enter").val($("#bsalary").val()*5.46/100);
				$("#mexp").val($("#bsalary").val()*9.09/100);
			  //alert("letter entered");
			  });
		   });

    });
        
</script>

@endsection
