@extends('app')

@section('htmlheader_title', ' Project')

@section('contentheader_title', 	  ' Project Advance')
@section('main-content')

 <div class="container">
 <div class="box" >
    <div class="table-responsive">

<?php 
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 
			Session::has('irdto') ?  $data=array('dfrom'=>Session::get('irdfrom'),'dto'=>Session::get('irdto')) : 
			$data=array('dfrom'=>date('Y-m-d'),'dto'=>date('Y-m-d')) ; 

		function project_expense($pro_id, $sh_id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;

			$afe=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Advance For Expenses')->first();
			$afe_id=''; isset($afe) && $afe->id >0 ? $afe_id=$afe->id : $afe_id='';

			$ecpense=DB::table('acc_trandetails')->where('pro_id',$pro_id)->where('sh_id',$sh_id)->where('com_id',$com_id)->where('acc_id','<>',$afe_id)->sum('amount');
			if (isset($ecpense) && $ecpense > 0 ):
				return $ecpense;
			else:
				return 0;
			endif;
		}
?>
  	<table class="table">
        <thead>
    	<tr>
        	<h3 class="text-center">Project-wise Adance and Expenditure</h3>
            <h4 class="text-center">{{$data['dfrom'].' to '.$data['dto']  }}</h4>
            </th></tr>
            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="8"><a href="{!! url('/acc-project/projectadvance?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['prod_id']) ? $data['prod_id']='' : '' ;
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'acc-project/pafilter', 'class' => 'form-horizontal']) !!}
                             <div class="form-group">
                                {!! Form::label('proj_id', $langs['proj_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('proj_id', $projects ,null, ['class' => 'form-control select2']) !!}
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
        	<th class="col-md-1">SL</th>
            <th class="col-md-2">Employee Name</th>
            <th class="col-md-2">Project Name</th>
            <th class="col-md-1 text-right">Aproject Advance</th>
            <th class="col-md-1 text-right">Project Expense</th>
            <th class="col-md-1 text-right">Balance</th>
        </tr>
		<tbody>
                  {{-- */$x=0;/* --}}
                    @foreach($advance as $item)
                    {{-- */$x++;/* --}}
        <?php 
		
		$expense=project_expense($item->pro_id,$item->sh_id);
		$balance=$item->amount-$expense;
		?>
        <tr>
        	<td>{{ $x}}</td>
            <td>{{ isset($item->subhead->name) ? $item->subhead->name : '' }}</td>
            <td class="">{{ isset($item->project->name) ? $item->project->name : '' }}</td>
            <td class="text-right">{{ $item->amount> 0 ? number_format($item->amount) : '' }}</td>
            <td class="text-right">{{ $expense > 0 ?  number_format($expense) : '' }}</td>
            <td class="text-right">{{ $balance > 0 ? number_format($balance) : '' }}</td>
        </tr>
        
        @endforeach
        </tbody>
        </thead>
    </table>  
    
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
