@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Invenmaster')

@section('contentheader_title', $langs['edit'] . ' Invenmaster')

@section('main-content')
    <?php //$client=array(); ?>
    {!! Form::model($invenmaster, ['route' => ['invenmaster.update', $invenmaster->id], 'method' => 'PATCH', 'class' => 'form-horizontal invenmaster']) !!}

    				<div class="form-group">
                        {!! Form::label('vnumber', $langs['vnumber'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('vnumber', null,  ['class' => 'form-control', 'required', 'number']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('idate', $langs['idate'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('idate', null, ['class' => 'form-control', 'required', 'date']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('client_id', $langs['client_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('client_id', $client ,null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('person', $langs['person'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('person', null, ['class' => 'form-control', 'maxlength'=>60]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('itype', $langs['itype'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('itype',array('' => 'select ...', 'Receive' => 'Receive', 'Issue' => 'Issue', 'Opening' => 'Opening') ,null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
<!--					<div class="form-group">
                        {!! Form::label('req_id', $langs['req_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('req_id', $prequisitions ,null, ['class' => 'form-control', ]) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('amount', $langs['amount'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('amount', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('wh_id', $langs['wh_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('wh_id', $warehouses ,null, ['class' => 'form-control', 'required', 'maxlength'=>60]) !!}
                        </div>    
                    </div>-->
					<div class="form-group">
                        {!! Form::label('check_id', $langs['check_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('check_id',$users, null, ['class' => 'form-control', 'required']) !!}
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
        $(".invenmaster").validate();
    });
        
</script>

@endsection
