@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Fabricdetail')

@section('contentheader_title', $langs['create_new'] . ' Fabricdetail')

@section('main-content')

    {!! Form::open(['route' => 'fabricdetail.store', 'class' => 'form-horizontal fabricdetail']) !!}
    
    <div class="form-group">
                        {!! Form::label('order_id', $langs['order_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('order_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('gtype_id', $langs['gtype_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('gtype_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('pogarment_id', $langs['pogarment_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('pogarment_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('diatype_id', $langs['diatype_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('diatype_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('dia_id', $langs['dia_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('dia_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('structure_id', $langs['structure_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('structure_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('gsm_id', $langs['gsm_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('gsm_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('ftype_id', $langs['ftype_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ftype_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('unit_id', $langs['unit_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('unit_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('ytype_id', $langs['ytype_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ytype_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('ycount_id', $langs['ycount_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ycount_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('yconsumption_id', $langs['yconsumption_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('yconsumption_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('ydstripe_id', $langs['ydstripe_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ydstripe_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('ydrepeat', $langs['ydrepeat'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ydrepeat', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('washing_id', $langs['washing_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('washing_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('ccuff_id', $langs['ccuff_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('ccuff_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('aop_id', $langs['aop_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('aop_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('tycraratio_id', $langs['tycraratio_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('tycraratio_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('cprocess_id', $langs['cprocess_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('cprocess_id', null, ['class' => 'form-control', 'required']) !!}
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
        $(".fabricdetail").validate();
    });
        
</script>

@endsection
