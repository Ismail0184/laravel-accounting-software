
@extends('app')

@section('htmlheader_title', 'Lcimports')

@section('contentheader_title', 'B2B LC List')

@section('main-content')

 <div class="container">
 <div class="box" >
    <div class="table-responsive">
        <div class="box-header">
        <table class="table borderless">
        <?php 
			isset($_GET['lc_id']) && $_GET['lc_id']> 0 ? Session::put('b2blc_id', $_GET['lc_id']).Session::put('b2bclient_id', '') : '';
			isset($_GET['client_id']) && $_GET['client_id']> 0 ? Session::put('b2bclient_id', $_GET['client_id']).Session::put('b2blc_id', '') : '';

			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 


			Session::has('b2blc_id') || Session::has('b2bclient_id') ? 
			$data=array('lc_id'=>Session::get('b2blc_id'),'client_id'=>Session::get('b2bclient_id')) : $data=array('lc_id'=>'','client_id'=>''); 

			$lc=DB::table('acc_lcinfos')->where('com_id',$com_id)->where('id',$data['lc_id'])->first();
			$lc_number=''; isset($lc) && $lc->id>0 ? $lc_number=$lc->lcnumber : $lc_number=''; 


			echo '<tr><td colspan="2"><h1 align="center">'.$com_name.'</h1></td></tr>';
			
			$ttl=''; //echo $data['client_id'];
		?>
		<?php 
			if (isset($data['lc_id']) && $data['lc_id']>0):
				// for single account
				echo '<tr><td ><h3 class="pull-left">B2B LC</h3></td>
				<td class="text-right" ><h3 aling="right"></h3><h5 >LC  Number: '.$lc_number.'</h5></td></tr>';
			elseif (isset($data['client_id']) && $data['client_id']>0):
				// for multiple account
				$client=DB::table('acc_clients')->where('id',$data['client_id'])->first();
				$client_name=''; ($client) && $client->id>0 ? $client_name=$client->name : $client_name=''; 
				echo '<tr><td ><h3 class="pull-left">B2B LC</h3></td>
				<td class="text-right" ><h3 aling="right"></h3><h5 >Client Name: '.$client_name.'</h5></td></tr>';
			endif;
			
		?>

        </table>
        </div><!-- /.box-header -->

            <table id="buyerinfo-table" class="table table-bordered">
                <thead>

                <tr><td colspan="8"><a href="{!! url('/b2b/report?flag=filter') !!}"> Filter  </a>
					<?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'b2b/b2bfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('lc_id', $langs['lc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('lc_id',$lcinfos , null, ['class' => 'form-control', 'id'=>'lc_id',]) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('client_id', $langs['client_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('client_id',$clients , null, ['class' => 'form-control', 'id'=>'lc_id',]) !!}
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
                        <th>{{ $langs['blcnumber'] }}</th>
                        <th>{{ $langs['lc_id'] }}</th>
                        <th>{{ $langs['bdate'] }}</th>
                        <th>{{ $langs['client_id'] }}</th>
                        <th>{{ $langs['acc_id'] }}</th>
                        <th class="text-right">{{ $langs['bamount'] }}</th>
                    </tr>
                </thead>
                <tbody>
                <?php 

					if (isset($data['lc_id']) && $data['lc_id']>0): 
						$b2bs=DB::table('acc_b2bs')->where('com_id',$com_id)->where('lc_id',$data['lc_id'])->get(); 
					elseif (isset($data['client_id']) && $data['client_id']>0): 
						$b2bs=DB::table('acc_b2bs')->where('com_id',$com_id)->where('client_id',$data['client_id'])->get();					
					endif;
					$cur_name='';
				
				?>
				{{-- */$x=0;/* --}}
                @foreach($b2bs as $item)
                {{-- */$x++;/* --}}
                    <?php 
						$lc=DB::table('acc_lcinfos')->where('id',$item->lc_id)->first();
						$lc_number=''; isset($lc) && $lc->id>0 ? $lc_number=$lc->lcnumber : $lc_number='';

						$cur=DB::table('acc_currencies')->where('id',$lc->currency_id)->first(); //echo $item->currency_id;
						 isset($cur) && $cur->id>0 ? $cur_name=$cur->name : $cur_name='';

						$coa=DB::table('acc_coas')->where('id',$item->acc_id)->first();
						$coa_name=''; isset($coa) && $coa->id>0 ? $coa_name=$coa->name : $coa_name='';

						$client=DB::table('acc_clients')->where('id',$item->client_id)->first(); //echo $item->client_id;
						$client_name=''; isset($client) && $client->id>0 ? $client_name=$client->name : $client_name='';
						$ttl += $item->bamount;
						$item->bamount> 0 ? $item->bamount=number_format($item->bamount,2) : '';
						
					?>                
                  <tr>
                        <td width="50">{{ $x }}</td>
                        <td>{{ $item->blcnumber }}</td>
                        <td>{{ $lc_number }}</td>
                        <td>{{ $item->bdate }}</td>
                        <td>{{ $client_name }}</td>
                        <td>{{ $coa_name }}/{{ $item->p_details }}</td>
                        <td class="text-right">{{ $item->bamount }}/{{ $cur_name }}</td>

                 </tr>
                @endforeach
                <?php $ttl!='' ? $ttl=number_format($ttl,2) : '';?>
				<tr><td colspan="6" class="text-right">Total</td><td class="text-right">{{ $ttl }}/{{ $cur_name }}</td></tr>
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