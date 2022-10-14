@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Lcinfo')
@section('contentheader_title', $langs['edit'] . ' Lcinfo')

@section('main-content')
    
    {!! Form::model($lcinfo, ['route' => ['lcinfo.update', $lcinfo->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}
    				<?php 	 
					Session::has('com_id') ? 
					$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
					$option=DB::table('acc_options')->where('com_id',$com_id)->first();
					$currency_id=''; isset($option) && $option->id > 0 ? $currency_id=$option->currency_id : $currency_id='';

					$cur=DB::table('acc_currencies')->where('id',$currency_id)->first();
					$cur_name=''; isset($cur) && $cur->id > 0 ? $cur_name=$cur->name : $cur_name=''; 
					?>

   		 			<div class="form-group">
                        {!! Form::label('lcnumber', $langs['lcnumber'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('lcnumber', null, ['class' => 'form-control', 'required', 'maxlength' => 60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('lcdate', $langs['lcdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('lcdate', null, ['class' => 'form-control', 'required', 'id' => 'lcdate']) !!}
								<!--{!! Form::text('date', null, array('id' => 'datepicker')) !!} -->                       
                         </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('shipmentdate', $langs['shipmentdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('shipmentdate', null, ['class' => 'form-control', 'required', 'id' => 'shipmentdate']) !!}
								<!--{!! Form::text('date', null, array('id' => 'datepicker')) !!} -->                       
                         </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('expdate', $langs['expdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('expdate', null, ['class' => 'form-control', 'required', 'id' => 'expdate']) !!}
								<!--{!! Form::text('date', null, array('id' => 'datepicker')) !!} -->                       
                         </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('buyer_id', $langs['buyer_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           <!-- {!! Form::text('buyer_id', null, ['class' => 'form-control', 'required']) !!}-->
                            {!! Form::select('buyer_id', $buyers, null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('country_id', $langs['country_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            <!--{!! Form::text('country_id', null, ['class' => 'form-control', 'required']) !!}-->
                            {!! Form::select('country_id', $country, null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('lcamount', $langs['lcamount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('lcamount', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('currency_id', $langs['currency_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('currency_id', $currency, null, ['class' => 'form-control'], 'required') !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('crateto', $langs['crateto'].' '.$cur_name, ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('crateto', null, ['class' => 'form-control','number']) !!}
                        </div>    
                    </div>
<!--                    <div class="form-group">
                        {!! Form::label('unit_id', $langs['unit_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('unit_id', $units, null, ['class' => 'form-control',]) !!}
                        </div>    
                    </div>
-->					<div class="form-group">
                        {!! Form::label('productdetails', $langs['productdetails'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('productdetails', null, ['class' => 'form-control',]) !!}
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

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#lcdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
	 $( "#shipmentdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
	  $( "#expdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
  });
  </script>

@endsection