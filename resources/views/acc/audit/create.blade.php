@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Audit')

@section('contentheader_title', $langs['create_new'] . ' Audit')

@section('main-content')
	<?php 
		$audit_action=''; 
		isset($_GET['f']) ? $audit_action=$_GET['f'] : $audit_action=''; ?>
    
    {!! Form::open(['route' => 'audit.store', 'class' => 'form-horizontal audit']) !!}
    
    				<div class="form-group">
                        {!! Form::label('title', $langs['title'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('title', null, ['class' => 'form-control', 'required', 'maxlength'=>100]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('vnumber', $langs['vnumber'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('vnumber', $vnumber, null, ['class' => 'form-control', 'required', 'number']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('note', $langs['note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::textarea('note', null, ['class' => 'form-control', 'required', 'maxlength'=>200]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('sendto', $langs['sendto'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('sendto', $users, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('audit_action', $langs['audit_action'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('audit_action', array( ''=>'select ...', '1'=>'Audit Claim', '2'=>'Explain'), $audit_action, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<!--					<div class="form-group">
                        {!! Form::label('reply_id', $langs['reply_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('reply_id', $users, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('reply_note', $langs['reply_note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('reply_note', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
-->

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
        $(".audit").validate();
    });
        
</script>

@endsection
