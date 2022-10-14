@extends('app')

@section('htmlheader_title', $langs['create_new'] . ' Employee basic info')

@section('contentheader_title', $langs['create_new'] . ' Employee basic info')

@section('main-content')

    {!! Form::open(['route' => 'employee-basic-info.store', 'class' => 'form-horizontal hrm-form', 'files' => true]) !!}
    
    <div class="col-sm-6">
        <div class="box box-primary">
        	<div class="box-header with-border">
        	  <i class="fa fa-info"></i>
        	  <h3 class="box-title">{{ $langs['hrm_basic_info'] }}</h3>
        	</div><!-- /.box-header -->
        	<div class="box-body">
                <div class="form-group">
                    {!! Form::label('fullname', $langs['fullname'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('fullname', null, ['class' => 'form-control', 'required']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('father_name', $langs['father_name'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('father_name', null, ['class' => 'form-control', 'required']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('mother_name', $langs['mother_name'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('mother_name', null, ['class' => 'form-control', 'required']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('husband_name', $langs['husband_name'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('husband_name', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('no_of_child', $langs['no_of_child'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('no_of_child', null, ['class' => 'form-control', 'required']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('dob', $langs['dob'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('dob', null, ['class' => 'form-control', 'required']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('nid', $langs['nid'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('nid', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('bcn', $langs['bcn'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('bcn', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>
                <div class="form-group nationality">
                    {!! Form::label('nationality', $langs['nationality'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        <div class="radio-inline">
                            <label>
                                {!! Form::radio('nationality', 'Bangladeshi', true) !!}
                                Bangladeshi
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                {!! Form::radio('nationality', '') !!}
                                Others
                            </label>
                        </div>
                        
                        {!! Form::text('nationality_text', null, ['id' => 'nationality_text', 'class' => 'form-control']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('passport', $langs['passport'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('passport', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('sex', $langs['sex'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::select('sex', array('' => 'Select...', 'Male' => 'Male', 'Female' => 'Female'), null, ['class' => 'form-control select2', 'required']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('marital_status', $langs['marital_status'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::select('marital_status', array('' => 'Select...', 'Married' => 'Married', 'Unmarried' => 'Unmarried'), null, ['class' => 'form-control select2', 'required']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('religion', $langs['religion'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::select('religion', $religion, null, ['class' => 'form-control select2', 'required']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('driving_license', $langs['driving_license'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('driving_license', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('tin_no', $langs['tin_no'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('tin_no', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('no_of_child', $langs['no_of_child'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::number('no_of_child', null, ['class' => 'form-control', 'required']) !!}
                    </div>    
                </div>
        	</div><!-- /.box-body -->
        </div>
        
        <div class="box box-primary">
        	<div class="box-header with-border">
        	  <i class="fa fa-bank"></i>
        	  <h3 class="box-title">{{ $langs['hrm_bank_info'] }}</h3>
        	</div><!-- /.box-header -->
        	<div class="box-body">
                <div class="form-group">
                    {!! Form::label('bank_name', $langs['bank_name'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('bank_name', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('bank_barnch', $langs['bank_barnch'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('bank_barnch', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('acc_no', $langs['acc_no'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('acc_no', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>        	  
        	</div><!-- /.box-body -->
        </div>
        
        <div class="box box-primary">
        	<div class="box-header with-border">
        	  <i class="fa fa-envelope"></i>
        	  <h3 class="box-title">{{ $langs['hrm_contact_info'] }}</h3>
        	</div><!-- /.box-header -->
        	<div class="box-body">
                <div class="form-group">
                    {!! Form::label('email', $langs['email'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('mob_office', $langs['mob_office'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('mob_office', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>
                <div class="form-group">
                    {!! Form::label('mob_personal', $langs['mob_personal'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('mob_personal', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>  
                <div class="form-group">
                    {!! Form::label('phone', $langs['phone'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                    </div>    
                </div>        	  
        	</div><!-- /.box-body -->
        </div>
        
    </div>
    
    <div class="col-sm-6">
        <div class="box box-primary">
        	<div class="box-header with-border">
        	  <i class="fa fa-image"></i>
        	  <h3 class="box-title">{{ $langs['employee_img'] }}</h3>
        	</div><!-- /.box-header -->
        	<div class="box-body">
                <div id="image-preview"></div>
                <div class="form-group">
                    {!! Form::label('employee_img', $langs['employee_img'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::file('employee_img') !!}
                    </div>    
                </div>      
        	</div><!-- /.box-body -->
        </div>
        
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-location-arrow"></i>
                <h3 class="box-title">{{ $langs['hrm_address'] }}</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-6"> 
                        <div class="checkbox icheck">
                            <label>
                                {!! Form::checkbox('sameas', '1', true, ['id' => 'sameas']) !!}
                                {{ $langs['sameas'] }}
                            </label>
                        </div>
                    </div>    
                </div>
                <div class="col-sm-6">
                    <div class="box box-primary">
                    	<div class="box-header with-border">
                    		<h3 class="box-title">{{ $langs['hrm_per_add'] }}</h3>
                    	</div><!-- /.box-header -->
                    	<div class="box-body">
                            <div class="form-group">
                                {!! Form::label('per_road', $langs['hrm_road'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('per_road', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('per_house', $langs['hrm_house'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('per_house', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('per_flat', $langs['hrm_flat'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('per_flat', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('per_vill', $langs['hrm_village'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('per_vill', null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('per_po', $langs['hrm_po'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('per_po', null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('per_ps', $langs['hrm_ps'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('per_ps', null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('per_city', $langs['hrm_city'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('per_city', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('per_dist', $langs['hrm_dist'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::select('per_dist', $district, null, ['class' => 'form-control select2', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('per_zip', $langs['hrm_zip'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('per_zip', null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('per_division', $langs['hrm_division'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::select('per_division', $division, null, ['class' => 'form-control select2', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('per_country', $langs['hrm_country'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('per_country', null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>     
                    	</div><!-- /.box-body -->
                    </div>
                </div> 
                <div class="col-sm-6" id="present">
                    <div class="box box-primary">
                    	<div class="box-header with-border">
                    		<h3 class="box-title">{{ $langs['hrm_pre_add'] }}</h3>
                    	</div><!-- /.box-header -->
                    	<div class="box-body">
                            <div class="form-group">
                                {!! Form::label('pre_road', $langs['hrm_road'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('pre_road', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('pre_house', $langs['hrm_house'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('pre_house', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('pre_flat', $langs['hrm_flat'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('pre_flat', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('pre_vill', $langs['hrm_village'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('pre_vill', null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('pre_po', $langs['hrm_po'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('pre_po', null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('pre_ps', $langs['hrm_ps'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('pre_ps', null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('pre_city', $langs['hrm_city'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('pre_city', null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('pre_dist', $langs['hrm_dist'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::select('pre_dist', $district, null, ['class' => 'form-control select2', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('pre_zip', $langs['hrm_zip'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('pre_zip', null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('pre_division', $langs['hrm_division'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::select('pre_division', $division, null, ['class' => 'form-control select2', 'required']) !!}
                                </div>    
                            </div>     
                            <div class="form-group">
                                {!! Form::label('pre_country', $langs['hrm_country'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9"> 
                                    {!! Form::text('pre_country', null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div> 
                    	</div><!-- /.box-body -->
                    </div> 
                    
                </div> 
            </div><!-- /.box-body -->
        </div>
        
        <div class="box box-primary">
        	<div class="box-header with-border">
        		<i class="fa fa-lock"></i>
        		<h3 class="box-title">{{ $langs['hrm_employee_office_info'] }}</h3>
        	</div><!-- /.box-header -->
        	<div class="box-body">
                <div class="form-group">
                    {!! Form::label('employee_code', $langs['employee_code'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        {!! Form::text('employee_code', null, ['class' => 'form-control', 'required']) !!}
                    </div>    
                </div>  
                <div class="form-group">
                    {!! Form::label('employee_type', $langs['employee_type'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        <div class="radio-inline">
                            <label>
                                {!! Form::radio('employee_type', 'Local', true, ['required']); !!}
                                Local
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                {!! Form::radio('employee_type', 'Expatriate', null, ['required']); !!}
                                Expatriate
                            </label>
                        </div>
                    </div>    
                </div> 
                <div class="form-group">
                    {!! Form::label('employee_nature', $langs['employee_nature'], ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6"> 
                        <div class="radio-inline">
                            <label>
                                {!! Form::radio('employee_nature', 'Temporary', null, ['required']); !!}
                                Temporary
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                {!! Form::radio('employee_nature', 'Permanent', null, ['required']); !!}
                                Permanent
                            </label>
                        </div>
                    </div>    
                </div>
        
        	</div><!-- /.box-body -->
        </div>
        
    </div>
    
    <div class="form-group" style="clear: both;">
        <div class="col-sm-offset-4 col-sm-4">
            {!! Form::submit($langs['create'], ['class' => 'btn btn-block btn-primary btn-lg']) !!}
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
<script src="{{ asset('/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $( "#dob" ).datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:-18",
            dateFormat: "dd-mm-yy",
            defaultDate: new Date(1991, 00, 01),
            firstDay: 6
        });
        
        /*
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '5%' // optional
        }); */
        
        $('.nationality input').on('change', function() {
            
            if($('input[name="nationality"]:checked', '.nationality').val()==""){
                $('#nationality_text').show();
            }
            else {
                $('#nationality_text').hide();
            }
        });
        $('#sameas').change(function () {
            if ($(this).is(':checked')) {
                $('#present').hide();
            };
            if ($(this).is(':checked') == false) {
                $('#present').show(); 
            };
        });
        
        $(".hrm-form").validate({
            rules : {
                datepicker : {
                    required: true,
                    date: true
                },
                nationality_text : {
                    required: {
                        depends: function () {
                            if($('input[name="nationality"]:checked', '#nationality').val()==""){
                                return true
                            }
                            else {
                                return false
                            }                            
                        }
                    }
                },
                pre_vill : {
                    required: {
                        depends: function () {
                            if($('#sameas').is(':checked')){
                                return false
                            }
                            else {
                                return true
                            }                            
                        }
                    }
                },
                pre_po : {
                    required: {
                        depends: function () {
                            if($('#sameas').is(':checked')){
                                return false
                            }
                            else {
                                return true
                            }
                        }
                    }
                },
                pre_ps : {
                    required: {
                        depends: function () {
                            if($('#sameas').is(':checked')){
                                return false
                            }
                            else {
                                return true
                            }
                        }
                    }
                },
                pre_dist : {
                    required: {
                        depends: function () {
                            if($('#sameas').is(':checked')){
                                return false
                            }
                            else {
                                return true
                            }
                        }
                    }
                },
                pre_zip : {
                    required: {
                        depends: function () {
                            if($('#sameas').is(':checked')){
                                return false
                            }
                            else {
                                return true
                            }
                        }
                    }
                },
                pre_division : {
                    required: {
                        depends: function () {
                            if($('#sameas').is(':checked')){
                                return false
                            }
                            else {
                                return true
                            }
                        }
                    }
                },
                pre_country : {
                    required: {
                        depends: function () {
                            if($('#sameas').is(':checked')){
                                return false
                            }
                            else {
                                return true
                            }
                        }
                    }
                }
            }
        });
        
        $("#employee_img").change(function () {
            $("#image-preview").html("");
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png|gif)$/;
            if (regex.test($(this).val().toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    $("#image-preview").show();
                    $("#image-preview").append("<img src='<?php if(isset($data['employee_img'])) echo 'uploads/'.$data['employee_img'] ?>' />");
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
        
    } );
</script>

@endsection


