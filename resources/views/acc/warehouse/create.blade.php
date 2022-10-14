@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Warehouse')

@section('contentheader_title', $langs['create_new'] . ' Warehouse')

@section('main-content')

    {!! Form::open(['route' => 'warehouse.store', 'class' => 'form-horizontal warehouse']) !!}
    
    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('address', $langs['address'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('address', null, ['class' => 'form-control', 'required', 'maxlength'=>200]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('incharge', $langs['incharge'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('incharge', null, ['class' => 'form-control', 'required', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('mobile', $langs['mobile'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('mobile', null, ['class' => 'form-control', 'required', 'maxlength'=>60]) !!}
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
        $(".warehouse").validate();
    });
        
</script>

@endsection
