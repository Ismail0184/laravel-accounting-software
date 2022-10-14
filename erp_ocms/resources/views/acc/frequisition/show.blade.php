@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Fund Requisitions')

@section('contentheader_title', 'Check/Approve Fund Requisitions')

@section('main-content')
    
    
    <?php 
		$preq = DB::table('prequisitions')->where('id', $frequisition->name)->first();
	?>
    
	<?php $disabled=''; $frequisition->check_action==1 && $frequisition->appr_id==Auth::user()->id ? $disabled='disabled' : $disabled='';?>
    {!! Form::model($frequisition, ['route' => ['frequisition.update', $frequisition->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}
                	@if($disabled=='disabled')
                        <div class="form-group">
                                    {!! Form::label('appr_action', $langs['appr_action'], ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-6"> 
                                        {!! Form::select('appr_action', array('1' => 'Approved', '2' => 'Reject'), null, ['class' => 'form-control']) !!}
                                    </div>    
                                </div>	
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                {!! Form::submit($langs['approve'], ['class' => 'btn btn-success form-control']) !!}
                            </div>
                        </div>
                    @endif
    				<fieldset disabled style="border-radius: 5px; padding: 5px; min-height:150px; border:2px solid #1f497d; background-color:#eeece1;">
             			<legend style=" margin-left:20px;background-color:#1f497d; padding-left:10px; padding-top:5px; padding-right:120px; padding-bottom:5px; ; color:white; border-radius:15px; border:8px solid #eeece1; font-size:16px;">Input Section:</legend>
    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}-->
                             {!! Form::select('name', $prequisitions, null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('description', $langs['description'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}-->
                             <?php echo $preq->description.', Purchase Requisition Amount: '. $preq->amount?>
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('ramount', $langs['ramount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ramount', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('check_id', $langs['check_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           <!-- {!! Form::text('check_id', null, ['class' => 'form-control', 'required']) !!}-->
                            {!! Form::select('check_id', $users, null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
                    </fieldset>
					 <fieldset <?php echo $disabled; ?> style="border-radius: 5px; padding: 5px; min-height:150px; border:2px solid #1f497d; background-color:#eeece1;">
             			<legend style=" margin-left:20px;background-color:#1f497d; padding-left:10px; padding-top:5px; padding-right:120px; padding-bottom:5px; ; color:white; border-radius:15px; border:8px solid #eeece1; font-size:16px;">Check Section:</legend>
                    <div class="form-group">
                        {!! Form::label('check_action', $langs['check_action'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('check_action', null, ['class' => 'form-control', 'required']) !!}-->
                        	{!! Form::select('check_action', array('1' => 'Check', '2' => 'Reject', '3' => 'Later'), null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('check_note', $langs['check_note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('check_note', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('appr_id', $langs['appr_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!-- {!! Form::text('check_id', null, ['class' => 'form-control', 'required']) !!}-->
                            {!! Form::select('appr_id', array_merge(['0' => 'who will approve?'],$users), null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit($langs['check'], ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    </fieldset>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@endsection
