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
                        {!! Form::label('currency_id', $langs['currency_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('currency_id', $currency, null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('max_pay', $langs['max_pay'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('max_pay', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('tcheck_id', $langs['tcheck_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('tcheck_id',$users, null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('tappr_id', $langs['tappr_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('tappr_id',$users, null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('yo_date', $langs['yo_date'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('yo_date', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('yc_date', $langs['yc_date'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('yc_date', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('inven_auto_update', $langs['inven_auto_update'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('inven_auto_update', array('0'=>'No', '1'=>'Yes'), null, ['class' => 'form-control', ]) !!}
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
		$( "#yo_date" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		$( "#yc_date" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
