@extends('app')

@section('htmlheader_title', 'Supplier')

@section('contentheader_title', 'Supplier')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $supplier->id }}</td>
                <td>{{ $supplier->name }}</td>
            </tr>
        </table>
    </div>
<style>
body {background: #EAEAEA;}
.user-details {position: relative; padding: 0;}
.user-details .user-image {position: relative;  z-index: 1; width: 100%; text-align: center;}
 .user-image img { clear: both; margin: auto; position: relative;}

.user-details .user-info-block {width: 100%; position: absolute; top: 55px; background: rgb(255, 255, 255); z-index: 0; padding-top: 35px;}
 .user-info-block .user-heading {width: 100%; text-align: center; margin: 10px 0 0;}
 .user-info-block .navigation {float: left; width: 100%; margin: 0; padding: 0; list-style: none; border-bottom: 1px solid #428BCA; border-top: 1px solid #428BCA;}
  .navigation li {float: left; margin: 0; padding: 0;}
   .navigation li a {padding: 20px 30px; float: left;}
   .navigation li.active a {background: #428BCA; color: #fff;}
 .user-info-block .user-body {float: left; padding: 5%; width: 90%;}
  .user-body .tab-content > div {float: left; width: 100%;}
  .user-body .tab-content h4 {width: 100%; margin: 10px 0; color: #333;}
</style>
   
<div class="container">
	<div class="row">
		<div class="col-sm-4 user-details">
            <div class="user-info-block">
                <div class="user-heading">
                    <h3>Karan Singh Sisodia</h3>
                    <span class="help-block">Chandigarh, IN</span>
                </div>
                <ul class="navigation">
                    <li class="active">
                        <a data-toggle="tab" href="#information">
                            <span class="glyphicon glyphicon-user"> New</span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#settings">
                            <span class="glyphicon glyphicon-cog"></span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#email">
                            <span class="glyphicon glyphicon-envelope"></span>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#events">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </a>
                    </li>
                </ul>
                <div class="user-body">
                    <div class="tab-content">
                        <div id="information" class="tab-pane active">
                            <h4>Account Information</h4>
                        </div>
                        <div id="settings" class="tab-pane">
                            <h4>Settings</h4>
                        </div>
                        <div id="email" class="tab-pane">
                            <h4>Send Message</h4>
                        </div>
                        <div id="events" class="tab-pane">
                            <h4>Events</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<div class="tab-content">
    <div class="tab-pane active" id="information">
        <a class="btn btn-primary btnNext" >Next</a>
    </div>
    <div class="tab-pane" id="settings">
        <a class="btn btn-primary btnNext" >Next</a>
        <a class="btn btn-primary btnPrevious" >Previous</a>
    </div>
    <div class="tab-pane" id="email">
        <a class="btn btn-primary btnNext" >Next</a>
        <a class="btn btn-primary btnPrevious" >Previous</a>
    </div>
    <div class="tab-pane" id="events">
        <a class="btn btn-primary btnPrevious" >Previous</a>
    </div>
</div>


<div>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">Shipping</a></li>
        <li><a href="#tab2" data-toggle="tab">Quantities</a></li>
        <li><a href="#tab3" data-toggle="tab">Summary</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <a class="btn btn-primary btnNext">Next</a>
        </div>
        <div class="tab-pane" id="tab2">
            <a class="btn btn-primary btnNext">Next</a>
            <a class="btn btn-primary btnPrevious">Previous</a>
        </div>
        <div class="tab-pane" id="tab3">
            <a class="btn btn-primary btnPrevious">Previous</a>
        </div>
    </div>

</div>






@endsection
@section('custom-scripts')

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
		$('.btnNext').click(function(){
			  $('.nav-tabs > .active').next('li').find('a').trigger('click');
			});
			
		$('.btnPrevious').click(function(){
			  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
			});


    });
        
</script>

@endsection

