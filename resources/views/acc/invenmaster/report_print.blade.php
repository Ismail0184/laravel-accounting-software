@extends('print')

@section('htmlheader_title', 'Stock Balance')

@section('contentheader_title', 	  ' Stock Balance')
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
	.tables { font-size:10px}
	.rpt { font-size:12px}
	.cname { font-size:16px}

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
        <table  width="100%" class="tables">
        <?php 
			isset($_GET['item_id']) && $_GET['item_id']>0 ? Session::put('lgprod_id',$_GET['item_id']) : '';
			
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 




			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h1 align="center" class="cname">'.$com_name.'</h1></td></tr>';
			// data collection filter method by session	
			
			Session::has('rtdto') ?  $data=array('wh_id'=>Session::get('rtwh_id'),'dfrom'=>Session::get('rtdfrom'),'dto'=>Session::get('rtdto')) : 
			$data=array('wh_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00') ; 
		
				// for multiple account
				echo '<tr><td class="text-center rpt" colspan="2"><h5>Stock Balance</h5><h5 class="rpt">'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
		?>
        
        </table>

            <table id="buyerinfo-table" class="table table-bordered table-striped tables">
                <thead>
                    <tr>
                        <th class="text-center" width>{{ $langs['sl'] }}</th>
                        <th class="">{{ $langs['item_id'] }}</th>
                        <th class=""></th>
                        <th class="">Opening</th>
                        <th class="">Rcvd</th>
                        <th class="">Issue</th>
                        <th class="">Balance</th>
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
                	<td>{{ $unit_name }}</td>
                	<td>{{ $opbalance }}</td>
                	<td>{{ $rcvd }}</td>
                	<td>{{ $issues }}</td>
                	<td>{{ $clbalance }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr class="rpt"><td class="text-left">Source: Export->Buyer</td><td class="text-right">Report generated by: </td></tr>
                </table>
            </div><!-- /.box-header -->
@endsection

