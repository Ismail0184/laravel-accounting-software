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
                        <th class="col-md-2">{{ $langs['segment'] }}		</th>
                        <th class="col-md-3">{{ $langs['stdate'] }}		</th>
                        <th class="col-md-3 ">{{ $langs['cldate'] }}	</th>
                        <th class="col-md-1 ">{{ $langs['bamount'] }}	</th>
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
                                <td>{{ $item->stdate }}</td>
                                <td>{{ $item->cldate }}	</td>
                                <td>{{ $item->bamount }}	</td>
                         </tr>
							<?php 
                                $pplanning=DB::table('acc_pplannings')->where('group_id',$item->id)->where('pro_id', $item->pro_id)->get();
                            ?>
                                    @foreach($pplanning as $item)
                                    {{-- */$x++;/* --}}
                                    <tr>
                                            <td width="50" class="text-center">{{ $x }}</td>
                                            <td style="padding-left:60px">{{ $item->segment }}	</td>
                                            <td>{{ $item->stdate }}</td>
                                            <td>{{ $item->cldate }}	</td>
                                            <td>{{ $item->bamount }}	</td>
                                     </tr>
                                     <?php $record=DB::table('acc_pbudgets')->where('pro_id',$item->pro_id)->where('seg_id',$item->id)->get(); ?>
                                            @foreach($record as $item)
                                            	{{ $item->pro_id }}
                                            	
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
