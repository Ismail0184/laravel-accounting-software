@extends('app')

@section('htmlheader_title', ' Inventory')

@section('contentheader_title', 	  ' Rcvd and Issue')
@section('main-content')

 <div class="container">
 <div class="box" >
    <div class="table-responsive">

<?php 
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 
			Session::has('irdto') ?  $data=array('dfrom'=>Session::get('irdfrom'),'dto'=>Session::get('irdto')) : 
			$data=array('dfrom'=>date('Y-m-d'),'dto'=>date('Y-m-d')) ; 

?>
  	<table class="table">
        <thead>
    	<tr>
        	<h3 class="text-center">Daily Transaction</h3>
            <h4 class="text-center">{{$data['dfrom'].' to '.$data['dto']  }}</h4>
            </th></tr>
            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="8"><a href="{!! url('/invenmaster/rcvdissue?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['prod_id']) ? $data['prod_id']='' : '' ;
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'invenmaster/irfilter', 'class' => 'form-horizontal']) !!}
                             <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom', $data['dfrom'], ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                             <div class="form-group">
                                {!! Form::label('dto', $langs['dto'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dto', $data['dto'], ['class' => 'form-control']) !!}
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
        	<th class="col-md-1">Date</th>
            <th class="col-md-3">Product</th>
            <th class="col-md-2">Client</th>
            <th class="col-md-1">Type</th>
            <th class="col-md-1 text-right">Quantity</th>
            <th class="col-md-1 text-right">Rate</th>
            <th class="col-md-1 text-right">Amount</th>
            <th class="col-md-2">Warehouse</th>
        </tr>
		<tbody>
        @foreach($invendetail as $item)
        <?php 
		
		$client=DB::table('acc_clients')->where('id',$item->client_id)->first();						
		isset($client) && $client->id > 0 ? $cleint_name=' '.$client->name : $cleint_name=''; 

		$wh=DB::table('acc_warehouses')->where('id',$item->war_id)->first(); //echo $item->war_id;						
		$wh_name=''; isset($wh) && $wh->id > 0 ? $wh_name=$wh->name : $wh_name=''; //echo $wh_name;

		isset($item->product->unit_id) ? $unit=DB::table('acc_units')->where('id',$item->product->unit_id)->first() : '';						
		$unit_name=''; isset($unit) && $unit->id > 0 ? $unit_name=$unit->name : $unit_name='';

		$item->for>0 ? $ttype=DB::table('acc_ittypes')->where('id',$item->for)->first() : '';						
		$ttype_name=''; isset($ttype) && $ttype->id > 0 ? $ttype_name=$ttype->name : $ttype_name='';

		?>
        <tr>
        	<td><a href="{{ url('/invenmaster/invoice?flag='. $item->id) }}">{{ $item->idate }}/{{ $item->vnumber }}</a></td>
            <td>{{ isset($item->product->name) ? $item->product->name : '' }}</td>
            <td>{{ $cleint_name }}</td>
            <td>{{ $item->itype }} {{ strlen($item->for)>0 ? '/'.$ttype_name : ''  }} </td>
            <td class="text-right">{{ $item->qty < 0 ? substr($item->qty,1) : $item->qty }} {{ $unit_name }}</td>
            <td class="text-right">{{ $item->rate }}</td>
            <td class="text-right">{{ $item->amount }}</td>
            <td>{{ $wh_name }}</td>
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
