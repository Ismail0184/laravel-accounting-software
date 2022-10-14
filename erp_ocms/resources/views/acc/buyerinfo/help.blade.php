@extends('app')

@section('contentheader_title', 'Buyer')

@section('main-content')

    <div class="box">
        <div class="box-header">
            <a href="{{ URL::route('buyerinfo.index') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['buyer'] }}</a>
            
        </div><!-- /.box-header -->
        <div class="box-body">
			<?php
  			$FmyFunctions1 = new \App\library\acc\myFunctions;
  			$is_ok = ($FmyFunctions1->is_ok());
			echo $is_ok;
?>
           Help is Coming!
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
