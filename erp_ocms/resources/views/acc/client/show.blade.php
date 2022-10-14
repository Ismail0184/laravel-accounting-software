@extends('app')

@section('htmlheader_title', 'Client')

@section('contentheader_title', 'Client')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->name }}</td>
            </tr>
        </table>
    </div>
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Shipping</a></li>
    <li><a href="#tab2" data-toggle="tab">Quantities</a></li>
    <li><a href="#tab3" data-toggle="tab">Summary</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab1">
        <a class="btn btn-primary btnNext" >Next</a>
    </div>
    <div class="tab-pane" id="tab2">
        <a class="btn btn-primary btnNext" >Next</a>
        <a class="btn btn-primary btnPrevious" >Previous</a>
    </div>
    <div class="tab-pane" id="tab3">
        <a class="btn btn-primary btnPrevious" >Previous</a>
    </div>
</div>

@endsection
@section('custom-scripts')

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".bivag").validate();
		
		$('.btnNext').click(function(){
		  $('.nav-tabs > .active').next('li').find('a').trigger('click');
		});
		
		  $('.btnPrevious').click(function(){
		  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
		});
    });
        
</script>

@endsection
