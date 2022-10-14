@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Tranmaster')

@section('contentheader_title', $langs['edit'] . ' Tranmaster')

@section('main-content')
    
    {!! Form::model($tranmaster, ['route' => ['tranmaster.update', $tranmaster->id], 'method' => 'PATCH', 'class' => 'form-horizontal tranmaster']) !!}
<?php 
	Session::has('techeck_id') ?  $techeck_id=Session::get('techeck_id'): $techeck_id=''; //echo $techeck_id.'osama';

?>
					<div class="form-group">
                        {!! Form::label('tdate', $langs['tdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('tdate', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('note', $langs['note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('note', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('sh_id', $langs['sh_id'], ['class' => 'col-sm-3 control-label']) !!}
                         <a href="{{ URL::route('subhead.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::select('sh_id', $sh, null, ['class' => 'form-control select2']) !!}
                        </div>    
                    </div>
                    @if($techeck_id=='0')
                    <div class="form-group">
                        {!! Form::label('check_id', $langs['tcheck_id'], ['class' => 'col-sm-3 control-label']) !!}
                         <a href="{{ URL::route('option.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::select('check_id', $users, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
                    @else
					<div class="form-group">
                        {!! Form::label('techeck_id', $langs['techeck_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('techeck_id', $users, null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
                    @endif
                    <div class="form-group">
                        {!! Form::label('req_id', $langs['req_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <a href="{{ URL::route('acccoa.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::select('req_id', $reqs,null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('person', $langs['person'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('person', null, ['class' => 'form-control',]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('currency_id', $langs['currency_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <a href="{{ URL::route('acc-currency.index') }}"><span class="glyphicon glyphicon-plus"></span></a>
                        <div class="col-sm-6"> 
                            {!! Form::select('currency_id', array('' => 'Select ...', 1 => 'DOLLAR', 2 => 'EURO', 3=>'Taka'), 3, ['class' => 'form-control', 'required']) !!}
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
        $(".tranmaster").validate();
		$( "#tdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
