@extends('app')

@section('htmlheader_title', 'Lcimports')

@section('contentheader_title', 'LC Tranfer List')

@section('main-content')

 <div class="container">
 <div class="box" >
    <div class="table-responsive">
        <div class="box-header">
        <table class="table borderless">
        <?php 
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h1 align="center">'.$com_name.'</h1></td></tr>';
			$lcval=''; $lcvals='';$lcva_ttl='';$amount_ttl='';$amount_ttls='';

			// data collection filter method by session	
			$data=array('client_id'=>'','country_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');

			Session::has('tradto') ? 
			$data=array('client_id'=>Session::get('traclient_id'),'dfrom'=>Session::get('tradfrom'),'dto'=>Session::get('tradto')) : ''; 
		?>
        <tr><td class="text-center"><h4>Transfered LC List</h4></td></tr>
        </table>
        </div><!-- /.box-header -->

            <table id="buyerinfo-table" class="table table-bordered">
                <thead>
                <tr><td colspan="9"><a href="{!! url('/lctransfer/report?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'lctransfer/tranfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('client_id', $langs['client_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('client_id', $clients, null, ['class' => 'form-control select2']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  date('Y-01-01'), ['class' => 'form-control', 'id'=>'dfrom', 'required']) !!}
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
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th>{{ $langs['date'] }}</th>
                        <th>{{ $langs['lc_id'] }}</th>
                        <th>{{ $langs['lcamount'] }}</th>
                        <th>{{ $langs['crateto'] }}</th>
                        <th>Amunt In Taka</th>
                        <th >{{ $langs['com_rate'] }}</th>
                        <th>{{ $langs['camount'] }} Taka</th>
                        <th>Amount in Taka</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
                <?php 
					if($data['client_id']>0 ):
						$lctransfers=DB::table('acc_lctransfers')
						->where('com_id',$com_id)
						->where('client_id',$data['client_id'])
						->whereBetween('tlcdate', [$data['dfrom'], $data['dto']])->get();
					endif; 
					$amount_ttls=''; $lcva_ttlUSAs=''; $lcva_ttls='';
				?>
                @foreach($lctransfers as $item)
                {{-- */$x++;/* --}}
                    <?php 
						$lc=DB::table('acc_lcinfos')->where('id',$item->lc_id)->first();
						$lc_number=''; isset($lc) && $lc->id>0 ? $lc_number=$lc->lcnumber : $lc_number='';
						$currency_id=''; isset($lc) && $lc->id>0 ? $currency_id=$lc->currency_id : $currency_id='';
						$crateto=''; isset($lc) && $lc->id>0 ? $crateto=$lc->crateto : $crateto='';
						$lc_value=''; isset($lc) && $lc->id>0 ? $lc_value=$lc->lcamount : $lc_value='';
						
						$client=DB::table('acc_clients')->where('id',$item->client_id)->first();
						$client_name=''; isset($client) && $client->id>0 ? $client_name=$client->name : $client_name='';
						//$item->bamount> 0 ? $item->bamount=number_format($item->bamount,2) : '';

						$currency=DB::table('acc_currencies')->where('id',$currency_id)->first();
						$currency_name=''; isset($currency) && $currency->id>0 ? $currency_name=$currency->name : $currency_name='';
						$amount='';
						if ($item->camount!='' && $crateto!=''):
							$amount=$item->camount* $crateto;
						endif;
						$amount!='' ? $amounts=number_format($amount,2) : '';
						$amount!='' ? $amount_ttl += $amount : '' ;
						if ($lc_value!='' && $crateto!=''):
							$lcval=$lc_value* $crateto;
						endif;
						$lcval!='' ? $lcvals=number_format($lcval,2) : '';
						$lcva_ttl += $lcval;

					?>                
                  <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $client_name }}</td>
                        <td>{{ $item->tlcdate }}</td>
                        <td>{{ $lc_number }}</td>
                        <td>{{ $lc_value.'('.$currency_name.')' }}</td>
                        <td>{{ $crateto }}</td>
                        <td>{{ $lcvals }}</td>
                        <td>{{ $item->com_rate }}</td>
                        <td class="text-right">{{ $item->camount.'('.$currency_name.')' }}</td>
                        <td class="text-right">{{ $amounts }}</td>
                 </tr>
                @endforeach
                <?php 
					$lcva_ttl>0 ? $lcva_ttls=number_format($lcva_ttl,2) : ''; 
					$amount_ttl>0 ? $amount_ttls=number_format($amount_ttl,2) : ''; 
					$lcva_ttlUSA=$lcva_ttl/80; $lcva_ttlUSA> 0 ? $lcva_ttlUSAs=number_format($lcva_ttlUSA,2) : '';
				?>
				<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>{{ $lcva_ttls }}<br>{{ $lcva_ttlUSAs }}(USD)</td><td></td><td></td><td class="text-right">{{ $amount_ttls }}</td></tr>
                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Export->Buyer</td><td class="text-right">Report generated by:</td></tr>
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