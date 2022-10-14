@extends('app')

@section('htmlheader_title', $langs['edit'] . ' Trandetail')

@section('contentheader_title', ' Budget')
@section('main-content')

 <div class="container">
 <div class="box" >
    <div class="table-responsive">
        <div class="box-header">
            <a href="{{ url('budget/budget_print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('budget/budger_pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('budget/budget_pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('budget/budget_excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('budger/budget_csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('budget/budget_word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>
        <table class="table borderless">
        <?php 
			// data collection filter method by session	
			$data=array('bname'=>'','btype'=>'','byear'=>'');
			
			Session::has('bname') ? 
			$data=array('bname'=>Session::get('bname'),'btype'=>Session::get('btype'),'byear'=>Session::get('byear')) : ''; 

			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 
			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h1 align="center" style="margin:0px">'.$com_name.'</h1></td></tr>
			<tr><td colspan="2"><h4 align="center" style="margin:0px">'.$data['btype'].' '.$data['bname'].'</h4></td></tr>';
			
			$budget_name=array(''=>'Select ...','Revenue Budget'=>'Revenue Budget',
			'Capital Budget'=>'Capital Budget','Cash Flow Budget'=>'Cash Flow Budget','Special Budget'=>'Special Budget');
			$btypes=array(''=>'Select ...', 'Monthly'=>'Monthly', 'Yearly'=>'Yearly', 'Quarterly'=>'Quarterly');
			
		?>
        </table>
        </div><!-- /.box-header -->

            <table id="buyerinfo-table" class="table table-bordered">
                <thead>
                <tr><td colspan="6"><a href="{!! url('/budget/report?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'budget/filter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('bname', $langs['bname'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('bname', $budget_name, null, ['class' => 'form-control', 'required']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('btype', $langs['btype'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('btype',  $btypes ,null, ['class' => 'form-control','id'=>'dfrom','required' ]) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('byear', $langs['byear'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('byear', array(''=>'Select ...','2015'=>'2015',
                                    '2016'=>'2016','2017'=>'2017','2019'=>'2019'),null, 
                                    ['class' => 'form-control','id'=>'dto', 'required' ]) !!}
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
                        <th class="col-md-3">{{ $langs['name'] }}		</th>
                        <th class="col-md-2">{{ $langs['btype'] }}		</th>
                        <th class="col-md-2 text-right">{{ $langs['amount'] }}	</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
				<?php 
					$ttl='';
					$data['bname']!='' ? 
					$budgets=DB::table('acc_budgets')->where('com_id',$com_id)
					->where('name',$data['bname'])->where('btype',$data['btype'])->where('byear',$data['byear'])->get() : ''; 
				?>
                        @foreach($budgets as $item)
                        {{-- */$x++;/* --}}
                        <?php
							$ttl=0;
							$coa=DB::table('acc_coas')->where('com_id',$com_id)->where('id',$item->acc_id)->first(); //echo $coa->name;
							$coa_name='';isset($coa) && $coa->id >0 ? $coa_name=$coa->name: $coa_name='';

							$ttl += $item->amount;
							$item->amount> 0 ? $amount=number_format($item->amount, 2) : $amount=''; 
                        ?>
                        <tr>
                                <td width="50" class="text-center">{{ $x }}</td>
                                <td>{{ $coa_name }}	</td>
                                <td> <a href="{{ url('budget/report?name='. $item->name . '&btype='. $item->btype) }}"> {{ $item->btype }} </a>		</td>
                                <td  class="text-right">{{ $amount }}	</td>
                         </tr>
                        @endforeach    
                        <?php $ttl!='' ? $ttls=number_format($ttl,2) : $ttls=''; ?>
                        <tr><td colspan="3" class="text-right"></td><td class="text-right">{{ $ttls }}</td></tr>             

                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Budget->Report</td><td class="text-right">Report generated by: </td></tr>
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
