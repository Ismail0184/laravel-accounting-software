@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Lctransfer')

@section('contentheader_title', $langs['create_new'] . ' Lctransfer')

@section('main-content')

    {!! Form::open(['route' => 'lctransfer.store', 'class' => 'form-horizontal lctransfer']) !!}
    
    				<div class="form-group">
                        {!! Form::label('client_id', $langs['client_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('client_id',$clients ,null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('lc_id', $langs['lc_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('lc_id',$lcinfos ,null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('tlcdate', $langs['tlcdate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('tlcdate', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('com_rate', $langs['com_rate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('com_rate', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('camount', $langs['camount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('camount', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('note', $langs['note'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('note', null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('bank', $langs['bank'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('bank', null, ['class' => 'form-control', ]) !!}
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
        $(".lctransfer").validate();
		$( "#tlcdate" ).datepicker({ dateFormat: "yy-mm-dd" }).val();

    });
        
</script>

@endsection
