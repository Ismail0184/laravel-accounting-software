@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Trandetail')

@section('contentheader_title', $langs['edit'] . ' Trandetail')

@section('main-content')
    
    {!! Form::model($trandetail, ['route' => ['trandetail.update', $trandetail->id], 'method' => 'PATCH', 'class' => 'form-horizontal trandetail']) !!}
		<?php 	
		$months=array(''=>'Select ...', 1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');
		
			Session::has('techeck_id') ?  $techeck_id=Session::get('techeck_id'): $techeck_id=''; //echo $techeck_id.'osama';

		?>
    				<div class="form-group">
                        {!! Form::label('tm_id', $langs['tm_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('tm_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           {!! Form::select('acc_id', $acccoa, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>           
					<div class="form-group">
                        {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('amount', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('m_id', $langs['m_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('m_id', $months,null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('c_number', $langs['c_number'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('c_number', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('b_name', $langs['b_name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('b_name', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('c_date', $langs['c_date'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('c_date', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('ilc_id', $langs['ilc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('ilc_id', $ilcs ,null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('lc_id', $langs['lc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('lc_id', $lcinfos ,null, ['class' => 'form-control','id'=>'lc_id']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('ord_id', $langs['ord_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('ord_id', $orders, null, ['class' => 'form-control', 'id' => 'ord_id']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('stl_id', $langs['stl_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('stl_id', $styles,null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('sh_id', $langs['sh_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('sh_id',$subheads,null, ['class' => 'form-control select2', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('dep_id', $langs['dep_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('dep_id',$departments,null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('pro_id', $langs['pro_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('pro_id',$projects,null, ['class' => 'form-control', 'id'=>'pro_id']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('seg_id', $langs['seg_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('seg_id',$pplannings,null, ['class' => 'form-control','id'=>'seg_id' ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('prod_id', $langs['prod_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('prod_id',$products,null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('sis_id', $langs['sis_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('sis_id',$coms,null, ['class' => 'form-control', 'id'=>'sis_id']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('sis_accid', $langs['sis_accid'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('sis_accid',$projects,null, ['class' => 'form-control select2','id'=>'sis_accid' ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('mdeduction', $langs['mdeduction'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('mdeduction',null, ['class' => 'form-control','id'=>'sis_accid' ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('year', $langs['year'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('year',null, ['class' => 'form-control','id'=>'sis_accid' ]) !!}
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
        $(".trandetail").validate();
		$( "#c_date" ).datepicker({ dateFormat: "yy-mm-dd" }).val();

			$("#sis_id").change(function() {
            	$.getJSON("{{ url('tranmaster/sis_acc')}}/" + $("#sis_id").val(), function(data) {
                var $courts = $("#sis_accid");
                $courts.empty();
                $.each(data, function(index, value) {
                    $courts.append('<option value="' + index +'">' + value + '</option>');
                });
            $("#sis_accid").trigger("change");
            });
        });
			
		$("#pro_id").change(function() {
            $.getJSON("{{ url('pbudget/segment')}}/" + $("#pro_id").val(), function(data) {
                var $courts = $("#seg_id");
                $courts.empty();
                $.each(data, function(index, value) {
                    $courts.append('<option value="' + index +'">' + value + '</option>');
                });
            $("#seg_id").trigger("change");
            });
        });
		 $("#lc_id").change(function() { 
            $.getJSON("{{ url('tranmaster/order')}}/" + $("#lc_id").val(), function(data) {
                var $courts = $("#ord_id");
                $courts.empty();
                $.each(data, function(index, value) {
                    $courts.append('<option value="' + index +'">' + value + '</option>');
                });
            $("#ord_id").trigger("change");
            });
        });

		

    });
        
</script>

@endsection
