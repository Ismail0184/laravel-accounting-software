@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Termcondition')

@section('contentheader_title', $langs['edit'] . ' Termcondition')

@section('main-content')
    
    {!! Form::model($termcondition, ['route' => ['termcondition.update', $termcondition->id], 'method' => 'PATCH', 'class' => 'form-horizontal termcondition']) !!}

    				<div class="form-group">
                        {!! Form::label('quotation_id', $langs['quotation_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('quotation_id', $quotations, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('topic_id', $langs['topic_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('topic_id', $topics, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('condition_id', $langs['condition_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('condition_id', $conditions, null, ['class' => 'form-control', 'required']) !!}
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
        $(".termcondition").validate();
    });
        
</script>

@endsection
