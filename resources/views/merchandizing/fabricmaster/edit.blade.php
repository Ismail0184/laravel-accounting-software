@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Fabricmaster')

@section('contentheader_title', $langs['edit'] . ' Fabrication')

@section('main-content')
    <div class="box">
    <div class="container">
    {!! Form::model($fabricmaster, ['route' => ['fabricmaster.update', $fabricmaster->id], 'method' => 'PATCH', 'class' => 'form-horizontal fabricmaster']) !!}

					<div class="form-group col-sm-2">
                        {!! Form::label('gtype_id', $langs['gtype_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('gtype_id', $gtypes, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('pogarment_id', $langs['pogarment_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('pogarment_id', $pogarments, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('diatype_id', $langs['diatype_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('diatype_id', $diatypes, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('dmu_id', $langs['dmu_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('dmu_id', array(''=>'Select ...','1'=>'Inch', '2'=>'CM'), null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('dia_id', $langs['dia_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('dia_id', $dias, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('gsm_id', $langs['gsm_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('gsm_id', $gsms, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('structure_id', $langs['structure_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('structure_id', $structures, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('noyarn', $langs['noyarn'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('noyarn', array(''=>'Select ...','1'=>'1','2'=>'2','3'=>3,'4'=>4), null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('elasten', $langs['elasten'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('elasten', array(''=>'Select ...','1'=>'Yes','2'=>'No'), null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('lycraratio_id', $langs['lycraratio_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('lycraratio_id', $lycraratios, null, ['class' => 'form-control select2', 'required', 'disabled']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('fcomposition', $langs['fcomposition'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('fcomposition', array(''=>'Select ...','Simple'=>'Simple','Critical'=>'Critical','Complex'=>'Complex'), null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('ftype_id', $langs['ftype_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('ftype_id', $ftypes, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('ydrepeat', $langs['ydrepeat'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::text('ydrepeat', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('ydstripe_id', $langs['ydstripe_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('ydstripe_id', $ydstripes, null, ['class' => 'form-control select2', 'disabled']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('ytype_id', $langs['ytype_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('ytype_id', $ytypes, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('ycount_id', $langs['ycount_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('ycount_id', $ycounts, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('yconsumption_id', $langs['yconsumption_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('yconsumption_id', $yconsumptions, null, ['class' => 'form-control select2']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('aop_id', $langs['aop_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('aop_id', $aops, null, ['class' => 'form-control select2']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('finishing_id', $langs['finishing_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('finishing_id', $finishings, null, ['class' => 'form-control select2']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('washing_id', $langs['washing_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('washing_id', $washings, null, ['class' => 'form-control select2']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('ccuff_id', $langs['ccuff_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('ccuff_id', $ccuffs, null, ['class' => 'form-control select2']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('unit_id', 'Meas. '.$langs['unit_id'], ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::select('unit_id', $units, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('consumption', $langs['consumption'].'/Dz', ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::text('consumption', null, ['class' => 'form-control']) !!}
                        </div>    
                    </div>
					<div class="form-group col-sm-2">
                        {!! Form::label('wastage', $langs['wastage'].'(%)', ['class' => 'control-label']) !!}
                        <div class=""> 
                            {!! Form::text('wastage', 5, ['class' => 'form-control']) !!}
                        </div>    
                    </div>

    
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit($langs['update'], ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
</div>
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
        $(".fabricmaster").validate();

		$('#elasten').on('change', function () {
			if ($(this).val() == '1') {
				$('#lycraratio_id').prop("disabled", false);
			} else {
				$('#lycraratio_id').prop("disabled", true);
			}
		});

		$('#ftype_id').on('change', function () {
			if ($(this).val() == '2') {
				$('#ydrepeat').prop("disabled", false);
				$('#ydstripe_id').prop("disabled", false);
			} else {
				$('#ydrepeat').prop("disabled", true);
				$('#ydstripe_id').prop("disabled", true);
			}
		});

    });
        
</script>

@endsection
