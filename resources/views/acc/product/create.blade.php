@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Product')

@section('contentheader_title', $langs['create_new'] . ' Product')

@section('main-content')
	<?php 
   		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

		 empty($group) ? $group[0]='Null Group' : '';
		 empty($topGroup) ? $topGroup[0]='Null topGroup' : '' ;

   		isset($_GET['g']) ? $groupID=$_GET['g'] : $groupID=''; //echo $groupID;
		isset($_GET['tg']) ? $topGroupID=$_GET['tg'] : $topGroupID=''; //echo $topGroupID;
		$sl = DB::table('acc_products')->where('com_id',$com_id)->where('group_id', $groupID)->max('sl')+1; //echo $sl;
		$ptype=''; $topGroupID!='0' ? $ptype='Product' : $ptype='Group';
		$unit_id=''; $topGroupID=='' || $topGroupID=='0' ? $unit_id=5 : $unit_id='3';
		
		//echo $topGroupID;
   ?>

    {!! Form::open(['route' => 'product.store', 'class' => 'form-horizontal']) !!}
    
    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required','maxlength' => 60]) !!}
                        </div>    
                    </div>	 
    				<div class="form-group">
                        {!! Form::label('note', $langs['note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('note', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
                        </div>    
                    </div>	 
					<div class="form-group">
                        {!! Form::label('group_id', $langs['group_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('group_id',$group, $groupID, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('topGroup_id', $langs['topGroup_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('topGroup_id', $topGroup, $topGroupID, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('ptype', $langs['ptype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('ptype', array(''=>'Select ...','Group'=>'Group', 'Product'=>'Product Name', 'Top Group'=>'Top Group'), $ptype, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>

                    <div class="form-group">
                        {!! Form::label('unit_id', $langs['unit_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('unit_id', $units, $unit_id, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('price', $langs['price'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('price', 0, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('sl', $langs['sl'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('sl', $sl, ['class' => 'form-control', 'required','number']) !!}
                        </div>    
                    </div>
					<!--<div class="form-group">
                        {!! Form::label('detail_id', $langs['detail_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('detail_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('cond_id', $langs['cond_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('cond_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>-->


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
