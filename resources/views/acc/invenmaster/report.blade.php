@extends('app')

@section('htmlheader_title', 'Stock Balance')

@section('contentheader_title', 	  ' Stock Balance 3')
@section('main-content')

<style>
    table.borderless td,table.borderless th{
     border: none !important;
	}

	h1{
		font-size: 1.6em;
	}
	h5{
		font-size: 1.2em; margin:0px
	}
	#unit {width: 10px} 
	#cur {width: 10px}
</style>
<?php 

		function op_balance($id, $idate,$war_id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$war_id>0 ? $where=array('war_id'=>$war_id): $where=array();
			$stock=DB::table('acc_invendetails')->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
			->where('idate','<',$idate)->where('acc_invenmasters.com_id',$com_id)->where('item_id',$id)->where($where)->sum('qty');
			if (isset($stock) ):
				return $stock;
			else:
				return 0;
			endif;
		}
		function cl_balance($id, $idate,$war_id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$war_id>0 ? $where=array('war_id'=>$war_id): $where=array();
			$stock=DB::table('acc_invendetails')->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
			->where('idate','<=',$idate)->where('acc_invenmasters.com_id',$com_id)->where('item_id',$id)->where($where)->sum('qty');
			if (isset($stock) ):
				return $stock;
			else:
				return 0;
			endif;
		}
		function rcvd($id, $dfrom,$dto,$war_id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$war_id>0 ? $where=array('war_id'=>$war_id): $where=array();
			$stock=DB::table('acc_invendetails')->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
			->whereBetween('acc_invenmasters.idate', [$dfrom, $dto])
			->where('qty','>',0)->where($where)
			->where('acc_invenmasters.com_id',$com_id)
			->where('item_id',$id)->sum('qty');
			if (isset($stock) ):
				return $stock;
			else:
				return 0;
			endif;
		}
		function issue($id, $dfrom,$dto,$war_id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$war_id>0 ? $where=array('war_id'=>$war_id): $where=array();
			$stock=DB::table('acc_invendetails')->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
			->whereBetween('acc_invenmasters.idate', [$dfrom, $dto])
			->where('qty','<',0)->where($where)
			->where('acc_invenmasters.com_id',$com_id)
			->where('item_id',$id)->sum('qty');
			if (isset($stock) ):
				return $stock;
			else:
				return 0;
			endif;
		}
		function has($id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$stock=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$id)->sum('qty');
			if (isset($stock) ):
				return $stock;
			else:
				return 0;
			endif;
		}

 ?>
 <div class="container">
 <div class="box" >
 <div class="box" >
         <div class="box-header">
        <a href="{{ url('invenmaster/report_print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
        </div><!-- /.box-header -->

    <div class="table-responsive">
        <table  width="100%>
        <?php 
			isset($_GET['item_id']) && $_GET['item_id']>0 ? Session::put('lgprod_id',$_GET['item_id']) : '';
			
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 


			Session::has('rtdto') ?  $data=array('wh_id'=>Session::get('rtwh_id'),'dfrom'=>Session::get('rtdfrom'),'dto'=>Session::get('rtdto')) : 
			$data=array('wh_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00') ; 
			
			$wh=DB::table('acc_warehouses')->where('id',$data['wh_id'])->first(); $com_name=''; 
			isset($wh) && $wh->id>0 ? $wh_name='('.$wh->name.')' : $wh_name='';

			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h1 align="center">'.$com_name.'</h1></td></tr>';
			// data collection filter method by session	
			
		
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h5>Stock Balance '.$wh_name.'</h5><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
		?>
        
        </table>

            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="7"><a href="{!! url('/invenmaster/report?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['prod_id']) ? $data['prod_id']='' : '' ;
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'invenmaster/rtfilter', 'class' => 'form-horizontal']) !!}
                             <div class="form-group">
                                {!! Form::label('wh_id', $langs['wh_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('wh_id', $warehouses, null, ['class' => 'form-control select2']) !!}
                                </div>    
                            </div>
                             <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom', date('Y-m-01'), ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                             <div class="form-group">
                                {!! Form::label('dto', $langs['dto'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dto', date('Y-m-d'), ['class' => 'form-control']) !!}
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
                        <th class="text-center" width>{{ $langs['sl'] }}</th>
                        <th class="">{{ $langs['item_id'] }}</th>
                        <th class=""></th>
                        <th class="text-right">Opening</th>
                        <th class="text-right">Rcvd</th>
                        <th class="text-right">Issue</th>
                        <th class="text-right">Balance</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
				@foreach($stock as $item)
                {{-- */$x++;/* --}}
            	<tr>
                    <td width="50" class="text-center">{{ $x }}</td>
                	<td>{{ $item->name }}</td>
                    <?php  $ttl=''; 
						$opbalance=op_balance($item->item_id, $data['dfrom'],$data['wh_id'] );
						$clbalance=cl_balance($item->item_id, $data['dto'] ,$data['wh_id']);
						$rcvd=rcvd($item->item_id, $data['dfrom'],$data['dto'] ,$data['wh_id']);
						$issue=issue($item->item_id, $data['dfrom'],$data['dto'] ,$data['wh_id']);
						$issue <0 ? $issues=substr($issue,1) : $issues=$issue;
						$unit=DB::table('acc_units')->where('id',$item->unit_id)->first();
						
						$unit_name=''; isset($unit) && $unit->id >0 ? $unit_name=$unit->name : $unit_name='';
					?>
                	<td class="text-right">{{ $unit_name }}</td>
                	<td class="text-right">{{ $opbalance > 0 ? $opbalance : '' }}</td>
                	<td class="text-right">{{ $rcvd > 0 ? $rcvd : '' }}</td>
                	<td class="text-right">{{ $issues> 0 ?  $issues : '' }}</td>
                	<td class="text-right">{{ $clbalance }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Inventory->Stock Balance</td><td class="text-right">Report generated by: {{ Auth::user()->name }}</td></tr>
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
