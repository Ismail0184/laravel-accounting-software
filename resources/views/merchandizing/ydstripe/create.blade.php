@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Ydstripe')

@section('contentheader_title', $langs['create_new'] . ' Ydstripe')

@section('main-content')

    {!! Form::open(['route' => 'ydstripe.store', 'class' => 'form-horizontal ydstripe']) !!}
    
    <div class="form-group">
                        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6"> 
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
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
        $(".ydstripe").validate();
    });
        
</script>

@endsection
