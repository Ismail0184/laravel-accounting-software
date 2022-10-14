@extends('app')

@section('htmlheader_title', $langs['add_new'] . ' User')

@section('contentheader_title', $langs['add_new'] . ' User')

@section('main-content')

    {!! Form::open(['route' => 'users.store', 'class' => 'form-horizontal user-form']) !!}

    <div class="form-group">
        {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('email', $langs['email'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('dept_id', $langs['department'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::select('dept_id', $departments, null, ['class' => 'form-control select2', 'required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('', $langs['companies'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6 companies"> 
        @foreach($companies as $company)
            <div class="checkbox checkbox-inline">
                <label>
                    {!! Form::checkbox('company[]', $company->id) !!} {{ $company->name }}
                </label>
            </div>
        @endforeach
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('', $langs['default_company'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
        @foreach($companies as $company)
            <div class="radio radio-inline">
                <label>
                    {!! Form::radio('default_company', $company->id) !!} {{ $company->name }}
                </label>
            </div>
        @endforeach
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('password', $langs['password'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('password_confirmation', $langs['password_confirmation'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('', $langs['roles'], ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6"> 
        @foreach($roles as $role)
            @if( !in_array($role->id, $skip_role) )
            <div class="checkbox checkbox-inline">
                <label>
                    {!! Form::checkbox('role[]', $role->id) !!} {{ $role->display_name }}
                </label>
            </div>
            @endif
        @endforeach
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit($langs['create'], ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {  
        $(':radio').parent('label').hide();  
        $('.companies :checkbox').click(function($e){
            var value = $(this).val();
            $(':radio[value='+value+']').parent('label').toggle();
        })
        $(".user-form").validate({
          rules: {
            'company[]': "required",
            default_company: "required",
            password: "required",
            password_confirmation: {
              equalTo: "#password"
            }
          }
        });
    } );
</script>

@endsection