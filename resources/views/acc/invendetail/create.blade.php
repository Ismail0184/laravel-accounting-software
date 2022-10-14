@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Invendetail')

@section('contentheader_title', $langs['create_new'] . ' Invendetail')

@section('main-content')

    {!! Form::open(['route' => 'invendetail.store', 'class' => 'form-horizontal invendetail']) !!}
    
    <div class="form-group">
                        {!! Form::label('im_id', $langs['im_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('im_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('item_id', $langs['item_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('item_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('qty', $langs['qty'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('qty', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('unit_id', $langs['unit_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('unit_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('rate', $langs['rate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('rate', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('amount', null, ['class' => 'form-control', 'required']) !!}
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
        $(".invendetail").validate();
    });
        
</script>

@endsection
