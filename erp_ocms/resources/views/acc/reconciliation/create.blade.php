@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Reconciliation')

@section('contentheader_title', $langs['create_new'] . ' Reconciliation')

@section('main-content')
<?php 
		$months=array(''=>'Select ...', 1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');
		Session::has('racc_id') ? $acc_id=Session::get('racc_id') : $acc_id='' ;  

?>
    {!! Form::open(['route' => 'reconciliation.store', 'class' => 'form-horizontal reconciliation']) !!}
    
    				<div class="form-group">
                        {!! Form::label('acc_id', $langs['bankname'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('acc_id', $coa, $acc_id, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('tdate', $langs['tdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('tdate', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('amount', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('tranwith_id', $langs['tranwith_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('tranwith_id', $acccoa, null, ['class' => 'form-control select2', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('note', $langs['note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::textarea('note', null, ['class' => 'form-control', 'required', 'size' => '5x3']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('ttype', $langs['ttype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('ttype', array(''=>'Select ...', 'Payment'=>'Payment', 'Receipt'=>'Receipt') ,null, ['class' => 'form-control', 'required']) !!}
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
        $(".reconciliation").validate();
		$( "#tdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
