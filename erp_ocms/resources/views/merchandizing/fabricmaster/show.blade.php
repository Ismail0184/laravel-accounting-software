@extends('app')

@section('htmlheader_title', 'Fabricmaster')

@section('contentheader_title', 'Color and Size Wise Configuration')

@section('main-content')
<style>
	.box-footer { background-color:#9CF; width:90%; margin-left:5%}
	.modal-dialog {
  width: 96%; /* or whatever you wish */
}
	.modal-content {
  overflow-x: scroll/* or whatever you wish */
}
 . width { width:200px; background-color:#9C9}
 .clc { width:500px;}
 .cl { width:100px}
 .form-control { width:150px}
 .select2 { width:250px}
 .colsize { width:100px;}
 .box-footer { overflow-x: scroll}
 .vertical-align {vertical-align:middle;}
</style>
<?php 
	use App\Models\merchandizing\Fabricdetails; 
	use App\Models\merchandizing\Pomasters; 
	Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
	Session::has('jobno') ?  $jobno=Session::get('jobno') : $jobno='';
	Session::has('booking_id') ?  $booking_id=Session::get('booking_id') : $booking_id='';


	$flag=DB::table('merch_fabricdetails')->where('fm_id',$fabricmaster->id)->first(); 
	$elasten=array('1'=>'yes','2'=>'No');
?>

    <div class="box">
        <div class="box-header">
        	<h3 class="text-center" style="margin:0px; padding:0px"> Job No: {{ $fabricmaster->jobno }} / Booking No: {{ $fabricmaster->booking_id }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="fabricmaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-right col-sm-2">{{ $langs['dia_sl'] }}</th><td>{{ $fabricmaster->dia_sl }}</td>
                        <th class="text-right col-sm-2">{{ $langs['gtype_id'] }}</th> <td>@if(isset($fabricmaster->gtype->name)){{ $fabricmaster->gtype->name }}@endif</td>
                        <th class="text-right col-sm-2">{{ $langs['pogarment_id'] }}</th><td>@if(isset($fabricmaster->pogarment->name)){{ $fabricmaster->pogarment->name }}@endif</td>
                        <th class="text-right col-sm-2">{{ $langs['gsm_id'] }}</th><td>@if(isset($fabricmaster->gsm->name)){{ $fabricmaster->gsm->name }}@endif</td>
                    </tr><tr>
                        <th class="text-right">{{ $langs['diatype_id'] }}</th><td>@if(isset($diatypes[$fabricmaster->diatype_id])){{ $diatypes[$fabricmaster->diatype_id] }}@endif</td>
                        <th class="text-right">{{ $langs['dia_id'] }}</th><td>@if(isset($fabricmaster->dia->name)){{ $fabricmaster->dia->name }}@endif</td>
                        <th class="text-right">{{ $langs['structure_id'] }}</th><td>@if(isset($fabricmaster->structure->name)){{ $fabricmaster->structure->name }}@endif</td>
                        <th class="text-right">{{ $langs['elasten'] }}</th><td>{{ $fabricmaster->elasten }}</td>
                    </tr><tr>
                        <th class="text-right">{{ $langs['lycraratio_id'] }}</th><td>@if(isset($fabricmaster->lycraratio->name)){{ $fabricmaster->lycraratio->name }}@endif</td>
                        <th class="text-right">{{ $langs['fcomposition'] }}</th><td>{{ $fabricmaster->fcomposition }}</td>
                       	<th class="text-right">{{ $langs['ftype_id'] }}</th><td>@if(isset($fabricmaster->ftype->name)){{ $fabricmaster->ftype->name }}@endif</td>
                        <th class="text-right">{{ $langs['ydrepeat'] }}</th><td>{{ $fabricmaster->ydrepeat }}</td>
                    </tr><tr>
                        <th class="text-right">{{ $langs['ydstripe_id'] }}</th><td>@if(isset($fabricmaster->ydstripe->name)){{ $fabricmaster->ydstripe->name }}@endif</td>
                        <th class="text-right">{{ $langs['ytype_id'] }}</th><td>@if(isset($fabricmaster->ytype->name)){{ $fabricmaster->ytype->name }}@endif</td>                        
                        <th class="text-right">{{ $langs['ycount_id'] }}</th><td>@if(isset($fabricmaster->ycount->name)){{ $fabricmaster->ycount->name }}@endif</td>
                        <th class="text-right">{{ $langs['yconsumption_id'] }}</th><td>@if(isset($fabricmaster->yconsumption->name)){{ $fabricmaster->yconsumption->name }}@endif</td>
					</tr><tr>
                        <th class="text-right">{{ $langs['aop_id'] }}</th><td>@if(isset($fabricmaster->aop->name)){{ $fabricmaster->aop->name }}@endif</td>
                        <th class="text-right">{{ $langs['finishing_id'] }}</th><td>@if(isset($fabricmaster->finishing->name)){{ $fabricmaster->finishing->name }}@endif</td>
						<th class="text-right">{{ $langs['washing_id'] }}</th><td>@if(isset($fabricmaster->washing->name)){{ $fabricmaster->washing->name }}@endif</td>
						<th class="text-right">{{ $langs['ccuff_id'] }}</th><td>@if(isset($fabricmaster->ccuff->name)){{ $fabricmaster->ccuff->name }}@endif</td>
					</tr><tr>
                        <th class="text-right">Mes.{{ $langs['unit_id'] }}</th><td>@if(isset($fabricmaster->unit->name)){{ $fabricmaster->unit->name }}@endif</td>
                        <th class="text-right">{{ $langs['consumption'] }}</th><td>{{ $fabricmaster->consumption }}</td>
						<th class="text-right">{{ $langs['wastage'] }}</th><td>{{ $fabricmaster->wastage }}</td>
						<th class="text-right"></th><td></td>
					</tr><tr>
                    	<th></th><th></th><th></th>
                        <th class="text-right"></th><td>
                        @if(!isset($flag))
                        	<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Color and Size </button></td>
						@endif
                    </tr>
                </thead>
            </table>
        </div>
        <div class="box-footer">
        <table class="table table-bordered">
        @foreach($fabricdetails as $item)
                <thead>
                	<tr>
                    	<td colspan="18"><h3 class="text-center" style="padding:0px; margin:0px">PO No: {{ $item->pono }}</h3></td>
                    </tr>
                    <tr>
                        <th class="colsize">{{ $langs['color'] }}</th>
                        <th class="colsize">{{ $langs['dia_id'] }}</th>
                        <th class="colsize">{{ $langs['gsm_id'] }}</th>
                        <th class="colsize">{{ $langs['consumption'] }}</th>
                        <th class="colsize">{{ $langs['wastage'] }}</th>
                        <th class="colsize">{{ $langs['gfabric'] }}</th>
                        <th class="colsize">{{ $langs['loss'] }}</th>
                        <th class="colsize">{{ $langs['ffabric'] }}</th>
                        <th class="colsize">{{ $langs['ftype_id'] }}</th>
                        <th class="colsize">{{ $langs['fcomposition'] }}</th>
                        <th class="colsize">{{ $langs['ytype_id'] }}</th>
                        <th class="colsize">{{ $langs['ycount_id'] }}</th>
                        <th class="colsize">{{ $langs['yconsumption_id'] }}</th>
                        <th class="colsize">{{ $langs['elasten'] }}</th>
                        <th class="colsize">{{ $langs['lycraratio_id'] }}</th>
                        <th class="colsize">{{ $langs['ydrepeat'] }}</th>
                        <th class="colsize">{{ $langs['ydstripe_id'] }}</th>
                        <th class="colsize">{{ $langs['washing_id'] }}</th>
                        <th class="colsize">{{ $langs['finishing_id'] }}</th>
                        <th class="colsize">{{ $langs['ccuff_id'] }}</th>
                        <th class="colsize">{{ $langs['aop_id'] }}</th>
                        <th class="colsize"></th>
                    </tr>
                </thead>
                <tbody>

                <?php 
				$podetail=Fabricdetails::select('merch_fabricdetails.*')->join('merch_pomasters', function($join)
				{
					$join->on('merch_fabricdetails.pono', '=', 'merch_pomasters.pono')
						->On('merch_fabricdetails.jobno', '=', 'merch_pomasters.jobno')
						->On('merch_fabricdetails.com_id', '=', 'merch_pomasters.com_id')
					    ->On('merch_fabricdetails.breakdown_id', '=', 'merch_pomasters.breakdown_id');
				})->where('merch_fabricdetails.jobno',$item->jobno)
				->where('merch_fabricdetails.pono',$item->pono)->where('merch_fabricdetails.dia_sl',$item->dia_sl)
				->groupBy('merch_fabricdetails.color')->get();
                ?>
				@foreach($podetail as $item)
                	<?php 
						$port=DB::table('merch_ports')->where('id', $item->port_id)->first();
						$port_name=''; isset($port) && $port->id > 0 ? $port_name=$port->name : $port_name='';
					?>
                    <tr>
                        <td>{{ $item->color }}</td>
                        <td>@if(isset($item->dia->name)){{ $item->dia->name }}@endif / @if(isset($diatypes[$fabricmaster->diatype_id])){{ $diatypes[$fabricmaster->diatype_id] }}@endif</td>
                        <td>@if(isset($item->gsm->name)){{ $item->gsm->name }}@endif</td>
                        <td>{{ $item->consumption }}</td>
                        <td>{{ $item->wastage }}</td>
                        <td>{{ $item->gfabric }}</td>
                        <td>{{ $item->loss }}</td>
                        <td>{{ $item->ffabric }}</td>
                        <td>@if(isset($item->ftype->name)){{ $item->ftype->name }}@endif</td>
                        <td>@if(isset($item->fcomposition)){{ $item->fcomposition }}@endif</td>
                        <td>@if(isset($item->ytype->name)){{ $item->ytype->name }}@endif</td>
                        <td>@if(isset($item->yconsumption->name)){{ $item->yconsumption->name }}@endif</td>
                        <td>@if(isset($item->ycount->name)){{ $item->ycount->name }}@endif</td>
                        <td>{{ $elasten[$item->elasten] }}</td>
                        <td>@if(isset($item->lycraratio->name)){{ $item->lycraratio->name }}@endif</td>
                        <td>{{ $item->ydrepeat }}</td>
                        <td>@if(isset($item->ydstripe->name)){{ $item->ydstripe->name }}@endif</td>
                        <td>@if(isset($item->washing->name)){{ $item->washing->name }}@endif</td>
                        <td>@if(isset($item->finishing->name)){{ $item->finishing->name }}@endif</td>
                        <td>@if(isset($item->ccuff->name)){{ $item->ccuff->name }}@endif</td>
                        <td>@if(isset($item->aop->name)){{ $item->aop->name }}@endif</td>
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('fabricdetail.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                    </tr>
                @endforeach
                </tbody>
       @endforeach
        </table>
        </div><!-- /.box-header -->
    </div>
    
	<?php 
		$sc=4;  
		$cc=3; 
	?>
    
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Color And Size Breakdown Entry</h4>
      </div>
      {!! Form::open(['route' => 'fabricdetail.store', 'class' => 'form-horizontal podetails']) !!}
      {!! Form::hidden('flag', 'modal', ['class' => 'form-control']) !!}
      <div class="modal-body">
      <div class="width">
      <table class="table">
 					   <?php
					   foreach($ponos as $color):
					   	$records=Pomasters::where('com_id',$com_id)->where('jobno',$jobno)->where('port_id',$color->port_id)->groupBy('color')->get();
					   ?>
                       <tr>
                       	<th class="clc">Color Name</th>
                        <th>{{ $langs['diatype_id']}}</th>
                        <th>{{ $langs['dmu_id']}}</th>
                        <th>{{ $langs['dia_id']}}</th>
                        <th>{{ $langs['gsm_id']}}</th>
                        <th>{{ $langs['structure_id']}}</th>
                        <th>{{ $langs['noyarn']}}</th>
                        <th>{{ $langs['elasten']}}</th>
                        <th>{{ $langs['lycraratio_id']}}</th>
                        <th>{{ $langs['fcomposition']}}</th>
                        <th>{{ $langs['ftype_id']}}</th>
                        <th>{{ $langs['ydrepeat']}}</th>
                        <th>{{ $langs['ydstripe_id']}}</th>
                        <th>{{ $langs['ytype_id']}}</th>
                        <th>{{ $langs['ycount_id']}}</th>
                        <th>{{ $langs['yconsumption_id']}}</th>
                        <th>{{ $langs['aop_id']}}</th>
                        <th>{{ $langs['finishing_id']}}</th>
                        <th>{{ $langs['washing_id']}}</th>
                        <th>{{ $langs['ccuff_id']}}</th>
                        <th>{{ $langs['cprocess_id']}}</th>
                        <th>{{ $langs['unit_id']}}</th>
                        <th>{{ $langs['consumption']}}/Dz</th>
                        <th>{{ $langs['wastage']}}</th>
                        <th>{{ $langs['loss']}}</th>
                       </tr>
                       <tr>
                           <td colspan="18">
                           @if(isset($color->port->name)){{ $color->port->name }}@endif
                           </td>
                       </tr>
                        @foreach($records as $color):
                       <tr >
                       <td class="clc">
                                   {!! Form::text('color[]', $color->color, ['class' => 'form-control']) !!}
                                   {!! Form::hidden('pono[]', $color->pono, ['class' => 'form-control']) !!}
                                   {!! Form::hidden('dia_sl', $fabricmaster->dia_sl, ['class' => 'form-control']) !!}
                                   {!! Form::hidden('breakdown_id[]', $color->breakdown_id, ['class' => 'form-control']) !!}
                                   {!! Form::hidden('fm_id', $fabricmaster->id, ['class' => 'form-control']) !!}
                                   
                       </td><td class="cl">
                                    {!! Form::select('diatype_id[]', $diatypes, $fabricmaster->diatype_id, ['class' => 'form-control']) !!}
                      </td><td class="cl">
                                    {!! Form::select('dmu_id[]', array(''=>'Select ...','1'=>'Inch', '2'=>'CM'), $fabricmaster->dmu_id, ['class' => 'form-control']) !!}
                      </td><td class="cl">
                                    {!! Form::select('dia_id[]', $dias, $fabricmaster->dia_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('gsm_id[]', $gsms, $fabricmaster->gsm_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('structure_id[]', $structures, $fabricmaster->structure_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('noyarn[]', array(''=>'Select ...','1'=>'1','2'=>'2','3'=>3,'4'=>4), $fabricmaster->noyarn, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('elasten[]', array(''=>'Select ...','1'=>'Yes','2'=>'No'), $fabricmaster->elasten, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('lycraratio_id[]', $lycraratios, $fabricmaster->lycraratio_id, ['class' => 'form-control']) !!}
                      </td><td class="cl">
                                    {!! Form::text('ydrepeat[]', $fabricmaster->ydrepeat, ['class' => 'form-control']) !!}
                      </td><td class="cl">
                                    {!! Form::select('ydstripe_id[]', $ydstripes, $fabricmaster->ydstripe_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('fcomposition[]', array(''=>'Select ...','Simple'=>'Simple','Critical'=>'Critical','Complex'=>'Complex'), $fabricmaster->fcomposition, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('ftype_id[]', $ftypes, $fabricmaster->ftype_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('ytype_id[]', $ytypes, $fabricmaster->ytype_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('ycount_id[]', $ycounts, $fabricmaster->ycount_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('yconsumption_id[]', $yconsumptions, $fabricmaster->yconsumption_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('aop_id[]', $aops, $fabricmaster->aop_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('finishing_id[]', $finishings, $fabricmaster->finishing_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('washing_id[]', $washings, $fabricmaster->washing_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('ccuff_id[]', $ccuffs, $fabricmaster->ccuff_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('cprocess_id[]', array(), '', ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::select('unit_id[]', $units, $fabricmaster->unit_id, ['class' => 'form-control ']) !!}
                      </td><td class="cl">
                                    {!! Form::text('consumption[]', $fabricmaster->consumption, ['class' => 'form-control']) !!}
                     </td><td class="cl">
                                    {!! Form::text('wastage[]', $fabricmaster->wastage, ['class' => 'form-control']) !!}
                     </td><td class="cl">
                                    {!! Form::text('loss[]', $fabricmaster->loss, ['class' => 'form-control']) !!}
                      </td></tr>       
                        @endforeach
                        <?php endforeach; ?>
      </table>
      </div>
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
                {!! Form::hidden('jobno', $fabricmaster->jobno , ['class' => 'form-control', ]) !!}
                {!! Form::hidden('booking', $fabricmaster->booking_id , ['class' => 'form-control', ]) !!}

            </div>    
        </div>
        </div>
      </div>
      {!! Form::close() !!}        
    </div>
  </div>
</div>

@endsection
