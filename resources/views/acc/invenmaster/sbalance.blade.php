@extends('app')

@section('htmlheader_title', 'Stock Balance')

@section('contentheader_title', 	  ' Stock Balance 2')
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
		function fld_value($id, $idate, $war_id){
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;
			$stock=DB::table('acc_invendetails')->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
			->where('acc_invenmasters.com_id',$com_id)->where('item_id',$id)->where('idate','<=',$idate)->where('war_id', $war_id)->sum('qty');
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
        <a href="{{ url('invenmaster/sbalance_print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
        </div><!-- /.box-header -->

    <div class="table-responsive">
        <table  width="100%>
        <?php 
			isset($_GET['item_id']) && $_GET['item_id']>0 ? Session::put('lgprod_id',$_GET['item_id']) : '';
			
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 




			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h1 align="center">'.$com_name.'</h1></td></tr>';
			// data collection filter method by session	
			$data=array('dto'=>'0000-00-00');
			
			Session::has('sdto') ? 
			$data=array('dto'=>Session::get('sdto')) : array('dto'=>'0000-00-00'); 
		

				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h5>Stock Balance</h5><h5 >'.$data['dto'].'</h5></td></tr>';

		?>
        
        </table>

            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="8"><a href="{!! url('/invenmaster/sbalance?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['prod_id']) ? $data['prod_id']='' : '' ;
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'invenmaster/sfilter', 'class' => 'form-horizontal']) !!}
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
                        @foreach($wh as $item)
                        	<th class="text-right">{{ $item->name }}</th>
                        @endforeach
                        <th class="text-right">{{ $langs['ttl'] }}</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
				@foreach($products as $item)
                <?php $has=has($item->id);?>
                {{-- */$x++;/* --}}
            	<tr>
                    <td width="50" class="text-center">{{ $x }}</td>
                	<td>{{ $item->name }}</td>
                    <?php  $ttl=''; ?>
                        @foreach($wh as $war)
                        <?php 
							$balance=fld_value($item->id, $data['dto'], $war->id);
							$balance!=0 ? $balances=number_format($balance) : $balances='';
							$ttl +=$balance;
						?>
                        
                        	<td class="text-right">{{ $balances }} </td>
                        @endforeach
                        	<td class="text-right">{{ $ttl }} @if(isset($item->unit->name)){{ $item->unit->name }}@endif</td>
                    
                    </tr>
                @endforeach
                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Inventory->Stock Balance</td><td class="text-right">Report generated by: </td></tr>
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
