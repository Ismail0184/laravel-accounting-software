
            <?php 
				$vtm_id=''; Session::has('vtm_id') ? $vtm_id=Session::get('vtm_id') : $vtm_id='';
				$tranmaster=DB::table('acc_tranmasters')->where('id',$vtm_id)->first();
				$nam=''; //echo $tranmaster->tranwith_id;
				$group=DB::table('acc_coas')->where('id', $tranmaster->tranwith_id)->first(); 
				$group_id=''; isset($group) && $group->id > 0 ? $group_id=$group->group_id : $group_id='';
				
				$coa=DB::table('acc_coas')->where('id', $group_id)->first(); 
				$acc_name=''; isset($coa) && $coa->id > 0 ? $acc_name=$coa->name : $acc_name='';
				
				$currency=DB::table('acc_currencies')->where('id', $tranmaster->currency_id)->first(); 
				$currency_name=''; isset($currency) && $currency->id > 0 ? $currency_name=$currency->name : $currency_name='';

				$user=DB::table('users')->where('id', $tranmaster->user_id)->first(); 
				$currency_name=''; isset($currency) && $currency->id > 0 ? $currency_name=$currency->name : $currency_name='';
								

				$nam='';
				if ($acc_name=='Cash Account'):
					$nam='Cash';
				elseif ($acc_name=='Bank Account'):
					$nam='Bank';
				endif;
				 
				$vn='';
				if ($tranmaster->ttype=="Payment"):
				 	$vn="Debit Voucher";  
				 elseif($tranmaster->ttype=="Receipt"):
				 	$vn="Credit Voucher";
				 elseif ($tranmaster->ttype=="Journal"):
				 	$vn="Journal Voucher"; 
				 elseif ($tranmaster->ttype=="Contra"):
				 	$vn="Contra Voucher";
				 endif;

				$tranwith=DB::table('acc_coas')->where('id', $tranmaster->tranwith_id)->first(); 
				$tranwith_name=''; isset($tranwith) && $tranwith->id > 0 ? $tranwith_name=$coa->name : $tranwith_name='';
				
			?>
            <table class="table table-bordered">
                <tr><th colspan="4"><h2><span class="pull-left">OCMS</span><span class="pull-right">{{ $vn }}</span></h2></th></tr>
                <tr><th colspan="4"><h2 class="text-center">{{ $nam }} {{ $tranmaster->ttype }}</h2></th></tr>
                <tr>
                    <th id="lebel">{{ $langs['vnumber'] }} :</th><th>{{ $tranmaster->vnumber }}</th><th  id="lebel">{{ $langs['tdate'] }} :</th><th id="lebel2">{{ $tranmaster->tdate }}</th>
                </tr>
                <tr>
                    <th id="lebel" >{{ $langs['person'] }} :</th><th>{{ $tranmaster->person }}</th><th id="lebel">{{ $langs['tranwith_id'] }} :</th><th id="lebel2">{{ $tranwith_name }}</th>
            </tr>
        </table><br>
        <h3>Transaction Details</h3>
        <table class="table" id="details">
               <?php 
			   		$details=DB::table('acc_trandetails')
					->where('tm_id', $tranmaster->id)
					->where('flag', 0)
					->get(); 
			   ?>
                   <tr>
                    	<th class="text-center" id="sl">{{ $langs['sl'] }}</th>
                        <th>{{ $langs['acc_id'] }}</th>
                        <th class="text-right" colspan="2">{{ $langs['amount'] }}</th>
                    </tr>
               <?php $ttl=''; ?>
               {{-- */$x=0;/* --}}
               @foreach( $details as $item)
               {{-- */$x++;/* --}}
               <?php 
					$item->amount< 0 ? $item->amount=substr($item->amount,1): ''; 
					$ttl += $item->amount;  $amount=number_format($item->amount, 2); 
					$coa=DB::table('acc_coas')->where('id',$item->acc_id)->first();
					$coa_name=''; isset($coa) && $coa->id >0 ? $coa_name=$coa->name : $coa_name='';				

			   ?>
                <tr>
                    <td class="text-center">{{ $x }}</td>
                    <td >{{ $coa_name }}</td>
                    <td id="cur">{{ $currency_name }}</td>
                    <td class="text-right">{{ $amount }}</td>
                </tr>
                @endforeach
                <?php 
				$ttl!=0 ? $ttls = number_format($ttl,2) : $ttls ='';  ?>
                <tr>
                	<td colspan="2" class="text-right">Total</td>
                	<td id="cur">{{ $currency_name }}</td>
                    <td class="text-right">{{ $ttls }}</td>
                </tr>
        </table>
         	<div class="row" style="padding:5px">
                <div class="col-sm-3 text-center" id="col">{{ $users[$tranmaster->user_id] }}
                    <div id="inner">Inputed By</div>
                </div>
            	<div class="col-sm-3 text-center" id="col">{{ $users[$tranmaster->check_id] }}
            		<div id="inner">Checked By</div>
                </div>
            	<div class="col-sm-3 text-center" id="col">{{ $users[$tranmaster->appr_id] }}
            		<div id="inner">Approved By</div>
                </div>
            	<div class="col-sm-3 text-center" id="col"><br>
            		<div id="inner">Received By</div>
                </div>
            </div>     
    </div>
    </div>
</div>
