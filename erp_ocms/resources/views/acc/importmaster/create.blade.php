@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Importmaster')

@section('contentheader_title', $langs['create_new'] . ' Importmaster')

@section('main-content')
    <?php  
		Session::has('com_id') ? 
		$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
		$max_id = DB::table('acc_importmasters')->where('com_id',$com_id)->max('invoice')+1; 	?>
    {!! Form::open(['route' => 'importmaster.store', 'class' => 'form-horizontal']) !!}
    
    				<div class="form-group">
                        {!! Form::label('invoice', $langs['invoice'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('invoice', $max_id, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('idate', $langs['idate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('idate', date('Y-m-d'), ['class' => 'form-control', 'required', 'id'=>'idate']) !!}
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

  <script>
  jQuery(document).ready(function($) {        
		    $( "#idate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
	
  </script>

@endsection