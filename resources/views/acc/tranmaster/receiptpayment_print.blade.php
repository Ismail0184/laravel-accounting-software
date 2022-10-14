@extends('print')

@section('htmlheader_title', 'Trandetail')

@section('contentheader_title', 'Receipt and Payment Account')

<style>
    table.borderless td,table.borderless th{
     border: none !important; margin:0px; padding:0px
	}

	h1{
		font-size: 1.6em;
	}
	h5{
		font-size: 2em; margin:0px; font-weight:bold; margin:opx; padding:0px;
	}
	#cur {width: 10px}
	.container { width:auto;}
	body { padding:0px}
	#opn { margin:opx; padding:0px;}
	#dt { width:15%;} 
	#nt { width:30%; } 
	.tables { font-size:10px}
	.cname {font-size:18px}
	.tdate {font-size:12px}
	.ahead {font-size:16px}
</style>

@section('main-content')
 <div class="container">
 	<?php	
		$user_name=''; Session::has('user_name') ? $user_name=Session::get('user_name') : $user_name='';

		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		$edit_disabled='';
		?>

    <div class="box">
    <div class="table-responsive">
        <table  width="100%>
        <tr><td colspan="2"><h2 align="center" class="cname">{{ $com_name }}</h2></td></tr>
        <?php 
			$data=array('acc_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');
			
			Session::has('rdto') ? 
			$data=array('acc_id'=>Session::get('racc_id'),'dfrom'=>Session::get('rdfrom'),'dto'=>Session::get('rdto')) : 
			$data=array('acc_id'=>'','dfrom'=>date('Y-m-01'),'dto'=>date('Y-m-d')); 
			
			// for ledger report
			Session::put('dfrom', Session::get('rdfrom'));
			Session::put('dto', Session::get('rdto'));


			if (isset($data['acc_id']) && $data['acc_id']>0):
			// for single account
				$acc=DB::table('acc_coas')->where('com_id',$com_id)->where('id',$data['acc_id'])->first();
				$acc_head=''; isset($acc) && $acc->id>0 ? $acc_head=$acc->name : $acc_head='';
				
				echo '<tr><td ><h4 class="pull-left ahead">Receipt and Payment Account</h4></td>
				<td class="text-right" ><h3 aling="right" class="ahead">'.$acc_head.'</h3><h5 class="tdate">'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
				$maincash=DB::table('acc_coas')->where('com_id',$com_id)->where('id', $data['acc_id'])->first(); //echo $maincash->id;
				$maincash_id=''; isset($maincash) && $maincash->id>0 ? $maincash_id=$maincash->id : $maincash_id='';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h4>Receipt and Payment Account<br>Main Cash</h4><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
				$maincash=DB::table('acc_coas')->where('com_id',$com_id)->where('name', 'Main Cash')->first(); //echo $maincash->id;
				$maincash_id=''; isset($maincash) && $maincash->id>0 ? $maincash_id=$maincash->id : $maincash_id='';
			endif;
			
		?>
		</table>
            <table class="tables">
                <thead>
                    <tr>
                        <th class="col-md-6" id="nt">{{ $langs['acc_id'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['receipt'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['payment'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['balance'] }}</th>
                    </tr>
                </thead>
                <tbody>
				<?php 
                	$cur='Tk'; $pay=0; $rcvd=0; $balance=0; $ttl=0; //$balances='';
					$balances='';$balance=0; $ttl_pay=''; $ttl_rcvd=''; $ttl_balances='';
					$tdcur=''; $tccur=''; $ttl_pay=''; $ttl_rcvd=''; $ttl_balances='';   $ttl_pays=''; $ttl_rcvds='';  
					$atype='';          
					?>
                   <?php 
				   		
								// opening balance calculation
								$d_opbs=''; $c_opbs=''; $d_opb=''; $c_opb=''; $obcur=''; $opbs='';
								$opb=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
								->where('acc_trandetails.acc_id', $maincash_id)
								->where('acc_trandetails.com_id', $com_id)
								->where('acc_tranmasters.tdate','<', $data['dfrom'])
								->sum('acc_trandetails.amount');
								
								// opening balance text
								$opbalance=$opb>0 ? "<span class='pull-right'>Opening Balance</span>" : '' ;
								// Opening balance calculation and format
								$opb>0 ? $d_opbs=$opb : $c_opbs=$opb;  $ob_dcur='';  $ob_ccur=''; 
								$d_opbs!='' ? $d_opb=number_format($d_opbs, 2) : '';
								$c_opbs!='' ? $c_opb=number_format($c_opbs, 2) : '';
								$d_opbs!='' ? $ob_dcur=$cur : $ob_dcur=''; 
								$c_opbs!='' ? $ob_ccur=$cur : $ob_ccur=''; 
								
								$opb >0 ? $opbs=number_format($opb, 2).' Cr' : ''; 
								$opb <0 ? $opbs=substr(number_format($opb, 2),1).' Dr' : ''; 
								$opb >0 ? $obcur=$cur : '';
								
								$opb!='' ? $balance=$opb.''.$ttl_rcvd=$opb : '';  $tdcur=''; $tccur='';

										
								?>
                                    <tr>
                                        <td colspan=""><?php echo $opbalance ?></td>
                                        <td id="cur">{{  $ob_dcur }}</td><td class=" text-right">{{ $d_opb }}</td>
                                        <td id="cur">{{  $ob_ccur }}</td><td class=" text-right">{{ $c_opb }}</td>
                                        <td id="cur"></td><td class=" text-right"></td>
                                    </tr>
								<?php
				   // to create group account
/*				   isset($data['acc_id']) && $data['acc_id']>0 ?
				   $tran=DB::table('acc_coas')->where('id', $data['acc_id'])->groupBy('id')->get() : '';
*/				   ?> 
                  @foreach($tran as $item1)
                 
                  	<?php
					 
						// find child account has or not?
						$flg='';
							$seek=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item1->id)->get(); //echo $item1->name.'<br>';
							foreach( $seek as $value):
									$acc_seek=$value->id; //echo $value->name.'<br>'; 
									$find=DB::table('acc_trandetails')
									->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
									->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
									->where('acc_trandetails.tranwiths_id', $maincash_id)
									->where('acc_trandetails.com_id', $com_id)
									->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
									->where('acc_coas.id', $acc_seek)
									->first();
									isset($find->acc_id) && $find->acc_id>0 ? $flg='ok' : '';
										$seek2=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
										foreach( $seek2 as $value):
												$acc_seek=$value->id; //echo $value->name.'<br>'; 
												$find=DB::table('acc_trandetails')
												->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
												->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
												->where('acc_trandetails.tranwiths_id', $maincash_id)
												->where('acc_trandetails.com_id', $com_id)
												->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
												->where('acc_coas.id', $acc_seek)
												->first();
													isset($find->acc_id) && $find->acc_id>0 ? $flg='ok' : '';
													$seek3=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
													foreach( $seek3 as $value):
															$acc_seek=$value->id; //echo $value->name.'<br>'; 
															$find=DB::table('acc_trandetails')
															->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
															->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
															->where('acc_trandetails.tranwiths_id', $maincash_id)
															->where('acc_trandetails.com_id', $com_id)
															->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
															->where('acc_coas.id', $acc_seek)
															->first();
															isset($find->acc_id) && $find->acc_id>0 ? $flg='ok' : '';
													endforeach;
										endforeach;
							endforeach;
							 
						isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
						
						if (isset($item1->atype) && $item1->atype=='Group' && $flg=='ok'):						
					?>
                    	<!-- Group Head-->
<!--                  		<tr>
                            <td>{{ $item1->name }}</td>
                            <td id="cur"></td><td class=" text-right"></td>
                            <td id="cur"></td><td class=" text-right"></td>

                          </tr>
-->                                   <!--------------first------------------>
						<?php 
						endif;

						// find transaction of find group
						$details=array(); //echo $item1>name.'-osama';
						if (isset($item1->atype) && $item1->atype=='Account'):
							$details=DB::table('acc_trandetails')->where('com_id',$com_id)->where('acc_id', $item1->id)->where('tranwiths_id', $maincash_id)->groupBy('acc_id')->get() ;
						elseif (isset($item1->atype) && $item1->atype=='Group'):
							$details=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item1->id)->groupBy('id')->get() ;
						endif;
						$pay=0; $rcvd=0;
						?>
                        @foreach($details as $item2)
                        <?php 
						
							//echo $item2->id.'<br>';
							if (isset($item2->atype) && $item2->atype=='Account'):
								// find account-wise transaction sum
								$sum=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
								->where('acc_trandetails.tranwiths_id', $maincash_id)
								->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
								->where('acc_trandetails.acc_id', $item2->id)
								->where('acc_trandetails.com_id', $com_id)
								->groupBy('acc_trandetails.acc_id')
								->sum('acc_trandetails.amount') ; 
								
								$sum > 0 ? $item2->amount=-$sum : $item2->amount=-$sum; 
								$pay=''; $rcvd=''; $bc=''; $dcur=''; $ccur=''; 
								
								// to tal calculation
								$ttl+=$item2->amount; $balance += $item2->amount;
								// to make sign Dr or Cr behind balance 
								$balance<0 ? $balances=substr(number_format($balance,2), 1).' '.$bc='Cr' : $balances= number_format($balance,2).' '. $bc='Dr';
								
								// make different pay and rcvd
								$item2->amount>0 ? $pay=substr(number_format($item2->amount, 2),1) :  '' ; 
								$item2->amount<0 ? $rcvd= number_format($item2->amount, 2) : '' ;
								
								$pay!='' ? $dcur=$cur : $dcur=''; $rcvd!='' ? $ccur=$cur : $ccur='';
								// make total of pay and rcvd and thier currency
								$item2->amount<0 ? $ttl_pay += $item2->amount :  $ttl_rcvd += $item2->amount ; //echo $ttl_rcvd;
								$ttl_pay!='' ? $tdcur=$cur : $tdcur=''; $ttl_rcvd!='' ? $tccur=$cur : $tccur='';
								
								// find transaction 
								$find=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
								->where('acc_trandetails.tranwiths_id', $maincash_id)
								->where('acc_trandetails.com_id', $com_id)
								->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])																		
								->where('acc_trandetails.acc_id', $item2->id)
								->first(); 
								isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
								
								if ($flag==1):
							?>
                                  <tr>
                                    <td style="padding-left:30px">{{ $item2->name }} </td>
                                    <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $rcvd }}</td>
                                    <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $pay }}</td>
        							<td id="cur"></td><td class=" text-right"></td>
                                  </tr>
							
							<?php 
								endif;
							
							endif;
							// find child account has or not?
							$flg='';
							$seek=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item2->id)->get(); //echo $item->name.'<br>';
							foreach( $seek as $value):
									$acc_seek=$value->id; //echo $item->name.'-'.$value->name.'<br>'; 
									
									$find=DB::table('acc_trandetails')
									->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
									->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
									->where('acc_trandetails.tranwiths_id', $maincash_id)
									->where('acc_trandetails.com_id', $com_id)
									->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
									->where('acc_coas.id', $acc_seek)
									->first();
									isset($find->acc_id) && $find->acc_id >0 ? $flg='ok' : '';
										$seek2=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
										foreach( $seek2 as $value):
												$acc_seek=$value->id; //echo $value->name.'<br>'; 
												$find=DB::table('acc_trandetails')
												->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
												->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
												->where('acc_trandetails.tranwiths_id', $maincash_id)
												->where('acc_trandetails.com_id', $com_id)
												->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
												->where('acc_coas.id', $acc_seek)
												->first();
													isset($find->acc_id) && $find->acc_id >0 ? $flg='ok' : '';
													$seek3=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
													foreach( $seek3 as $value):
															$acc_seek=$value->id; //echo $value->name.'<br>'; 
															$find=DB::table('acc_trandetails')
															->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
															->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
															->where('acc_trandetails.tranwiths_id', $maincash_id)
															->where('acc_trandetails.com_id', $com_id)
															->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
															->where('acc_coas.id', $acc_seek)
															->first();
															isset($find->acc_id) && $find->acc_id>0 ? $flg='ok' : '';
													endforeach;
										endforeach;
							endforeach;
							 
							isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
							
							
							if (isset($item2->atype) && $item2->atype=='Group' && $flg=='ok'):
						?>
                        <tr>
                            <td style="padding-left:30px">{{ $item2->name }}</td>
                            <td id="cur"></td><td class=" text-right"></td>
                            <td id="cur"></td><td class=" text-right"></td>
							<td id="cur"></td><td class=" text-right"></td>
                          </tr>
                                   <!---------------second----------------->
                                    <?php 
							endif;		
										// find transaction of find group
										$records=array();	 
										if (isset($item2->atype) && $item2->atype=='Account'): //echo "hasan habib";
											$records=DB::table('acc_trandetails')->where('com_id',$com_id)->where('acc_id', $item2->id)->where('tranwiths_id', $maincash_id)->groupBy('acc_id')->get() ;
										elseif (isset($item2->atype) && $item2->atype=='Group'):
											$records=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item2->id)->groupBy('id')->get() ;
										endif;  
									$pay=0; $rcvd=0;                                 
									?>
                                    @foreach($records as $item3)
                                    <?php

									if (isset($item3->atype) && $item3->atype=='Account'):
										//echo $balance;
										// find account-wise transaction sum
										$sum=DB::table('acc_trandetails')
										->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
										->where('acc_trandetails.tranwiths_id', $maincash_id)
										->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
										->where('acc_trandetails.acc_id', $item3->id)
										->groupBy('acc_trandetails.acc_id')
										->sum('acc_trandetails.amount') ; 
										
                                        $sum > 0 ? $item3->amount=-$sum : $item3->amount=-$sum; 
										
                                        $pay=''; $rcvd=''; $bc=''; $dcur=''; $ccur=''; 
                                        // to tal calculation
                                        $ttl+=$item3->amount; $balance += $item3->amount;
										// to make sign Dr or Cr behind balance 
										$balance<0 ? $balances=substr(number_format($balance,2), 1).' '.$bc='Cr' : $balances= number_format($balance,2).' '. $bc='Dr';

                                        // make different pay and rcvd
                                        $item3->amount<0 ? $pay=substr(number_format($item3->amount, 2),1) :  '' ; 
                                        $item3->amount>0 ? $rcvd= (number_format($item3->amount, 2)) : '' ;
                                        
                                        $pay!='' ? $dcur=$cur : $dcur=''; $rcvd!='' ? $ccur=$cur : $ccur='';
                                        // make total of pay and rcvd and thier currency
                                        $item3->amount<0 ? $ttl_pay += $item3->amount :  $ttl_rcvd += $item3->amount ; //echo $ttl_rcvd;
                                        $ttl_pay!='' ? $tdcur=$cur : $tdcur=''; $ttl_rcvd!='' ? $tccur=$cur : $tccur='';
										// find transaction 
										$find=DB::table('acc_trandetails')
										->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
										->where('acc_trandetails.tranwiths_id', $maincash_id)
										->where('acc_tranmasters.com_id', $com_id)
										->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])																	
										->where('acc_trandetails.acc_id', $item3->id)
										->first(); 

										isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
										
										if ($flag==1):
                                    ?>
                                          <tr>
                                            <td style="padding-left:60px">{{ $item3->name }} </td>
                                            <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $rcvd }} </td>
                                            <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $pay }}</td>
                							<td id="cur"></td><td class=" text-right"></td>
                                          </tr>
                                      <?php
									  	endif;
									  endif;
									
									  // find child account has or not?
										$flg='';
										$seek=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item3->id)->get(); //echo $item->id.'<br>';
										foreach( $seek as $value):
												$acc_seek=$value->id; //echo $value->group_id.'<br>'; 
												
												$find=DB::table('acc_trandetails')
												->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
												->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
												->where('acc_trandetails.tranwiths_id', $maincash_id)
												->where('acc_trandetails.com_id', $com_id)
												->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
												->where('acc_coas.id', $acc_seek)
												->first(); //echo $find->acc_id;
												//if (isset($find->acc_id)): echo $find->acc_id; endif;
												isset($find->acc_id) && $find->acc_id >0 ? $flg='ok' : ''; //echo $flg;
													if ($flg==''):
													$seek2=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
													foreach( $seek2 as $value):
															$acc_seek=$value->id; //echo $value->name.'<br>'; 
															$find=DB::table('acc_trandetails')
															->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
															->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
															->where('acc_trandetails.tranwiths_id', $maincash_id)
															->where('acc_trandetails.com_id', $com_id)
															->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
															->where('acc_coas.id', $acc_seek)
															->first();
																if ($flg==''):
																isset($find->acc_id) && $find->acc_id >0 ? $flg='ok' : ''; //echo $flg.'0sama';
																$seek3=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
																foreach( $seek3 as $value):
																		$acc_seek=$value->id; //echo $value->name.'<br>'; 
																		$find=DB::table('acc_trandetails')
																		->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
																		->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
																		->where('acc_trandetails.tranwiths_id', $maincash_id)
																		->where('acc_trandetails.com_id', $com_id)
																		->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
																		->where('acc_coas.id', $acc_seek)
																		->first();
																		isset($find->acc_id) && $find->acc_id >0 ? $flg='ok' : ''; //echo $flg;
																endforeach;
																endif;
													endforeach;
													endif;
										endforeach;
										if (isset($item3->atype) && $item3->atype=='Group' && $flg=='ok'):
									  ?>
                                      <tr>
                                        <td style="padding-left:60px">{{ $item3->name }}</td>
                                        <td id="cur"></td><td class=" text-right"></td>
                                        <td id="cur"></td><td class=" text-right"></td>
            							<td id="cur"></td><td class=" text-right"></td>
                                      </tr>
               										<!----------------third---------------->
                                                    <?php 
									endif;
													if (isset($item3->atype) && $item3->atype=='Account'):
														$recordx=DB::table('acc_trandetails')->where('acc_id', $item3->id)->where('tranwiths_id', $maincash_id)->groupBy('acc_id')->get() ;
													elseif (isset($item3->atype) && $item3->atype=='Group'):
														$recordx=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item3->id)->groupBy('id')->get() ;
													endif;   
													$pay=0; $rcvd=0;                                                  
													?>
                                                    @foreach($recordx as $item4)
                                                    <?php 

													if (isset($item4->atype) && $item4->atype=='Account'):

														// find account-wise transaction sum
														$sum=DB::table('acc_trandetails')
														->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
														->where('acc_trandetails.tranwiths_id', $maincash_id)
														->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
														->where('acc_trandetails.acc_id', $item4->id)
														->where('acc_tranmasters.com_id', $com_id)
														->groupBy('acc_trandetails.acc_id')
														->sum('acc_trandetails.amount') ; 
								
                                                       $sum > 0 ? $item4->amount=-$sum : $item4->amount=-$sum; 
                                                        $pay=''; $rcvd=''; $bc=''; $dcur=''; $ccur=''; 
                                                        // to tal calculation
                                                        $ttl+=$item4->amount; $balance += $item4->amount;
                                                        
                                                        // make different pay and rcvd
                                                        $item4->amount<0 ? $pay=substr(number_format($item4->amount, 2),1) :  '' ; 
                                                        $item4->amount>0 ? $rcvd= number_format($item4->amount, 2) : '' ;
                                                        
                                                        $pay!='' ? $dcur=$cur : $dcur=''; $rcvd!='' ? $ccur=$cur : $ccur='';
                                                        // make total of pay and rcvd and thier currency
                                                        $item4->amount<0 ? $ttl_pay += $item4->amount :  $ttl_rcvd += $item4->amount ; //echo $ttl_rcvd;
                                                        $ttl_pay!='' ? $tdcur=$cur : $tdcur=''; $ttl_rcvd!='' ? $tccur=$cur : $tccur='';
														// find transaction 
														$find=DB::table('acc_trandetails')
														->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
														->where('acc_trandetails.tranwiths_id', $maincash_id)
														->where('acc_tranmasters.com_id', $com_id)
														->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])																		
														->where('acc_trandetails.acc_id', $item4->id)
														->first(); 
														isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
														
														if ($flag==1):
                                                        
                                                    ?>
                                                      <tr>
                                                        <td style="padding-left:90px">{{ $item4->name }}</td>
                                                        <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $rcvd }}</td>
                                                        <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $pay }}</td>
                            							<td id="cur"></td><td class=" text-right"></td>
                                                      </tr>
                                                      <?php 
													  	endif;
													  endif;
													  
													  // find child account has or not?
														$find=DB::table('acc_trandetails')
														->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
														->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
														->where('acc_trandetails.tranwiths_id', $maincash_id)
														->where('acc_trandetails.com_id', $com_id)
														->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
														->where('acc_coas.group_id', $item4->id)
														->first(); 
														isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
														
														if (isset($item4->atype) && $item4->atype=='Group' && $flag==1):
														 ?>
														 <tr>
															<td style="padding-left:90px">{{ $item4->name }}</td>
															<td id="cur"></td><td class=" text-right"></td>
															<td id="cur"></td><td class=" text-right"></td>
															<td id="cur"></td><td class=" text-right"></td>
														  </tr>

                                                                   
                                                                    <!--------------forth------------------>
                                                                    <?php 
													endif;				
																		$recordz=array();
																		if (isset($item4->atype) && $item4->atype=='Account'):
																			$recordz=DB::table('acc_trandetails')->where('acc_id', $item4->id)
																			->where('acc_trandetails.com_id', $com_id)
																			->where('tranwiths_id', $maincash_id)->groupBy('acc_id')->get() ;
																		elseif (isset($item4->atype) && $item4->atype=='Group'):
																			$recordz=DB::table('acc_coas')->where('group_id', $item4->id)->groupBy('id')->get() ;
																		endif;     
																		$pay=0; $rcvd=0;                                                
																		?>
                                                                    
                                                                    @foreach($recordz as $item5)
                                                                    <?php 

																	if (isset($item5->atype) && $item5->atype=='Account'):

																		// find account-wise transaction sum
																		$sum=DB::table('acc_trandetails')
																		->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
																		->where('acc_trandetails.tranwiths_id', $maincash_id)
																		->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])
																		->where('acc_trandetails.acc_id', $item5->id)
																		->where('acc_trandetails.com_id', $com_id)
																		->groupBy('acc_trandetails.acc_id')
																		->sum('acc_trandetails.amount') ; 
																		
																		$sum > 0 ? $item5->amount=-$sum : $item5->amount=-$sum;  
                                                                        $pay=''; $rcvd=''; $bc=''; $dcur=''; $ccur=''; 
                                                                        // to tal calculation
                                                                        $ttl+=$item5->amount; $balance += $item5->amount;
                                                                        
                                                                        // make different pay and rcvd
                                                                        $item5->amount<0 ? $pay= substr(number_format($item5->amount, 2),1) :  '' ; 
                                                                        $item5->amount>0 ? $rcvd=number_format($item5->amount, 2) : '' ;
                                                                        
                                                                        $pay!='' ? $dcur=$cur : $dcur=''; $rcvd!='' ? $ccur=$cur : $ccur='';
                                                                        // make total of pay and rcvd and thier currency
                                                                        $item5->amount<0 ? $ttl_pay += $item5->amount :  $ttl_rcvd += $item5->amount ; //echo $ttl_rcvd;
                                                                        $ttl_pay!='' ? $tdcur=$cur : $tdcur=''; $ttl_rcvd!='' ? $tccur=$cur : $tccur='';
																		
																		// find transaction 
																		$find=DB::table('acc_trandetails')
																		->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
																		->where('acc_trandetails.tranwiths_id', $maincash_id)
																		->where('acc_trandetails.com_id', $com_id)
																		->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])																		
																		->where('acc_trandetails.acc_id', $item5->id)
																		->first(); 
																		isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
																		
																		if ($flag==1):
                                                                        
                                                                    ?>
                                                                      <tr>
                                                                        <td style="padding-left:120px"><a href="{{ url('/tranmaster/ledger') }}">{{ $item5->name }}</a></td>
                                                                        <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $rcvd }} </td>
                                                                        <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $pay }}</td>
                                            							<td id="cur"></td><td class=" text-right"></td>
                                                                      </tr>
                                                                      <?php 
																	  	endif;
																	  endif; 
																	  //echo "osama";
																	  ?>
                                                                    @endforeach 
                                                                    <!----------------------------------------------->                                                     
                                                    @endforeach 
                                                    <!----------------------------------------------->                                      
                                    @endforeach 
                                    <!----------------------------------------------->
                          
                        @endforeach 

                   @endforeach 
                   		<?php 

							$ttl_pay!='' ? $ttl_pays= substr(number_format($ttl_pay,2),1) : '';
							$ttl_rcvd!='' ? $ttl_rcvds= number_format($ttl_rcvd,2) : '';
							$ttl_balance=$ttl_rcvd+$ttl_pay;
							$ttl_balances=number_format($ttl_balance,2);
							$ttl_balance< 0 ? $ttl_balances='('.substr($ttl_balances,1).')' : '';
						?>
                        <tr>
                            <td  class=" text-right">Total</td>
                            <td id="cur">{{ $tdcur }}</td><td class=" text-right">{{ $ttl_rcvds }}</td>
                            <td id="cur">{{ $tccur }}</td><td class=" text-right">{{ $ttl_pays }}</td>
                            <td id="cur">{{ $tccur }}</td><td class=" text-right">{{ $ttl_balances }}</td>
                        </tr>

                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Transaction->Receipt and Payment</td><td class="text-right">Report generated by: {{ $user_name }}</td></tr>
                </table>
            </div><!-- /.box-header -->
        </div>
     </div>
</div>
@endsection
@section('custom-scripts')

<script type="text/javascript">
        
    jQuery(document).ready(function($) {        
        $(".tranmaster").validate();
		$( "#dfrom" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
		$( "#dto" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    });
        
</script>

@endsection
