@extends('app')

@section('htmlheader_title', 'Buyer')

@section('contentheader_title', 'LC Information')

@section('main-content')

 <div class="container">
 <div class="box" >
    <div class="table-responsive">
        <div class="box-header">
        <table class="table borderless">
        <?php 
			isset($_GET['buyer_id']) && $_GET['buyer_id']> 0 ? Session::put('brbuyer_id', $_GET['buyer_id']) : '';
			isset($_GET['country_id']) && $_GET['country_id']> 0 ? Session::put('brcountry_id', $_GET['country_id']) : '';

			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 

			// data collection filter method by session	
			$data=array('buyer_id'=>'','country_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');

			Session::has('brdto') ? 
			$data=array('buyer_id'=>Session::get('brbuyer_id'),'country_id'=>Session::get('brcountry_id'),'dfrom'=>Session::get('brdfrom'),'dto'=>Session::get('brdto')) : ''; 
		

			
			echo '<tr><td colspan="2"><h2 align="center">'.$com_name.'</h2></td></tr>
       			 <tr><td class="text-center"><h5>Export LC Statement</h5><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
		?>
        </table>
        </div><!-- /.box-header -->

            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                <tr><td colspan="9"><a href="{!! url('/lcinfo/report?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'lcinfo/byrfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('buyer_id', $langs['buyer_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('buyer_id', $buyers, null, ['class' => 'form-control select2']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('country_id', $langs['country_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('country_id', $country, null, ['class' => 'form-control select2']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  date('Y-m-01'), ['class' => 'form-control', 'id'=>'dfrom', 'required']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dto', $langs['dto'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dto',  date('Y-m-d'), ['class' => 'form-control', 'id'=>'dto', 'required']) !!}
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
                        <th class="col-md-1">{{ $langs['sl'] }}</th>
                        <th class="col-md-2">{{ $langs['lcnumber'] }}</th>
                        <th class="col-md-1">{{ $langs['lcdate'] }}</th>
                        <th class="col-md-1">{{ $langs['shipmentdate'] }}</th>
                        <th class="col-md-2">{{ $langs['buyer_id'] }}</th>
                        <th class="col-md-1">{{ $langs['country_id'] }}</th>
                        <th class="col-md-1 text-right">{{ $langs['lcamount'] }}</th>
                        <th class="col-md-1">{{ $langs['crateto'] }}</th>
                        <th class="col-md-1">Amount In Taka</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
					$amount_ttl=''; $amount_ttls=''; $amountttl_USAs='' ;
					if($data['buyer_id']>0 ):
						$lcinfo=DB::table('acc_lcinfos')
						->where('com_id',$com_id)
						->where('buyer_id',$data['buyer_id'])
						->whereBetween('lcdate', [$data['dfrom'], $data['dto']])->get();
					elseif($data['country_id']>0):
						$lcinfo=DB::table('acc_lcinfos')
						->where('com_id',$com_id)
						->where('country_id',$data['country_id'])
						->whereBetween('lcdate', [$data['dfrom'], $data['dto']])->get();
					elseif($data['country_id']=='' && $data['buyer_id']==''):
						$lcinfo=DB::table('acc_lcinfos')
						->where('com_id',$com_id)
						->whereBetween('lcdate', [$data['dfrom'], $data['dto']])->get();
					endif;
					
				?>
				{{-- */$x=0;/* --}}
                @foreach($lcinfo as $item)
                {{-- */$x++;/* --}}
                <?php 
					$amount='';
					if ($item->crateto!='' && $item->lcamount!=''):
						$amount=$item->crateto * $item->lcamount;
						$amount_ttl +=$amount; //echo $amount_ttl.'<br>';
					endif;
					$amount!='' ? $amounts=number_format($amount,2) : '';

					$buyer=DB::table('acc_buyerinfos')->where('com_id',$com_id)->where('id',$item->buyer_id)->first();
					$buyer_name=''; isset($buyer) && $buyer->id >0 ? $buyer_name=$buyer->name : $buyer_name='';

					$country=DB::table('acc_countries')->where('id',$item->country_id)->first();
					$country_name=''; isset($country) && $country->id >0 ? $country_name=$country->name : $country_name='';

					$currency=DB::table('acc_currencies')->where('id',$item->currency_id)->first();
					$currency_name=''; isset($currency) && $currency->id >0 ? $currency_name=$currency->name : $currency_name='';

				?>
                <tr>
                        <td class="">{{ $x }}</td>
                        <td class="">{{ $item->lcnumber }}</td>
                        <td class="">{{ $item->lcdate }}</td>
                        <td class="">{{ $item->shipmentdate }}</td>
                        <td class="">{{ $buyer_name }}</td>
                        <td class="">{{ $country_name }}</td>
                        <td class="text-right">{{ $item->lcamount.'('.$currency_name.')' }}</td>
                        <td class="">{{ $item->crateto }}</td>
                        <td class="text-right">{{ $amounts }}</td>
                 </tr>
                @endforeach
                <?php $amount_ttl!='' ? $amount_ttls=number_format($amount_ttl,2) : ''; $amountttl_USA= $amount_ttl/80; 
				$amountttl_USA!='' ? $amountttl_USAs=number_format($amountttl_USA,2): ''; ?>
				<tr><td colspan="8" class="text-right">Total LC Amount: </td><td>{{ $amount_ttls.'(Taka)' }}<br>{{ $amountttl_USAs.'(USA)' }}</td></tr>
                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Export->Lc info</td><td class="text-right">Report generated by: </td></tr>
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