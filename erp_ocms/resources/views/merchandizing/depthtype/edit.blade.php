@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Depthtype')

@section('contentheader_title', $langs['edit'] . ' Depthtype')

@section('main-content')
    
    {!! Form::model($depthtype, ['route' => ['depthtype.update', $depthtype->id], 'method' => 'PATCH', 'class' => 'form-horizontal depthtype']) !!}

    <div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
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
        $(".depthtype").validate();
    });
        
</script>

@endsection
