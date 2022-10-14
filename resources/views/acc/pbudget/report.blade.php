@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Trandetail')

@section('contentheader_title', ' Project Planning Budget')
@section('main-content')

 <div class="container">
 <div class="box" >
    <div class="table-responsive">
        <div class="box-header">
            <a href="{{ url('pplanning/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('pplanning/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('pplanning/pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('pplanning/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('pplanning/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('pplanning/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
        <table class="table borderless">
        <?php 
			// data collection filter method by session	
			$data=array('pro_id'=>'');

			Session::has('bpro_id') ? 
			$data=array('pro_id'=>Session::get('bpro_id')) : ''; 

			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 
			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h1 align="center" style="margin:0px">'.$com_name.'</h1></td></tr>
			<tr><td colspan="2"><h4 align="center" style="margin:0px">Project Planning Budget Report</h4></td></tr>';
			
		?>
        </table>
        </div><!-- /.box-header -->

            <table id="buyerinfo-table" class="table table-bordered">
                <thead>
                <tr><td colspan="6"><a href="{!! url('/pbudget/report?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'pbudget/filter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('pro_id', $langs['pro_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('pro_id', $projects, null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-3">
                                {!! Form::submit($langs['find'], ['class' => 'btn btn-primary form-control']) !!}
                                </div>    
                            </div>
                          {!! Form::close() !!}
                     @endif
               </td></tr>
                    <tr>
                        <th class="col-md-1 text-center">{{ $langs['sl'] }}			</th>
                        <th class="col-md-4">{{ $langs['segment'] }}		</th>
                        <th class="col-md-2">{{ $langs['prod_id'] }}		</th>
                        <th class="col-md-1 ">{{ $langs['qty'] }}	</th>
                        <th class="col-md-1 ">{{ $langs['rate'] }}	</th>
                        <th class="col-md-1 ">{{ $langs['bamount'] }}	</th>
                        <th class="col-md-1 ">Actual Cost</th>
                        <th class="col-md-1 ">Difference</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
				<?php
                	Session::has('ppro_id') ? 
					$project=DB::table('acc_projects')->where('com_id',$com_id)->where('id',$data['pro_id'])->get()	:'';
				?>
				@foreach($project as $item)
				<?php 
					$pplanning=DB::table('acc_pplannings')->where('pro_id',$item->id)->where('group_id',0)->get();
				?>
                	<tr><td colspan="5">{{$item->name }}</td></tr>
                        @foreach($pplanning as $item)
                        {{-- */$x++;/* --}}
                        <tr>
                                <td width="50" class="text-center">{{ $x }}</td>
                                <td style="padding-left:30px">{{ $item->segment }}	</td>
                                <td></td>
                                <td></td>
                                <td></td>
                         </tr>
							<?php 
                                $pplanning=DB::table('acc_pplannings')->where('group_id',$item->id)->where('pro_id', $item->pro_id)->get();
                            ?>
                                    @foreach($pplanning as $item)
                                    {{-- */$x++;/* --}}
                                    <tr>
                                            <td width="50" class="text-center">{{ $x }}</td>
                                            <td style="padding-left:60px">{{ $item->segment }}	</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                     </tr>
                                     {{-- */$y=0;/* --}}
                                     <?php $record=DB::table('acc_pbudgets')->where('pro_id',$item->pro_id)->where('seg_id',$item->id)->get(); ?>
                                            @foreach($record as $item)
                                            {{-- */$y++;/* --}}
                                            <?php 
												$product=DB::table('acc_products')->where('com_id',$com_id)->where('id',$item->prod_id)->first();
												$product_name=''; isset($product) && $product->id > 0 ?  $product_name=$product->name : $product_name='';

												$unit=DB::table('acc_units')->where('id',$item->unit_id)->first();
												$unit_name=''; isset($unit) && $unit->id > 0 ?  $unit_name=$unit->name : $unit_name='';												

												$currency=DB::table('acc_currencies')->where('id',$item->cur_id)->first();
												$currency_name=''; isset($currency) && $currency->id > 0 ?  $currency_name=$currency->name : $currency_name='';	
												$amount='';$amounts=''; $product_amounts='';
												if ($item->qty > 0 && $item->rate > 0 ):
													$amount=$item->qty * $item->rate ;
												endif;	
												$amount> 0 ? $amounts=number_format($amount,2) : '';	
												$diff=''; $diffs='';
												
												$product=DB::table('acc_trandetails')->where('com_id',$com_id)->where('prod_id',$item->prod_id)->groupBy('prod_id')->sum('amount');									
												$product_amount=''; isset($product) && $product > 0 ?  $product_amount=$product : $product_amount='';	
												$diff=$amount-$product_amount;
												
												$product_amount > 0 ? $product_amounts=number_format($product_amount,2): '';
												$diff > 0 ? $diffs=number_format($diff, 2) : '';
											?>
                                             <tr>
                                                    <td width="50" class="text-center"></td>
                                                    <td class="text-right">{{ $y }}</td>
                                                    <td>{{ $product_name }}</td>
                                                    <td>{{ $item->qty.' ('.$unit_name .')' }}	</td>
                                                    <td>{{ $item->rate.' ('.$currency_name .')' }}	</td>
                                                    <td class="text-right">{{ $amounts }}	</td>
                                                    <td class="text-right">{{ $product_amounts}}	</td>
                                                    <td class="text-right">{{ $diffs }}</td>
                                             </tr>	
                                            	
                                            @endforeach 
                                    @endforeach 
                        @endforeach 
                @endforeach 
                        <tr><td colspan="3" class="text-right"></td><td class="text-right"></td></tr>             

                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Project->Report</td><td class="text-right">Report generated by: </td></tr>
                </table>
            </div><!-- /.box-header -->
        </div>
     </div>
</div>
@endsection

@section('custom-scripts')

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".trandetail").validate();
		$( "#dfrom" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
        $( "#dto" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
