@extends('app')

@section('htmlheader_title', 'Order')

@section('contentheader_title', 'Order Details')

@section('main-content')


<style>
body {background: #EAEAEA;}
.user-details {position: relative; padding: 0;}
.user-details .user-image {position: relative;  z-index: 1; width: 100%; text-align: center;}
 .user-image img { clear: both; margin: auto; position: relative;}

.user-details .user-info-block {width: 100%; position: absolute; top: 55px; background: rgb(255, 255, 255); z-index: 0; padding-top:;}
 .user-info-block .user-heading {width: 100%; text-align: center;}
 .user-info-block .navigation {float: left; width: 100%; margin: 0; padding: 0; list-style: none; border-bottom: 1px solid #428BCA; border-top: 1px solid #428BCA;}
  .navigation li {float: left; margin: 0; padding: 0;}
   .navigation li a {padding: 20px 30px; float: left;}
   .navigation li.active a {background: #428BCA; color: #fff;}
 .user-info-block .user-body {float: left; padding:; width: 100%;}
  .user-body .tab-content > div {float: left; width: 100%;}
  .user-body .tab-content h4 {width: 100%; margin: 0 0; color: #333;}
  
  .bdy { min-height:200px; border-bottom: 1px solid #428BCA; background: rgb(255, 255, 255); padding-left:10%}
  .user-body { background-color:#6C9; padding:0px}
  
</style>
   
<div class="box">
        <div class="box-body">
                <div class="user-info-block">
                    <div class="user-heading">
                        <h3>Job No: {{ $order->jobno }}</h3>
                        <span class="help-block">Order No: {{ $order->orderno }}</span>
                    </div>
                    <ul class="navigation nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#buyer">
                                <span class="glyphicon  glyphicon-th"> Buyer</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#color">
                                <span class="glyphicon glyphicon-random"> Corlor & Size Breakdown</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#fabric">
                                <span class="glyphicon glyphicon-briefcase"> Fabrication</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#yarn">
                                <span class="glyphicon glyphicon-calendar"> Yarn</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#print">
                                <span class="glyphicon glyphicon-calendar"> Print/Embroidery</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#trim">
                                <span class="glyphicon glyphicon-calendar"> Trims</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#other">
                                <span class="glyphicon glyphicon-calendar"> Others</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#cost">
                                <span class="glyphicon glyphicon-calendar"> Costsheet</span>
                            </a>
                        </li>
                    </ul>
                    <div class="user-body">
                        <div class="tab-content">
                            <div id="buyer" class="tab-pane active">
                                <div class="bdy">
                                	<table class="table" width="80%">
                                    	<tr><td class="col-sm-2 text-right">Buyer Name:</td><td>{{ $order->buyer->name}}</td><td class="col-sm-2 text-right">Marketing Team:</td><td>{{$order->team->name }}</td></tr>
                                    	<tr><td class="col-sm-2 text-right">Incoterm:</td><td>{{ $order->incoterm->name}}</td><td  class="col-sm-2 text-right">Price:</td><td>{{ $order->price }}/@if(isset($order->currency->name)){{ $order->currency->name }}@endif</td></tr>
                                    	<tr><td class="col-sm-2 text-right">LC Mode:</td><td>{{ $order->lcmode->name}}</td><td  class="col-sm-2 text-right">Fabrication:</td><td>{{$order->fabric }}</td></tr>
                                    	<tr><td class="col-sm-2 text-right">Prododuct Details:</td><td>{{ $order->item}}</td><td  class="col-sm-2 text-right">Selection:</td><td>{{$months[$order->m_id]}}/{{ $order->years }}</td></tr>
                                    </table>
                                </div>
                                <a class="btn btn-primary btnNext" >Next</a><span class="col-sm-offset-5">1/8</span>
                            </div>
                            <div id="color" class="tab-pane">
                                
                                <div class="bdy">
                                <h4>Color</h4>
                                </div>
                                <a class="btn btn-primary btnNext" >Next</a><span class="col-sm-offset-5">2/8</span>
                                <a class="btn btn-primary btnPrevious pull-right" >Previous</a>
                            </div>
                            <div id="fabric" class="tab-pane">
                                
                                <div class="bdy">
                                <h4>Fabric</h4>
                                </div>
                                <a class="btn btn-primary btnNext" >Next</a><span class="col-sm-offset-5">3/8</span>
                                <a class="btn btn-primary btnPrevious pull-right" >Previous</a>
                            </div>
                            <div id="yarn" class="tab-pane">
                                
                                <div class="bdy">
                                <h4>Yarn</h4>
                                </div>
                                <a class="btn btn-primary btnNext" >Next</a><span class="col-sm-offset-5">4/8</span>
                                <a class="btn btn-primary btnPrevious pull-right" >Previous</a>
                            </div>
                            <div id="print" class="tab-pane">
                                
                                <div class="bdy">
                                <h4>Print</h4>
                                </div>
                                <a class="btn btn-primary btnNext" >Next</a><span class="col-sm-offset-5">5/8</span>
                                <a class="btn btn-primary btnPrevious pull-right" >Previous</a>
                            </div>
                            <div id="trim" class="tab-pane">
                                
                                <div class="bdy">
                                <h4>Trim</h4>
                                </div>
                                <a class="btn btn-primary btnNext" >Next</a><span class="col-sm-offset-5">6/8</span>
                                <a class="btn btn-primary btnPrevious pull-right" >Previous</a>
                            </div>
                            <div id="other" class="tab-pane">
                                
                                <div class="bdy">
                                <h4>Other</h4>
                                </div>
                                <a class="btn btn-primary btnNext" >Next</a><span class="col-sm-offset-5">7/8</span>
                                <a class="btn btn-primary btnPrevious pull-right" >Previous</a>
                            </div>
                            <div id="cost" class="tab-pane">
                                
                                <div class="bdy">
                                <h4>Cost</h4>
                                </div><span class="col-sm-offset-5">8/8</span>
                                <a class="btn btn-primary btnPrevious pull-right" >Previous</a>
                            </div>
                        </div>
                    </div>

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

