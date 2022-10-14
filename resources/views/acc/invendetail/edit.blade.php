@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Invendetail')

@section('contentheader_title', $langs['edit'] . ' Invendetail')

@section('main-content')
    
    {!! Form::model($invendetail, ['route' => ['invendetail.update', $invendetail->id], 'method' => 'PATCH', 'class' => 'form-horizontal invendetail']) !!}

					<div class="form-group">
                        {!! Form::label('item_id', $langs['item_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('item_id', $products,null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('qty', $langs['qty'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('qty', null, ['class' => 'form-control', 'required', 'id'=>'qty']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('rate', $langs['rate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('rate', null, ['class' => 'form-control', 'required', 'id'=>'rate']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('amount', null, ['class' => 'form-control', 'required', 'id'=>'amount']) !!}
                            {!! Form::hidden('im_id', null) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('cos', $langs['cos'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('cos', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('war_id', $langs['war_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('war_id', $warehouses,null, ['class' => 'form-control', 'required', 'id'=>'rate']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('prod_id', $langs['prod_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('prod_id', $products ,null, ['class' => 'form-control select2']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('batch', $langs['batch'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('batch',null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('pro_id', $langs['pro_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('pro_id', $projects, null, ['class' => 'form-control', 'id'=> 'pro_id']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('seg_id', $langs['seg_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select ('seg_id', array(),  null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('for', $langs['for'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           {!! Form::select('for', $ittypes ,null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('ref', $langs['ref'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           {!! Form::text('ref', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('prod_id', $langs['prod_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                           {!! Form::select('prod_id', $products, null, ['class' => 'form-control', ]) !!}
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
var x = document.getElementById("qty");
var y = document.getElementById("rate");
x.addEventListener("keydown", myFocusFunction, true);
x.addEventListener("keyup", myFocusFunction, true);

y.addEventListener("keydown", myFocusFunction, true);
y.addEventListener("keyup", myFocusFunction, true);

function myFocusFunction() {
    document.getElementById("amount").value = document.getElementById("qty").value*document.getElementById("rate").value;  
}
        
    jQuery(document).ready(function($) {        
        $(".invendetail").validate();
    });
        
</script>

@endsection
