@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Order')

@section('contentheader_title', $langs['create_new'] . ' Order')

@section('main-content')
 <div class="box">

        <div class="box-header">
        </div><!-- /.box-header -->
    {!! Form::open(['route' => 'order.store', 'class' => 'form-horizontal order']) !!}
    
 			<div class="form-group col-sm-6">
    				<div class="form-group col-sm-12">
                        {!! Form::label('jobno', $langs['jobno'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('jobno', $jobno, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-12">
                        {!! Form::label('orderno', $langs['orderno'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('orderno', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-12">
                        {!! Form::label('style', $langs['style'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('style', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-12">
                        {!! Form::label('buyer_id', $langs['buyer_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('buyer_id', $buyers, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                            <a href="{{ url('/buyer') }}" class="btn btn-success" target="_new">
       							<span class="glyphicon glyphicon-chevron-right"></span>
    						</a>
                    </div>
					<div class="form-group col-sm-12">
                        {!! Form::label('mt_id', $langs['mt_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('mt_id', $mts, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                            <a href="{{ url('/marketingteam') }}" class="btn btn-success" target="_new">
       							<span class="glyphicon glyphicon-chevron-right"></span>
    						</a>

                    </div>
					<div class="form-group col-sm-12">
                        {!! Form::label('incoterm_id', $langs['incoterm_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('incoterm_id', $incoterms, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                            <a href="{{ url('/incoterm') }}" class="btn btn-success" target="_new">
       							<span class="glyphicon glyphicon-chevron-right"></span>
    						</a>
                    </div>
					<div class="form-group col-sm-12">
                        {!! Form::label('lc_mod_id', $langs['lc_mod_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('lc_mod_id', $lcmodes, null, ['class' => 'form-control', 'required']) !!}
                        </div> 
                            <a href="{{ url('/lcmode') }}" class="btn btn-success"  target="_new">
       							<span class="glyphicon glyphicon-chevron-right"></span>
    						</a>
                    </div>

        	</div>
        	<div class="form-group col-sm-6">
					<div class="form-group col-sm-12">
                        {!! Form::label('item', $langs['item'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::textarea('item', null, ['class' => 'form-control', 'required', 'rows' => 2]) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-12">
                        {!! Form::label('price', $langs['price'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-2" style="padding-right:0px; margin-right:0px"> 
                            {!! Form::select('currency_id', $currencys, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                        <div class="col-sm-4" style="padding-left:0px; margin-left:0px"> 
                            {!! Form::text('price', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-12">
                        {!! Form::label('bd_id', $langs['bd_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('bd_id', $bdtypes, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-12">
                        {!! Form::label('fabrication', $langs['fabrication'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::textarea('fabrication', null, ['class' => 'form-control', 'required', 'rows' => 2]) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-12">
                        {!! Form::label('m_id', $langs['selection'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-4" style="padding-right:0px; margin-right:0px"> 
                            {!! Form::select('m_id', $months, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                         <div class="col-sm-2" style="padding-left:0px; margin-left:0px"> 
                            {!! Form::select('years',$years, null, ['class' => 'form-control', 'required']) !!}
                        </div>    

                    </div>
            </div>

    <div class="form-group">
        <div class="col-sm-offset-7 col-sm-3">
            {!! Form::submit($langs['create'], ['class' => 'btn btn-primary form-control']) !!}
        </div>    
    </div>
    {!! Form::close() !!}
</div>
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
        $(".order").validate();
    });
        
</script>

@endsection
