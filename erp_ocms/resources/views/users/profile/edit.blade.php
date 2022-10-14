@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Profile')

@section('contentheader_title', $langs['edit'] . ' Profile')

@section('main-content')

<div class="col-md-9">
    <div class="box box-primary">
        <div class="box-body box-profile">
            {!! Form::model($profile, ['method' => 'PATCH', 'route' => ['profile.update', $profile->id], 'class' => 'form-horizontal', 'files' => true]) !!}
        
            <div class="form-group">
                {!! Form::label('name', $langs['name'], ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6"> 
                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
        
            <div class="form-group">
                {!! Form::label('email', $langs['email'], ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6"> 
                    {!! Form::text('email', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                </div>
            </div>
        
            <div class="form-group">
                {!! Form::label('user_img', $langs['image'], ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6"> 
                    {!! Form::file('user_img', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        
            <div class="form-group">
                {!! Form::label('user_sign', $langs['sign'], ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6"> 
                    {!! Form::file('user_sign', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        
            <div class="form-group">
                {!! Form::label('password', $langs['password'], ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6"> 
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
            </div>
        
            <div class="form-group">
                {!! Form::label('password_confirmation', $langs['password_confirmation'], ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6"> 
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
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
</div>
<div class="col-md-3">
    <div class="box box-primary">
        <div class="box-body box-profile">
            <div id="image-preview"></div>
            <div id="sign-preview"></div>
        </div>
    </div>
</div>
@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".user-form").validate({
          rules: {
            password_confirmation: {
              equalTo: "#password"
            }
          }
        });
        
        <?php if(isset($profile->user_img)): ?>
        if('<?php echo $profile->user_img ?>' != null){            
            $("#image-preview").show();
            $("#image-preview").append("<img src='<?php if(isset($profile->user_img)) echo asset('images/user_img/'.$profile->user_img); ?>' />");
        }
        <?php endif; ?>
        
        <?php if(isset($profile->user_sign)): ?>
        if('<?php echo $profile->user_sign ?>' != null){            
            $("#sign-preview").show();
            $("#sign-preview").append("<img src='<?php if(isset($profile->user_sign)) echo asset('images/user_sign/'.$profile->user_sign); ?>' />");
        }
        <?php endif; ?>
        
        $("#user_img").change(function () {
            $("#image-preview").html("");
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png|gif)$/;
            if (regex.test($(this).val().toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    $("#image-preview").show();
                    $("#image-preview").append("<img src='' alt='Image' />");
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#image-preview img").attr("src", e.target.result);
                    }
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    alert("This browser does not support FileReader.");
                }
            } else {
                alert("Please upload a valid image file.");
            }
        });
        
        $("#user_sign").change(function () {
            $("#sign-preview").html("");
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png|gif)$/;
            if (regex.test($(this).val().toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    $("#sign-preview").show();
                    $("#sign-preview").append("<img src='' alt='Sign' />");
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#sign-preview img").attr("src", e.target.result);
                    }
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    alert("This browser does not support FileReader.");
                }
            } else {
                alert("Please upload a valid image file.");
            }
        });
    });
</script>

@endsection
