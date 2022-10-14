@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Pplanning')

@section('contentheader_title', $langs['create_new'] . ' Pplanning')

@section('main-content')
	<?php isset($_GET['p']) ? $pro_id=$_GET['p'] : $pro_id='' ;  isset($_GET['g']) ? $group_id=$_GET['g'] : $group_id='' ;  ?>
    {!! Form::open(['route' => 'pplanning.store', 'class' => 'form-horizontal pplanning']) !!}
    
					<div class="form-group">
                        {!! Form::label('segment', $langs['segment'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('segment', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('stdate', $langs['stdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('stdate', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('cldate', $langs['cldate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('cldate', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('bamount', $langs['bamount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('bamount', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
    				<div class="form-group">
                        {!! Form::label('gtype', $langs['gtype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('gtype', array(''=>'Select ...', 'Group'=>'Group', 'Account'=>'Account Head'), null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
    				<div class="form-group">
                        {!! Form::label('pro_id', $langs['pro_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('pro_id', $projects, $pro_id, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>

					<div class="form-group">
                        {!! Form::label('group_id', $langs['group_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('group_id', $groups, $group_id, ['class' => 'form-control', ]) !!}
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
        $(".pplanning").validate();
		$( "#stdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		$( "#cldate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();


    });
        
</script>

@endsection
