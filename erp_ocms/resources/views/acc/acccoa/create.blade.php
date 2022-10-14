@extends('app')

@section('contentheader_title', $langs['create_new'] . ' COA')

@section('main-content')

   <?php 
   		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';

   		isset($_GET['g']) ? $groupID=$_GET['g'] : $groupID=''; //echo $groupID;
		isset($_GET['tg']) ? $topGroupID=$_GET['tg'] : $topGroupID=''; //echo $topGroupID;
		isset($_GET['name']) ? $name=$_GET['name'] : $name=''; //echo $topGroupID;
		$sl = DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $groupID)->max('sl')+1; //echo $sl;
		$atype=''; $groupID!='0' ? $atype='Account' : $atype='';
   		isset($_GET['at']) ? $atype=$_GET['at'] : ''; //echo $groupID;
   ?>
    {!! Form::open(['route' => 'acccoa.store', 'class' => 'form-horizontal']) !!}
    
    				
                    <div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', $name, ['class' => 'form-control']) !!}
                        </div>    
                    </div><div class="form-group">
                        {!! Form::label('group_id', $langs['group_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('group_id', null, ['class' => 'form-control']) !!}-->
                            {!! Form::select('group_id',  $group, $groupID, ['class' => 'form-control select2']) !!}
                        </div>    
                    </div><div class="form-group">
                        {!! Form::label('topGroup_id', $langs['topGroup_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('topGroup_id', null, ['class' => 'form-control']) !!}-->
                            {!! Form::select('topGroup_id', $topGroup, $topGroupID, ['class' => 'form-control']) !!}
                        </div>    
					</div><div class="form-group">
                        {!! Form::label('atype', $langs['atype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('topGroup_id', null, ['class' => 'form-control']) !!}-->
                            {!! Form::select('atype', array('Group'=>'Group','Account'=>'Account Head'), $atype, ['class' => 'form-control']) !!}
                        </div>                      
                    </div><div class="form-group">
                        {!! Form::label('sl', $langs['sl'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('sl', $sl, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
                    <!--<div class="form-group">
                        {!! Form::label('user_id', $langs['user_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           {!! Form::text('user_id', Auth::user()->id, ['class' => 'form-control']) !!}
                        </div>    
                    </div>-->
                    {!! Form::hidden('user_id', Auth::user()->id) !!}
                    {!! Form::hidden('detail_id', 0) !!}
                    {!! Form::hidden('cond_id', 0) !!}
                    <!--<div class="form-group">
                        {!! Form::label('detail_id', $langs['detail_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('detail_id', null, ['class' => 'form-control']) !!}
                        </div>    
                    </div><div class="form-group">
                        {!! Form::label('cond_id', $langs['cond_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('cond_id', null, ['class' => 'form-control']) !!}
                            <!--{!! Form::select('cond_id', ['Under 18', '19 to 30', 'Over 30'],null,['class' => 'form-control']) !!}
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
