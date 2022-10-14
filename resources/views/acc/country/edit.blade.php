@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Country')

@section('contentheader_title', $langs['edit'] . ' Country')

@section('main-content')
    
    {!! Form::model($country, ['route' => ['country.update', $country->id], 'method' => 'PATCH', 'class' => 'form-horizontal country']) !!}

    <div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('continent', $langs['continent'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('continent', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('short', $langs['short'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('short', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<div class="form-group">
                        {!! Form::label('code', $langs['code'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
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
        $(".country").validate();
    });
        
</script>

@endsection
