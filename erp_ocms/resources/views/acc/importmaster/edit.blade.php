@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Importmaster')

@section('contentheader_title', $langs['edit'] . ' Importmaster')

@section('main-content')
    <?php Session::put('im_id', $importmaster->id);	 ?>
    {!! Form::model($importmaster, ['route' => ['importmaster.update', $importmaster->id], 'method' => 'PATCH', 'class' => 'form-horizontal']) !!}

    				<div class="form-group">
                        {!! Form::label('invoice', $langs['invoice'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('invoice', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('idate', $langs['idate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('idate', null, ['class' => 'form-control', 'required', 'id'=>'idate']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('lcimport_id', $langs['lcimport_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('lcimport_id',$lcimport, null, ['class' => 'form-control', 'required']) !!}
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
  jQuery(document).ready(function($) {        
        $(".form-horizontal").validate();
		    $( "#idate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();

    });
	
  </script>
@endsection