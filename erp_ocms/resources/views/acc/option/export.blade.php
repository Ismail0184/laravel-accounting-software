@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Option')

@section('contentheader_title', $langs['edit'] . ' Option')

@section('main-content')
<?php 
		$bstype=array(
			''	 => 'Select ...',
			'gf' => 'Garments Factory',
			'ex' => 'Export Business',
			'im' => 'Import Business',
			'ei' => 'Export and Import Business',
			'tr' => 'Trading Business',
			'ed' => 'Education',
			'st' => 'Training Center',
			
		
		)
	?>
    
    {!! Form::model($option, ['route' => ['option.update', $option->id], 'method' => 'PATCH', 'class' => 'form-horizontal option']) !!}

					<div class="form-group">
                        {!! Form::label('export', $langs['export'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('export', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('mlctd_id', $langs['mlctd_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('mlctd_id', $coas, null, ['class' => 'form-control select2', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('mlctc_id', $langs['mlctc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('mlctc_id',$coas, null, ['class' => 'form-control select2', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('tlctd_id', $langs['tlctd_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('tlctd_id',$coas, null, ['class' => 'form-control select2', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('tlctc_id', $langs['tlctc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('tlctc_id',$coas, null, ['class' => 'form-control select2', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('b2btd_id', $langs['b2btd_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('b2btd_id',$coas, null, ['class' => 'form-control select2', ]) !!}
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
        $(".option").validate();
    });
        
</script>

@endsection
