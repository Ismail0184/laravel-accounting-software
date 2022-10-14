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
                        {!! Form::label('audit', $langs['audit'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('audit', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('audit_id', $langs['audit_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('audit_id', $users, null, ['class' => 'form-control', ]) !!}
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
