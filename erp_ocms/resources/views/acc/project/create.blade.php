@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Project')

@section('contentheader_title', $langs['create_new'] . ' Project')

@section('main-content')

    {!! Form::open(['route' => 'acc-project.store', 'class' => 'form-horizontal project']) !!}
    
    				<div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlenght'=>100]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('description', $langs['description'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('description', null, ['class' => 'form-control', 'required', 'maxlenght'=>255]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('location', $langs['location'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('location', null, ['class' => 'form-control', 'required', 'maxlenght'=>150]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('cost', $langs['cost'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('cost', null, ['class' => 'form-control', 'required', 'number']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('pdate', $langs['projdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('pdate', null, ['class' => 'form-control', 'required', 'date']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('sdate', $langs['pstrdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('sdate', null, ['class' => 'form-control', 'required', 'date']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('fdate', $langs['fdate'], ['class' => 'col-sm-3 control-label', 'date']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('fdate', null, ['class' => 'form-control', 'required']) !!}
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
        $(".project").validate();
				$( "#pdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
				$( "#sdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
				$( "#fdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();

    });
        
</script>

@endsection
