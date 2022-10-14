@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Salary')

@section('contentheader_title', $langs['edit'] . ' Salary')

@section('main-content')
    <?php 
		Session::has('sm_id') ? $m_id=Session::get('m_id') : $m_id='';
		Session::has('syear') ? $year=Session::get('year') : $year='';
	?>
    {!! Form::model($salary, ['route' => ['salary.update', $salary->id], 'method' => 'PATCH', 'class' => 'form-horizontal salary']) !!}

<!--					<div class="form-group">
                        {!! Form::label('otime', $langs['otime'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('otime', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('hday', $langs['hday'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('hday', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('wday', $langs['wday'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('wday', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
-->					
					<div class="form-group">
                        {!! Form::label('due', $langs['due'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('due', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('absence', $langs['absence'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('absence', null, ['class' => 'form-control', 'required']) !!}
                            {!! Form::hidden('m_id', $m_id, ['class' => 'form-control', 'required']) !!}
                            {!! Form::hidden('year', $year, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('lunch', $langs['lunch'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('lunch', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('mobile', $langs['mobile'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('mobile', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('sallow', $langs['sallow'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('sallow', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('other', $langs['other'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('other', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>

					<div class="form-group">
                        {!! Form::label('esf', $langs['esf'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('esf', array('0'=>'Active','1'=>'Inactive'),null, ['class' => 'form-control', 'required']) !!}
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
        $(".salary").validate();
    });
        
</script>

@endsection
