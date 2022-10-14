@extends('print')

@section('htmlheader_title', 'Trandetail')

@section('contentheader_title', 'Trial Balance')
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
	body { padding:0px}
	#opn { margin:opx; padding:0px;}
	#dt { width:15%;} 
	#nt { width:30%; } 
	.tables { font-size:10px}
	.cname{ font-size:16px}
	.tdate { font-size:12px}
	.rpt { font-size:12px}

</style>

@section('main-content')

 <div class="container">
 <div class="box" >
        <table  width="100% class="table">
        <?php 
			$user_name=''; Session::has('user_name') ? $user_name=Session::get('user_name') : $user_name='';

			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h2 align="center" class="cname">'.$com_name.'</h2></td></tr>';

			$data=array('acc_id'=>'','dto'=>'0000-00-00');
			
			Session::has('tbdto') ? 
            $data=array('acc_id'=>Session::get('tbacc_id'),'dto'=>Session::get('tbdto')) : 
			$data=array('acc_id'=>'','dto'=>date('Y-m-d')); 
			
			if (isset($data['acc_id']) && $data['acc_id']>0):
				$acc=DB::table('acc_coas')->where('com_id',$com_id)->where('id',$data['acc_id'])->first();
				$acc_head=''; isset($acc) && $acc->id>0 ? $acc_head=$acc->name : $acc_head='';
			// for single account
			echo '<tr><td ><h3 class="pull-left">Group Account</h3></td>
				<td class="text-right" ><h3 aling="right" class="rpt">'.$acc_head.'</h3><h5 class="tdate">'.$data['dto'].'</h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h4 class="rpt">Trial Balance</h4><h5 class="tdate">'.$data['dto'].'</h5></td></tr>';
			endif;

		?>
		</table>
            <table id="buyerinfo-table" class="table tables">
                <thead>
                    <tr>
                        <th class="col-md-8" id="nt">{{ $langs['acc_id'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['debit'] }}</th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['credit'] }}</th>
                    </tr>
                </thead>
                <tbody>
				<?php 
                	$cur='Tk'; $debit=0; $credit=0; $balance=0; $ttl=0; //$balances='';
					$balances='';$balance=0; $ttl_debit=''; $ttl_credit=''; $ttl_balances='';
					$tdcur=''; $tccur=''; $ttl_debit=''; $ttl_credit=''; $ttl_balances='';   $ttl_debits=''; $ttl_credits='';  
					$atype='';          
					?>
                   <?php 
				   // to create group account
				   isset($data['acc_id']) && $data['acc_id']>0 ?
				   $tran=DB::table('acc_coas')->where('com_id',$com_id)->where('id', $data['acc_id'])->groupBy('id')->get() : '';
				   ?> 
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
									->where('tdate','<=',$data['dto'])
									->where('acc_trandetails.com_id',$com_id)
									->where('acc_coas.id', $acc_seek)
									->first();
									isset($find->acc_id) && $find->acc_id>0 ? $flg='ok' : '';
										$seek2=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
										foreach( $seek2 as $value):
												$acc_seek=$value->id; //echo $value->name.'<br>'; 
												$find=DB::table('acc_trandetails')
												->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
												->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
												->where('acc_trandetails.com_id',$com_id)
												->where('tdate','<=',$data['dto'])
												->where('acc_coas.id', $acc_seek)
												->first();
													isset($find->acc_id) && $find->acc_id>0 ? $flg='ok' : '';
													$seek3=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
													foreach( $seek3 as $value):
															$acc_seek=$value->id; //echo $value->name.'<br>'; 
															$find=DB::table('acc_trandetails')
															->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
															->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
															->where('acc_trandetails.com_id',$com_id)
															->where('tdate','<=',$data['dto'])
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
                  		<tr>
                            <td>{{ $item1->name }}</td>
                            <td id="cur"></td><td class=" text-right"></td>
                            <td id="cur"></td><td class=" text-right"></td>

                          </tr>
                                   <!--------------first------------------>
						<?php 
						endif;

						// find transaction of find group
						$details=array(); //echo $item1>name.'-osama';
						if (isset($item1->atype) && $item1->atype=='Account'): 
							$details=DB::table('acc_trandetails')->where('com_id',$com_id)->where('acc_id', $item1->id)->groupBy('acc_id')->get() ;
						elseif (isset($item1->atype) && $item1->atype=='Group'):
							$details=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item1->id)->groupBy('id')->get() ;
						endif;
						$debit=0; $credit=0;
						?>
                        @foreach($details as $item2)
                        <?php 
							//echo '-'.$item2->name.'='.$item2->id.'<br>';
							if (isset($item2->atype) && $item2->atype=='Account'):
							
								// find account-wise transaction sum
								$sum=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
								->where('tdate','<=',$data['dto'])
								->where('acc_trandetails.com_id',$com_id)
								->where('acc_trandetails.acc_id', $item2->id)
								->groupBy('acc_trandetails.acc_id')
								->sum('acc_trandetails.amount') ; 
								
								$item2->amount=$sum; 
								$debit=''; $credit=''; $bc=''; $dcur=''; $ccur=''; 
								// to tal calculation
								$ttl+=$item2->amount; $balance += $item2->amount; 
								
								// make different debit and credit
								$item2->amount>0 ? $debit=number_format($item2->amount, 2) :  '' ; 
								$item2->amount<0 ? $credit= substr(number_format($item2->amount, 2),1) : '' ;
								
								$debit!='' ? $dcur=$cur : $dcur=''; $credit!='' ? $ccur=$cur : $ccur='';
								// make total of debit and credit and thier currency
								$item2->amount>0 ? $ttl_debit += $item2->amount :  $ttl_credit += $item2->amount ; //echo $ttl_credit;
								$ttl_debit!='' ? $tdcur=$cur : $tdcur=''; $ttl_credit!='' ? $tccur=$cur : $tccur='';
								
								// find transaction 
								$find=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
								->where('tdate','<=',$data['dto'])			
								->where('acc_trandetails.com_id',$com_id)															
								->where('acc_trandetails.acc_id', $item2->id)
								->first(); 
								isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
								
								if ($flag==1):
							?>
                                  <tr>
                                    <td style="padding-left:30px">{{ $item2->name }}</td>
                                    <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }}</td>
                                    <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $credit }}</td>
        
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
									->where('acc_trandetails.com_id',$com_id)
									->where('tdate','<=',$data['dto'])
									->where('acc_coas.id', $acc_seek)
									->first();
									isset($find->acc_id) && $find->acc_id >0 ? $flg='ok' : '';
										$seek2=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
										foreach( $seek2 as $value):
												$acc_seek=$value->id; //echo $value->name.'<br>'; 
												$find=DB::table('acc_trandetails')
												->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
												->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
												->where('acc_trandetails.com_id',$com_id)
												->where('tdate','<=',$data['dto'])
												->where('acc_coas.id', $acc_seek)
												->first();
													isset($find->acc_id) && $find->acc_id >0 ? $flg='ok' : '';
													$seek3=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
													foreach( $seek3 as $value):
															$acc_seek=$value->id; //echo $value->name.'<br>'; 
															$find=DB::table('acc_trandetails')
															->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
															->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
															->where('tdate','<=',$data['dto'])
															->where('acc_trandetails.com_id',$com_id)
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

                          </tr>
                                   <!---------------second----------------->
                                    <?php 
							endif;		
										// find transaction of find group
										$records=array();	 
										if (isset($item2->atype) && $item2->atype=='Account'): 
											$records=DB::table('acc_trandetails')->where('acc_trandetails.com_id',$com_id)->where('acc_id', $item2->id)->groupBy('acc_id')->get() ;
										elseif (isset($item2->atype) && $item2->atype=='Group'): 
											$records=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item2->id)->groupBy('id')->get() ;
										endif;  
									$debit=0; $credit=0;                                 
									?>
                                    @foreach($records as $item3)
                                    <?php
									//echo '----'.$item3->name.'='.$item3->id.'<br>';
									if (isset($item3->atype) && $item3->atype=='Account'):
										
										// find account-wise transaction sum
										$sum=DB::table('acc_trandetails')
										->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
										->where('tdate','<=',$data['dto'])
										->where('acc_trandetails.com_id',$com_id)
										->where('acc_trandetails.acc_id', $item3->id)
										->groupBy('acc_trandetails.acc_id')
										->sum('acc_trandetails.amount') ; 
								
                                        $item3->amount=$sum; 
                                        $debit=''; $credit=''; $bc=''; $dcur=''; $ccur=''; 
                                        // to tal calculation
                                        $ttl+=$item3->amount; $balance += $item3->amount; 
                                        
                                        // make different debit and credit
                                        $item3->amount>0 ? $debit=number_format($item3->amount, 2) :  '' ; 
                                        $item3->amount<0 ? $credit= substr(number_format($item3->amount, 2),1) : '' ;
                                        
                                        $debit!='' ? $dcur=$cur : $dcur=''; $credit!='' ? $ccur=$cur : $ccur='';
                                        // make total of debit and credit and thier currency
                                        $item3->amount>0 ? $ttl_debit += $item3->amount :  $ttl_credit += $item3->amount ; //echo $ttl_credit;
                                        $ttl_debit!='' ? $tdcur=$cur : $tdcur=''; $ttl_credit!='' ? $tccur=$cur : $tccur='';
										// find transaction 
										$find=DB::table('acc_trandetails')
										->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
										->where('tdate','<=',$data['dto'])		
										->where('acc_trandetails.com_id',$com_id)																
										->where('acc_trandetails.acc_id', $item3->id)
										->first(); 
										isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
										
										if ($flag==1):
                                    ?>
                                          <tr>
                                            <td style="padding-left:60px">{{ $item3->name }}</td>
                                            <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }} </td>
                                            <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $credit }}</td>
                
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
												->where('tdate','<=',$data['dto'])
												->where('acc_trandetails.com_id',$com_id)
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
															->where('tdate','<=',$data['dto'])
															->where('acc_trandetails.com_id',$com_id)
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
																		->where('tdate','<=',$data['dto'])
																		->where('acc_trandetails.com_id',$com_id)
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
            
                                      </tr>
               										<!----------------third---------------->
                                                    <?php 
									endif;
													if (isset($item3->atype) && $item3->atype=='Account'): 
														$recordx=DB::table('acc_trandetails')->where('acc_trandetails.com_id',$com_id)->where('acc_id', $item3->id)->groupBy('acc_id')->get() ;
													elseif (isset($item3->atype) && $item3->atype=='Group'): 
														$recordx=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item3->id)->groupBy('id')->get() ;
													endif;   
													$debit=0; $credit=0;                                                  
													?>
                                                    @foreach($recordx as $item4)
                                                    <?php 
													
													if (isset($item4->atype) && $item4->atype=='Account'):

														// find account-wise transaction sum
														$sum=DB::table('acc_trandetails')
														->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
														->where('tdate','<=',$data['dto'])
														->where('acc_trandetails.com_id',$com_id)
														->where('acc_trandetails.acc_id', $item4->id)
														->where('acc_trandetails.com_id',$com_id)
														->groupBy('acc_trandetails.acc_id')
														->sum('acc_trandetails.amount') ; 
								
                                                        $item4->amount=$sum; 
                                                        $debit=''; $credit=''; $bc=''; $dcur=''; $ccur=''; 
                                                        // to tal calculation
                                                        $ttl+=$item4->amount; $balance += $item4->amount; 
                                                        
                                                        // make different debit and credit
                                                        $item4->amount>0 ? $debit=number_format($item4->amount, 2) :  '' ; 
                                                        $item4->amount<0 ? $credit= substr(number_format($item4->amount, 2),1) : '' ;
                                                        
                                                        $debit!='' ? $dcur=$cur : $dcur=''; $credit!='' ? $ccur=$cur : $ccur='';
                                                        // make total of debit and credit and thier currency
                                                        $item4->amount>0 ? $ttl_debit += $item4->amount :  $ttl_credit += $item4->amount ; //echo $ttl_credit;
                                                        $ttl_debit!='' ? $tdcur=$cur : $tdcur=''; $ttl_credit!='' ? $tccur=$cur : $tccur='';
														// find transaction 
														$find=DB::table('acc_trandetails')
														->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
														->where('tdate','<=',$data['dto'])	
														->where('acc_trandetails.com_id',$com_id)																	
														->where('acc_trandetails.acc_id', $item4->id)
														->first(); 
														isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
														
														if ($flag==1):
                                                        
                                                    ?>
                                                      <tr>
                                                        <td style="padding-left:90px">{{ $item4->name }}</td>
                                                        <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }}</td>
                                                        <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $credit }}</td>
                            
                                                      </tr>
                                                      <?php 
													  	endif;
													  endif;
													  
												  // find child account has or not?
													$flg='';
													$seek=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item4->id)->get(); //echo $item->id.'<br>';
													foreach( $seek as $value):
															$acc_seek=$value->id; //echo $value->group_id.'<br>'; 
															
															$find=DB::table('acc_trandetails')
															->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
															->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
															->where('tdate','<=',$data['dto'])
															->where('acc_trandetails.com_id',$com_id)
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
																		->where('tdate','<=',$data['dto'])
																		->where('acc_trandetails.com_id',$com_id)
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
																					->where('tdate','<=',$data['dto'])
																					->where('acc_trandetails.com_id',$com_id)
																					->where('acc_coas.id', $acc_seek)
																					->first();
																					isset($find->acc_id) && $find->acc_id >0 ? $flg='ok' : ''; //echo $flg;
																			endforeach;
																			endif;
																endforeach;
																endif;
													endforeach;
													if (isset($item4->atype) && $item4->atype=='Group' && $flg=='ok'):
														 ?>
														 <tr>
															<td style="padding-left:90px">{{ $item4->name }}</td>
															<td id="cur"></td><td class=" text-right"></td>
															<td id="cur"></td><td class=" text-right"></td>
								
														  </tr>

                                                                   
                                                                    <!--------------forth------------------>
                                                                    <?php 
													endif;				
																		$recordz=array();
																		if (isset($item4->atype) && $item4->atype=='Account'): 
																			$recordz=DB::table('acc_trandetails')->where('acc_trandetails.com_id',$com_id)->where('acc_id', $item4->id)->groupBy('acc_id')->get() ;
																		elseif (isset($item4->atype) && $item4->atype=='Group'): 
																			$recordz=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item4->id)->groupBy('id')->get() ;
																		endif;     
																		$debit=0; $credit=0;                                                
																		?>
                                                                    
                                                                    @foreach($recordz as $item5)
                                                                    <?php 
																	
																	if (isset($item5->atype) && $item5->atype=='Account'):

																		// find account-wise transaction sum
																		$sum=DB::table('acc_trandetails')
																		->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
																		->where('tdate','<=',$data['dto'])
																		->where('acc_trandetails.com_id',$com_id)	 
																		->where('acc_trandetails.acc_id', $item5->id)
																		->groupBy('acc_trandetails.acc_id')
																		->sum('acc_trandetails.amount') ; 
																		
																		$item5->amount=$sum; 
                                                                        $debit=''; $credit=''; $bc=''; $dcur=''; $ccur=''; 
                                                                        // to tal calculation
                                                                        $ttl+=$item5->amount; $balance += $item5->amount; 
                                                                        
                                                                        // make different debit and credit
                                                                        $item5->amount>0 ? $debit=number_format($item5->amount, 2) :  '' ; 
                                                                        $item5->amount<0 ? $credit= substr(number_format($item5->amount, 2),1) : '' ;
                                                                        
                                                                        $debit!='' ? $dcur=$cur : $dcur=''; $credit!='' ? $ccur=$cur : $ccur='';
                                                                        // make total of debit and credit and thier currency
                                                                        $item5->amount>0 ? $ttl_debit += $item5->amount :  $ttl_credit += $item5->amount ; //echo $ttl_credit;
                                                                        $ttl_debit!='' ? $tdcur=$cur : $tdcur=''; $ttl_credit!='' ? $tccur=$cur : $tccur='';
																		
																		// find transaction 
																		$find=DB::table('acc_trandetails')
																		->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
																		->where('tdate','<=',$data['dto'])	
																		->where('acc_trandetails.com_id',$com_id)																	
																		->where('acc_trandetails.acc_id', $item5->id)
																		->first(); 
																		isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
																		
																		if ($flag==1):
                                                                        
                                                                    ?>
                                                                      <tr>
                                                                        <td style="padding-left:120px">{{ $item5->name }}</td>
                                                                        <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }} 567</td>
                                                                        <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $credit }}</td>
                                            
                                                                      </tr>
                                                                      <?php 
																	  	endif;
																	  endif; 
																	  //echo "osama";
																	  ?>
                                                                            <!--------------fift------------------>
                                                                            <?php 
                                                                                $recordz=array();
                                                                                if (isset($item5->atype) && $item5->atype=='Account'): //echo $item5->name;
                                                                                    $recordz=DB::table('acc_trandetails')->where('acc_trandetails.com_id',$com_id)->where('acc_id', $item5->id)->groupBy('acc_id')->get() ;
                                                                                elseif (isset($item5->atype) && $item5->atype=='Group'):
                                                                                    $recordz=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item5->id)->groupBy('id')->get() ;
                                                                                endif;     
                                                                                $debit=0; $credit=0;                                                
                                                                                ?>
                                                                            
                                                                            @foreach($recordz as $item6)
                                                                            <?php 
                                                                            
                                                                            if (isset($item5->atype) && $item5->atype=='Account'):
        
                                                                                // find account-wise transaction sum
                                                                                $sum=DB::table('acc_trandetails')
                                                                                ->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
                                                                                ->where('tdate','<=',$data['dto'])
                                                                                ->where('acc_trandetails.com_id',$com_id)	 
                                                                                ->where('acc_trandetails.acc_id', $item6->id)
                                                                                ->groupBy('acc_trandetails.acc_id')
                                                                                ->sum('acc_trandetails.amount') ; 
                                                                                
                                                                                $item6->amount=$sum; 
                                                                                $debit=''; $credit=''; $bc=''; $dcur=''; $ccur=''; 
                                                                                // to tal calculation
                                                                                $ttl+=$item6->amount; $balance += $item6->amount; 
                                                                                
                                                                                // make different debit and credit
                                                                                $item6->amount>0 ? $debit=number_format($item6->amount, 2) :  '' ; 
                                                                                $item6->amount<0 ? $credit= substr(number_format($item6->amount, 2),1) : '' ;
                                                                                
                                                                                $debit!='' ? $dcur=$cur : $dcur=''; $credit!='' ? $ccur=$cur : $ccur='';
                                                                                // make total of debit and credit and thier currency
                                                                                $item6->amount>0 ? $ttl_debit += $item6->amount :  $ttl_credit += $item6->amount ; //echo $ttl_credit;
                                                                                $ttl_debit!='' ? $tdcur=$cur : $tdcur=''; $ttl_credit!='' ? $tccur=$cur : $tccur='';
                                                                                
                                                                                // find transaction 
                                                                                $find=DB::table('acc_trandetails')
                                                                                ->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
                                                                                ->where('tdate','<=',$data['dto'])	
                                                                                ->where('acc_trandetails.com_id',$com_id)																	
                                                                                ->where('acc_trandetails.acc_id', $item6->id)
                                                                                ->first(); 
                                                                                isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
                                                                                
                                                                                if ($flag==1):
                                                                                
                                                                            ?>
                                                                              <tr>
                                                                                <td style="padding-left:120px">{{ $item6->name }}</td>
                                                                                <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }} 567</td>
                                                                                <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $credit }}</td>
                                                    
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
                                    <!----------------------------------------------->
                          
                        @endforeach 

                   @endforeach 
                   		<?php 
							$ttl_debit>0 ? $ttl_debits= number_format($ttl_debit,2) : '';
							$ttl_credit<0 ? $ttl_credits= substr(number_format($ttl_credit,2),1) : '';
						?>
                        <tr>
                            <td  class=" text-right">Total</td>
                            <td id="cur">{{ $tdcur }}</td><td class=" text-right">{{ $ttl_debits }}</td>
                            <td id="cur">{{ $tccur }}</td><td class=" text-right">{{ $ttl_credits }}</td>
                        </tr>

                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless tables">
                <tr><td class="text-left">Source: Transaction->Trial Balance</td><td class="text-right">Report generated by: {{ $user_name}}</td></tr>
                </table>
            </div><!-- /.box-header -->
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
