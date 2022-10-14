@extends('app')

@section('htmlheader_title', 'Pomaster')

@section('contentheader_title', 'Size and Color')

@section('main-content')

<style>
	.custable { width:80%; background-color:#9CF; margin-left:10%}
	body .modal {
  width: 90%; /* desired relative width */
  left: 5%; /* (100%-width)/2 */
  /* place center */
  margin-left:auto;
  margin-right:auto; 
}
.modal-dialog {
  width: 80%; /* or whatever you wish */
}
  .ttl, .bd { color:#900; font-weight:bold; font-size:24px}
</style>
    <div class="box">
        <div class="box-header">
            <h3 class="text-center mp">@if(isset( $company->name)){{ $company->name }}@endif</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
        	<?php  
				$sc=$pomaster->size_count;  
				$cc=$pomaster->color_count; 
				$color_ttl=''; $size_ttl=array();$ordno='';
				
				isset($pomaster->order->orderno) ? $ordno=$pomaster->order->orderno : '';
				
				$breakdown=DB::table('merch_orders')->where('orderno',$ordno)->first();
				$ratio_id=''; isset($breakdown) && $breakdown->id > 0 ? $ratio_id=$breakdown->bd_id : $ratio_id='';
				$bd=$bdtype[$ratio_id].' based'; 
				$job_qty=DB::table('merch_podetails')->where('jobno',$pomaster->jobno)->sum('qty');
			?>
            <table id="pomaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="col-sm-3 text-right">{{ $langs['jobno'] }}</th><td class="col-sm-4 text-left">{{ $pomaster->jobno }}</td>
                        <th class="col-sm-2 text-right">{{ $langs['factory_ship_date'] }}</th><td class="col-sm-4 text-left">{{ $pomaster->factory_ship_date }}</td>
                    </tr><tr>
                        <th class="col-sm-3 text-right">{{ $langs['pono'] }}</th><td>{{ $pomaster->pono }}</td>
                        <th class="col-sm-2 text-right">{{ $langs['po_rcvd_date'] }}</th><td>{{ $pomaster->po_rcvd_date }}</td>
                    </tr><tr>
                        <th class="col-sm-3 text-right">{{ $langs['orderno'] }}</th><td>@if(isset($pomaster->order->orderno)){{ $pomaster->order->orderno }}@endif</td>
                        <th class="col-sm-2 text-right">{{ $langs['shipment_date'] }}</th><td>{{ $pomaster->shipment_date }}</td>
                    </tr><tr>
                        <th class="col-sm-3 text-right">{{ $langs['qty'] }}</th><td>{{ $job_qty }}/@if(isset($pomaster->unit->name)){{ $pomaster->unit->name }}@endif <span class="bd">  ({{ $bd }} )</span></td>
                        <th class="col-sm-2 text-right">{{ $langs['color_count'] }}</th><td>{{ $pomaster->color_count }}</td>
                    </tr><tr>
                        <th class="col-sm-3 text-right">{{ $langs['size_count'] }}</th><td>{{ $pomaster->size_count }}</td>
                        <th class="col-sm-2 text-right"></th>
                        <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Add New Port </button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
                @foreach($podetail_port as $port )
            <table  class="table table-bordered custable" >
                <thead>
                <?php 
					$podetail_color = DB::table('merch_podetails')->where('port_id',$port->port_id)->select('color','jobno','port_id')->where('jobno',$pomaster->jobno)->groupBy('color')->Oldest()->get();
					$podetail_size = DB::table('merch_podetails')->where('port_id',$port->port_id)->select('size')->where('jobno',$pomaster->jobno)->groupBy('size')->Oldest()->get();
					$color_ttl==''; $r=0; $ttl=''; $ttl_qty='';
				?>
					<tr>
                        <th colspan="{{ $sc }}" class="text-left">{{ $langs['port_id'] }}: @if(isset($port->port->name)){{ $port->port->name }}@endif</th>
                    </tr>                
					<tr>
                        <th >{{ $langs['color'] }}</th>
                        @foreach($podetail_size as  $item)
                        	<th >{{ $item->size }}</th>
                        @endforeach
                        <th >Total</th>
                    </tr>
                    <?php //$podetail_color =array(); ?>
                    @foreach($podetail_color as  $item)
                    <?php $color_ttl;  $color_ttl=''; $r=0;  $a['']=''; $b['']=''; $size_ttl='';?>
                    <tr>
                        <td>{{ $item->color }}</td>
                        @foreach($podetail_size as  $val)
                        
                        <?php $ration=DB::table('merch_podetails')->where('jobno',$item->jobno)->where('port_id',$item->port_id)->where('color',$item->color)->where('size',$val->size)->first(); 
							$ratio=0; isset($ration) && $ration->id ? $ratio=$ration->ratio : $ratio=0;
							$qty=0; isset($ration) && $ration->id ? $qty=$ration->qty : $qty=0;
							
							$color_ttl += $ratio;
							$size_ttl += $qty;
							$ttl += $ratio;
							$ttl_qty += $qty;
							$r++;
							$a[$r]= isset($a[$r]) ? $a[$r] + $ratio: 0+$ratio;
							$b[$r]= isset($b[$r]) ? $b[$r] + $qty: 0+$qty;
						?>
                        	<th >{{ $ratio }} ---- {{ $qty }}</th>
                        @endforeach
                        <th >{{ $color_ttl }} ---- {{ $size_ttl }}</th>
                    </tr>
                    @endforeach
                    <tr>
                    	<td class="ttl text-right">Total</td>
                        <?php 
							for($k=1; $k<$sc+1; $k++){ ?>
                        	<td>{{ $a[$k] }} ---- {{ $b[$k] }} <?php $a[$k]=''; $b[$k]='';?></td>
                         <?php } ?>
                         <td class="ttl">{{ $ttl }} ---- {{ $ttl_qty }}</td>
                    </tr>
                </tbody>
            </table>
                @endforeach

        </div><!-- /.box-header -->                    
        <div>
        
        <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Color And Size Breakdown Entry</h4>
      </div>
      {!! Form::open(['route' => 'podetails.store', 'class' => 'form-horizontal podetails']) !!}
      {!! Form::hidden('flag', 'modal', ['class' => 'form-control', 'required']) !!}
      <div class="modal-body">
      <table>
                       <tr>
                           <td colspan="2">
                                <div class="form-group">
                                    {!! Form::label('port_id', $langs['port_id'], ['class' => 'control-label']) !!}
                                    <div class=""> 
                                        {!! Form::select('port_id', $ports, null, ['class' => 'form-control', 'required']) !!}
                                    </div>    
                                </div>
                           </td>
                           <td>-</td>
                           <td colspan="2">
                                <div class="form-group">
                                    {!! Form::label('port_qty', $langs['port_qty'], ['class' => 'control-label']) !!}
                                    <div class=""> 
                                        {!! Form::text('port_qty', null, ['class' => 'form-control', 'required']) !!}
                                    </div>    
                                </div>
                           </td>
                           <td colspan="2">
                                <div class="form-group">
                                    {!! Form::label('shipment_date', $langs['shipment_date'], ['class' => 'control-label']) !!}
                                    <div class=""> 
                                        {!! Form::text('shipment_date', null, ['class' => 'form-control', 'required']) !!}
                                    </div>    
                                </div>
                           </td>
                       <tr>
                       	<th>Color/Size</th>
                        <?php for($n=1; $n <$sc+1; $n++ ){?>
                        <td>{!! Form::text('size[]', '', ['class' => 'form-control', 'required']) !!}</td>
                        <?php }?>
                       </tr>
					   
					   <?php
					   for ($i=1; $i< $cc+1; $i++){
					   ?>
                       <tr>
                       <td>
                       <div class="form-group">
                            <div class="col-sm-12"> 
                                {!! Form::text('color[]', null, ['class' => 'form-control', 'required']) !!}
                                {!! Form::hidden('color_sl[]', $i, ['class' => 'form-control', 'required']) !!}
                            </div>    
                        </div>
                        </td>
                        	<?php for ($j=1; $j<$sc+1; $j++){ ?>
                        <td>
                            <div class="form-group">
                                <div class="col-sm-12"> 
                                    {!! Form::text('ratio'.$i.$j, $j, ['class' => 'form-control', 'required']) !!}
                                    {!! Form::hidden('size'.$i.$j, $j, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>
                            </td>
                            <?php }?>
                            </tr>
                        <?php }?>
      </table>
      </div>
      <div class="modal-footer">
      <div class="form-group col-sm-12 pul-right">
        <div class="form-group col-sm-2">
            <div class="">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>    
        </div>
        <div class="form-group col-sm-3">
            <div class="">
                {!! Form::submit($langs['create'], ['class' => 'btn btn-primary form-control']) !!}
                {!! Form::hidden('pm_id', $pomaster->id , ['class' => 'form-control', 'required']) !!}
                {!! Form::hidden('bd_id', $ratio_id , ['class' => 'form-control', 'required']) !!}
				{!! Form::text('breakdown_id', $breakdown_id , ['class' => 'form-control', 'required']) !!}
                {!! Form::hidden('pono', $pomaster->pono , ['class' => 'form-control', 'required']) !!}
               	{!! Form::hidden('jobno', $pomaster->jobno , ['class' => 'form-control', 'required']) !!}
            </div>    
        </div>
        </div>
      </div>
      {!! Form::close() !!}        
    </div>
  </div>
</div>
        
        
        
        
        </div>

    </div>
@endsection
@section('custom-scripts')

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".podetails").validate();
		$( "#po_rcvd_date" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		$( "#factory_ship_date" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		$( "#shipment_date" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
