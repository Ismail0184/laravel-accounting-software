@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Purchasedetail')

@section('contentheader_title', $langs['edit'] . ' Purchasedetail')

@section('main-content')
    
    {!! Form::model($purchasedetail, ['route' => ['purchasedetail.update', $purchasedetail->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

					<div class="form-group">
                        {!! Form::label('item_id', $langs['item_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('item_id', $products, null, ['class' => 'form-control', 'required']) !!}
                            {!! Form::hidden('pm_id', null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('qty', $langs['qty'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('qty', null, ['class' => 'form-control', 'id'=>'qty', 'required']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('unit_id', $langs['unit_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('unit_id', array('' => 'Select ...', 1 => 'PCS', 2 => 'Dozen', 3 => 'Kg'), null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
                    <div class="form-group">
                        {!! Form::label('rate', $langs['rate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('rate', null, ['class' => 'form-control', 'id'=>'rate', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('amount', null, ['class' => 'form-control', 'id'=>'amount', 'required']) !!}
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

<script>
var x = document.getElementById("qty");
var y = document.getElementById("rate");
x.addEventListener("keydown", myFocusFunction, true);
x.addEventListener("keyup", myFocusFunction, true);

y.addEventListener("keydown", myFocusFunction, true);
y.addEventListener("keyup", myFocusFunction, true);

function myFocusFunction() {
    document.getElementById("amount").value = document.getElementById("qty").value*document.getElementById("rate").value;  
}

</script>

@endsection