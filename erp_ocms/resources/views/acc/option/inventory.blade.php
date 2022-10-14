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
                        {!! Form::label('inventory', $langs['inventory'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('inventory', array(0=>'Inactive', 1=>'Active' ), null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('icheck_id', $langs['icheck_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('icheck_id', $users, null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('iappr_id', $langs['iappr_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('iappr_id',$users, null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('cwh_id', $langs['cwh_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('cwh_id',$warehouses, null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('business', $langs['business'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('business',array(''=>'Select...', 'General'=>'General','Knitting'=>'Knitting'), null, ['class' => 'form-control', ]) !!}
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
