@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Qproduct')

@section('contentheader_title', $langs['create_new'] . ' Quotation product')

@section('main-content')

    {!! Form::open(['route' => 'qproduct.store', 'class' => 'form-horizontal qproduct']) !!}
    
    				<div class="form-group">
                        {!! Form::label('quotation_id', $langs['quotation_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('quotation_id', $quotations, $quotation_id, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('prod_id', $langs['prod_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('prod_id', $products, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('qty', $langs['qty'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('qty', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('rate', $langs['rate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('rate', null, ['class' => 'form-control', 'required']) !!}
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
        $(".qproduct").validate();
		
		 $("#prod_id").change(function() {
            $.getJSON("{{ url('qproduct/price')}}/" + $("#prod_id").val(), function(data) {
                var $courts = $("#rate");
                $courts.empty();
                $.each(data, function(index, value) {
					$courts.val(value);
                });
            });
        });
    });
        
</script>

@endsection
