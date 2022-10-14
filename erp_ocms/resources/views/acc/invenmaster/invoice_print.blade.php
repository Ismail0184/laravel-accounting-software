@extends('print')

@section('htmlheader_title', ' Invoice')

@section('contentheader_title', 	  ' Invoice')
@section('main-content')

<style>
    table.borderless td,table.borderless th, table.borderless tr, table.borderless{
	border:none;
	 padding:10px;
	}
	#col {  min-height:100px; padding-top:50px; width:23%; float:left; padding:20px ; background-color:; margin:5px}
	#inner { border:1px solid #300; min-height:60px; padding:10px; margin:3px}

	#unit {width: 10px} 
	#cur {width: 10px}
	#logo, #td { width:25%}
	#buyerinfo-table tr,#buyerinfo-table td, #buyerinfo-table th { border:1px solid black; }
	.box-body { min-height:400px}
	#in-body { height:50px}
	#foo {width:100%;}
	.underline {  border-bottom: 0; }
	.wordc { text-transform:capitalize}
	.cname { font-size:18px; font-weight:bold}
	.address { font-size:10px}
	.rpt { font-size:16px}
	.tables { font-size:10px}
	.ttle { font-size:18px; font-weight:bold}
	.client_name { font-size:16px; font-weight:bold}
	.invoice { font-size:20px; font-weight:bold}
</style>
        <?php 
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 
			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			isset($_GET['flag']) && $_GET['flag']>0 ? Session::put('siacc_id',$_GET['flag']) : '';

			// data collection filter method by session	
			$data=array('acc_id'=>'');
			
			Session::has('siacc_id') ? 
			$data=array('acc_id'=>Session::get('siacc_id')) : ''; 
			$client_name=''; $client_address='';
			
			isset($data['acc_id']) && $data['acc_id']>0 ?
			$sls=DB::table('acc_invenmasters')->where('com_id',$com_id)->where('id', $data['acc_id'])->first() : '';
			isset($sls) && $sls->id >0 ? $sls_check_action=$sls->check_action : $sls_check_action='';
		?>
        <table  width="100%" border="1" class="borderless tables">
        <tr><td id="logo"></td><td>
        	<h2 align="center" class="cname">{{ $com->name }}</h2>
            <h5 class="text-center address">{{ $com->oaddress }}</h5>
            <h5 class="text-center address">{{ strlen($com->phone) > 0  ? $com->phone : '' }} {{ strlen($com->fax)> 0 ? ', '.  $com->fax : '' }}</h5>
            <h5 class="text-center address">{{ strlen($com->email)> 0 ? $com->email : '' }} {{ strlen($com->web)> 0 ?  ', '. $com->web : ''}}</h5>
        </td><td></td></tr>
        <?php 


			if (isset($data['acc_id']) && $data['acc_id']>0):
				// for single account
				
				$sale=DB::table('acc_invenmasters')->where('com_id',$com_id)->where('id', $data['acc_id'])->get();
				$sales=DB::table('acc_invenmasters')->where('com_id',$com_id)->where('id', $data['acc_id'])->first();
				
				$sales_invoice=''; isset($sales) && $sales->id > 0 ? $sales_invoice=$sales->vnumber : $sales_invoice='';
				$sales_date=''; isset($sales) && $sales->id > 0 ? $sales_date=$sales->idate : $sales_date='';
				$sales_clinet_id=''; isset($sales) && $sales->id > 0 ? $sales_clinet_id=$sales->client_id : $sales_clinet_id='';
				$sales_clinet_address=''; isset($sales) && $sales->id > 0 ? $sales_clinet_address=$sales->client_address : $sales_clinet_address='';
				$sales_clinet_name=''; isset($sales) && $sales->id > 0 ? $sales_clinet_name=$sales->client : $sales_clinet_name='';
				
				$client = DB::table('acc_clients')->where('com_id',$com_id)->where('id',$sales_clinet_id)->first();  
				if (isset($client) && $client->id > 0):
					$client_name=$client->name;
					$client_address=$client->address1;
				else:
					$client_name=$sales_clinet_name;
					$client_address=$sales_clinet_address;
				
				endif;

				echo '<tr><td ><h2 class="pull-left invoice">Invoice</h2></td><td></td>
				<td class="text-right"  id="td"><h4 aling="right" class="rpt">Invoice No: '.$sales_invoice.'</h4><h4 class="rpt">Date: '.$sales_date.'</h4></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h4>Invoice</h4><h5 ></h5></td></tr>';
			endif;
			
		?>
        
        </table>
			
            <table id="buyerinfo-table" class="table tables">
                <thead>
                 <tr class="underline"><td colspan="5" class="client_name"> Name: {{ $client_name }} </td></tr>
                 <tr class="underline"><td colspan="5"> Address: {{ $client_address }}</td></tr> 
                    <tr>
                        <th class="text-center">{{ $langs['sl'] }}</th>
                        <th class="">Description of Materials</th>
                        <th class="text-right">{{ $langs['qty'] }}</th>
                        <th class="text-right" >{{ $langs['rate'] }}</th>
                        <th class="text-right" >Total Taka</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
                <?php 
				$username='';$checkname='';$apprname='';$y=0;
				?>
                @foreach($sale as $item)
                
                 	<?php
					$username= isset($users[$item->user_id]) ? $users[$item->user_id] : '';
					$checkname= $item->check_action==1 ? isset($users[$item->check_id]) ? $users[$item->check_id] : '' : 'waiting';
					$apprname= '...';
					//$user=$item->user->name;
					$ttl='';
					$details=DB::table('acc_invendetails')->where('com_id',$com_id)->where('group_id',0)->where('im_id', $item->id)->get(); 
					$purch=DB::table('acc_invenmasters')->where('com_id',$com_id)->where('id', $item->id)->first(); //echo $purch->amount;

					 $currency = DB::table('acc_currencies')->where('id',$item->currency_id)->first();  
					 $currency_name=''; isset($currency) && $currency->id > 0 ? $currency_name=$currency->name : $currency_name='';
					
					?>
                    
                        @foreach($details as $item)
                        {{-- */$x++;/* --}}
                        <?php 
						
							$ttl+=$item->amount;
							$item->amount> 0 ? $item->amounts=number_format($item->amount, 2): $item->amounts='';
							$item->rate> 0 ? $item->rates=number_format($item->rate, 2): $item->rates='';

							$vnumber = DB::table('acc_invenmasters')->max('vnumber')+1; 
							$item->user_id > 0 ? $person=$users[$item->user_id] : $person='';

							$products = DB::table('acc_products')->where('id',$item->item_id)->first(); 
							$product_name=''; isset($products) && $products->id > 0 ? $product_name=$products->name : $product_name='';
							$unit_id=''; isset($products) && $products->id > 0 ? $unit_id=$products->unit_id : $unit_id='';
							$units = DB::table('acc_units')->where('id',$unit_id)->first(); 
							$unit_name=''; isset($units) && $units->id > 0 ? $unit_name=$units->name : $unit_name='';
							$y=$y+50;
							$space=""; $item->group_id>0 ? $space="50" : $space=""; //echo $space.'mm<br>';
							$item->qty<0 ? $item->qty=substr($item->qty,1): '';
						?>
                         <tr id="in-body">
                        	<td class="text-center">{{ $x }}</td>
                            <td style="padding-left:{{ $space }}px">{{ $product_name }}</td>
                            <td class=" text-right">{{ $item->qty }} {{ $unit_name }}</td>
                            <td class=" text-right">{{ $item->rates}} {{ $currency_name }}</td>
                            <td class=" text-right">{{ $item->amounts }} {{ $currency_name }}</td>
                          </tr>
						<?php 
							$details=DB::table('acc_invendetails')->where('com_id',$com_id)->where('group_id', $item->id)->get(); 
						?>
                                @foreach($details as $item)
                                {{-- */$x++;/* --}}
                                <?php 
                                    $ttl+=$item->amount;
                                    $item->amount> 0 ? $item->amounts=number_format($item->amount, 2): $item->amounts='';
                                    $item->rate> 0 ? $item->rates=number_format($item->rate, 2): $item->rates='';
        
                                    $vnumber = DB::table('acc_invenmasters')->max('vnumber')+1; 
                                    $item->user_id > 0 ? $person=$users[$item->user_id] : $person='';
        
                                    $products = DB::table('acc_products')->where('id',$item->item_id)->first(); 
                                    $product_name=''; isset($products) && $products->id > 0 ? $product_name=$products->name : $product_name='';
                                    $unit_id=''; isset($products) && $products->id > 0 ? $unit_id=$products->unit_id : $unit_id='';
                                    $units = DB::table('acc_units')->where('id',$unit_id)->first(); 
                                    $unit_name=''; isset($units) && $units->id > 0 ? $unit_name=$units->name : $unit_name='';
                                    $y=$y+50;
                                    $space=""; $item->group_id>0 ? $space="50" : $space=""; //echo $space.'mm<br>';
                                ?>
                                 <tr id="in-body">
                                    <td class="text-center">{{ $x }}</td>
                                    <td style="padding-left:{{ $space }}px">{{ $product_name }}</td>
                                    <td class=" text-right">{{ $item->qty }} {{ $unit_name }}</td>
                                    <td class=" text-right">{{ $item->rates}} {{ $currency_name }}</td>
                                    <td class=" text-right">{{ $item->amounts }} {{ $currency_name }}</td>
                                  </tr>
                                  
                                @endforeach  
                        @endforeach  
                        <?php $y=400 - $y; ?>
                         <tr style="height:{{ $y }}px">
                        	<td class="text-center"></td>
                            <td></td>
                            <td class=" text-right"></td>
                            <td class=" text-right"></td>
                            <td class=" text-right"></td>
                          </tr>
                        <?php 
							$ttl> 0 ? $ttls=number_format($ttl, 2) : $ttls=''; 
							// check entry 
							$check_entry = DB::table('acc_invenmasters')->where('pm_id', $data['acc_id'] )->first();
							isset($check_entry) && $check_entry->pm_id>0 ? $entry_has='yes' : $entry_has='no' ; //echo $entry_has;
						?> 
                        <tr><td colspan="4" class=" text-right">Total</td><td class=" text-right">{{ $ttls }} {{ $currency_name }}</td></tr> 
                        <tr><td colspan="5" class=" text-left wordc">Inwords (Taka) : {{ Terbilang::make($ttl) }}</td></tr> 

                @endforeach
				
                </tbody>
            </table>
            </div>
         	<div class="foo tables" style="padding:5px">
                <div class="text-center" id="col">{{ $username }}
                    <div id="inner">Prepared By</div>
                </div>
            	<div class="text-center" id="col">{{ $checkname }}
            		<div id="inner">Checked By</div>
                </div>
            	<div class="text-center" id="col">{{ $apprname }}
            		<div id="inner">Approved By</div>
                </div>
            	<div class="text-center" id="col">....
            		<div id="inner">Received By</div>
                </div>
            </div>     
      
@endsection

