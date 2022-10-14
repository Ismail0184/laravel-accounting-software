@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Podetail')

@section('contentheader_title', $langs['create_new'] . ' Podetail')

@section('main-content')

    {!! Form::open(['route' => 'podetails.store', 'class' => 'form-horizontal podetails']) !!}
    
					<div class="col-sm-12">
                    <div class="form-group col-sm-3">
                        {!! Form::label('color', $langs['color'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-12"> 
                            {!! Form::text('color', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('size_id', $langs['size_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-12"> 
                            {!! Form::text('size_id', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('ratio', $langs['ratio'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-12"> 
                            {!! Form::text('ratio', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('qty', $langs['qty'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-12"> 
                            {!! Form::text('qty', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
                    <div class="form-group col-sm-2">
                    {!! Form::label('qty', '---', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-12">
                            {!! Form::submit($langs['create'], ['class' => 'btn btn-primary form-control']) !!}
                        </div>    
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
        $(".podetails").validate();
    });
        
</script>

@endsection
