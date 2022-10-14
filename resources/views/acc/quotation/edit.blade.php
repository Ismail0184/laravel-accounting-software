@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Quotation')

@section('contentheader_title', $langs['edit'] . ' Quotation')

@section('main-content')
    
    {!! Form::model($quotation, ['route' => ['quotation.update', $quotation->id], 'method' => 'PATCH', 'class' => 'form-horizontal quotation']) !!}

    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
    				<div class="form-group">
                        {!! Form::label('cpage_id', $langs['cpage_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('cpage_id', $coverpages, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('fletter_id', $langs['fletter_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('fletter_id', $fletters, null, ['class' => 'form-control', 'required']) !!}
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
        $(".quotation").validate();
    });
        
</script>

@endsection
