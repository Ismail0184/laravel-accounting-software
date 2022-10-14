        <table  width="100%" border="1" class="borderless">
        <tr>
        <?php 
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 
			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 

		?>
        	<tr><td><h2>{{ $com->name }}</h2></td> </tr>
            <tr><td>{{ $com->oaddress }}</td> </tr>
            <tr><td>{{ $com->phone }}, {{ $com->fax }}</td> </tr>
            <tr><td>{{ $com->email }}, {{ $com->web }}</td> </tr>
       
        <?php 

			// data collection filter method by session	
			$data=array('acc_id'=>'');
			
			Session::has('siacc_id') ? 
			$data=array('acc_id'=>Session::get('siacc_id')) : ''; 
		
			if (isset($data['acc_id']) && $data['acc_id']>0):
				// for single account
				$sale=DB::table('acc_salemasters')->where('id', $data['acc_id'])->get();
				$sales=DB::table('acc_salemasters')->where('id', $data['acc_id'])->first();
				echo '<tr><td class="text-right"><h4 aling="right">Invoice No: '.$data['acc_id'].'</h4></td><td>
					<h4>Date: '.$sales->sdate.'</h4></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h4>Invoice</h4><h5 ></h5></td></tr>';
			endif;
			
			$client_name=''; $client_address='';
			$client = DB::table('acc_clients')->where('id',$sales->client_id)->first();  
			if (isset($client) && $client->id > 0):
				$client_name=$client->name;
				$client_address=$client->address;
			else:
				$client_name=$sales->client;
				$client_address=$sales->client_address;
			
			endif;

		?>
        
        </table>
			
            <table id="buyerinfo-table" class="table">
                <thead>

                 <tr><td colspan="8"> Name: {{ $client_name }} </td></tr>
                 <tr><td colspan="8"> Address: {{ $client_address }}</td></tr> 
                    <tr>
                        <th class="col-md-1 text-center">{{ $langs['sl'] }}</th>
                        <th class="col-md-3">{{ $langs['description'] }}</th>
                        <th class="col-md-2 text-right">{{ $langs['qty'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['rate'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
                <?php 
						
				?>
                @foreach($sale as $item)
                
                 	<?php
					$username=$item->user_id >0 ? $users[$item->user_id] : '';
					$checkname=$item->check_id >0 ? $users[$item->check_id] : 'waiting';
					$apprname=$item->check_id >0 ? $users[$item->check_id] : '...';
					//$user=$item->user->name;
					$ttl='';
					$details=DB::table('acc_saledetails')->where('sm_id', $item->id)->get(); 
					$purch=DB::table('acc_salemasters')->where('id', $item->id)->first(); //echo $purch->amount;

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

							$units = DB::table('acc_units')->where('id',$item->unit_id)->first(); 
							$unit_name=''; isset($units) && $units->id > 0 ? $unit_name=$units->name : $unit_name='';
							
						?>
                         <tr id="in-body">
                        	<td class="text-center">{{ $x }}</td>
                            <td>{{ $product_name }}</td>
                            <td class=" text-right">{{ $item->qty }} {{ $unit_name }}</td>
                            <td id="cur">{{ $currency_name }}</td><td class=" text-right">{{ $item->rates}}</td>
                            <td id="cur">{{ $currency_name }}</td><td class=" text-right">{{ $item->amounts }}</td>
                          </tr>
                        @endforeach  
                       
                        <?php  
							$ttl> 0 ? $ttls=number_format($ttl, 2) : $ttls=''; 
							// check entry 
							$check_entry = DB::table('acc_invenmasters')->where('pm_id', $data['acc_id'] )->first();
							isset($check_entry) && $check_entry->pm_id>0 ? $entry_has='yes' : $entry_has='no' ; //echo $entry_has;
							
						?> 
                        <tr><td colspan="5" class=" text-right">Total</td><td id="cur"><td class=" text-right">{{ $ttls }}</td></tr> 
                        <tr><td colspan="10" class=" text-left">Inwords : </td></tr> 

                @endforeach
				
         	<tr><td>{{ $username }}</td><td>{{ $checkname }}</td><td>{{ $apprname  }}</td><td>{{ $apprname }}</td><tr>
         	<tr><td>Inputed By</td><td>Checked By</td><td>Approved By</td><td>Received By</td></tr>
               
               </tbody>

            </table>
