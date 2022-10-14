@extends('app')

@section('contentheader_title', 'COA')

@section('main-content')

    <div class="box">
        <div class="box-header">
            <a href="{{ URL::route('acccoa.index') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['COA'] }}</a>
            
        </div><!-- /.box-header -->
        <div class="box-body">
			<?php
  			$FmyFunctions1 = new \App\library\acc\myFunctions;
  			$is_ok = $FmyFunctions1->convert_number_to_words(12345);
			echo $is_ok;


//echo convert_number_to_words(1234);		
?>

        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#acccoa-table").dataTable({
    		"aoColumns": [ null, null, { "bSortable": false }, { "bSortable": false } ] 
    	});
    } );
</script>

@endsection
