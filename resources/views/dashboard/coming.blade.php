@extends('app')

@section('contentheader_title', 'Coming Soon')

@section('main-content')

    <div class="box">
        <div class="box-body">
           <h2 class="text-center"> The Module is under construction, and it is coming very soon! </h2>
        </div>
<style>
	.row { padding-left:25%; }
</style>
 <div class="row">
        <ul class="thumbnails">
            <div class="col-md-6">
                <div class="thumbnail" >
                    <img src="{{url('dashboard/coming/get')}}" alt="ALT NAME" class="img-responsive" />
                    <div class="caption">
                    </div>
                </div>
            </div>
 </ul>
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
