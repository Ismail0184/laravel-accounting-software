@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Uoutlet')

@section('contentheader_title', $langs['edit'] . ' Uoutlet')

@section('main-content')
    
    {!! Form::model($uoutlet, ['route' => ['uoutlet.update', $uoutlet->id], 'method' => 'PATCH', 'class' => 'form-horizontal uoutlet']) !!}

    				<div class="form-group">
                        {!! Form::label('designation', $langs['designation'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('designation', null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('users_id', $langs['users_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('users_id', $users, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('olt_id', $langs['olt_id'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('olt_id', $outlets, null, ['class' => 'form-control', 'required']) !!}
                        </div>    
                    </div>
					<div class="form-group">
                        {!! Form::label('setting', $langs['setting'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::select('setting', array(''=>'Select ...', 'Defauld'=>'Defauld'), null, ['class' => 'form-control', ]) !!}
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
        $(".uoutlet").validate();
    });
        
</script>

@endsection
