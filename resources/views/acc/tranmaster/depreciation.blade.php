@extends('app')

@section('htmlheader_title', 'Trandetail')

@section('contentheader_title', 'Voucher')
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
	#top { border-top: thick solid black; border-bottom: thick double black;}

</style>

@section('main-content')

 <div class="container">
 <div class="box" >
    <div class="table-responsive">
        <table  width="100%>
        <?php 
			$user_name=''; Session::has('user_name') ? $user_name=Session::get('user_name') : $user_name='';
			$months=array(''=>'Select ...', 1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');

			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h2 align="center">'.$com_name.'</h2></td></tr>';

			$data=array('acc_id'=>'','year'=>'','m_id'=>'','dto'=>'0000-00-00');
			
			Session::has('depm_id') ? 
            $data=array('m_id'=>Session::get('depm_id'),'year'=>Session::get('depyear')) : ''; 
			$period='For the Month of '. $months[$data['m_id']].'-'.$data['year'];

			strlen($data['m_id'])==1 ? $data['m_id']='0'.$data['m_id'] : '';
			$data['dto']=date($data['year'].'-'.$data['m_id'].'-t');
			if (isset($data['acc_id']) && $data['acc_id']>0):
				$acc=DB::table('acc_coas')->where('com_id',$com_id)->where('id',$data['acc_id'])->first();
				$acc_head=''; isset($acc) && $acc->id>0 ? $acc_head=$acc->name : $acc_head='';
			// for single account
			echo '<tr><td ><h3 class="pull-left">Group Account</h3></td>
				<td class="text-right" ><h3 aling="right">'.$acc_head.'</h3><h5 >'.$data['dto'].'</h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h4>Depreciation</h4><h5 >'.$period.'</h5></td></tr>';
			endif;

		?>
		</table>
            <table id="buyerinfo-table" class="table table-bordered">
                <thead>
                <tr><td colspan="4"><a href="{!! url('/tranmaster/depreciation?flag=filter') !!}"> Filter  </a>
                <?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'tranmaster/deprefilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('m_id', $langs['m_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('m_id', $months, null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('year', $langs['year'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                      {!! Form::select('year',  array('2013'=>'2013','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018'),date('Y'), ['class' => 'form-control', 'id'=>'dto', 'required']) !!}
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
                        <th class="col-md-8" id="nt">{{ $langs['acc_id'] }}</th>
                        <th class="col-md-2 text-right" >Fixed Assets <br> on {{ $data['dto'] }}</th>
                        <th class="col-md-2 text-right" >Depreciation Ratio(%)</th>
                        <th class="col-md-2 text-right" >Depreciation Amount</th>
                    </tr>
                </thead>

                <tbody>
				<?php 
                	$cur='Tk'; $debit=0; $credit=0; $balance=0; $ttl=0; //$balances='';
					$balances='';$balance=0; $ttl_debit=''; $ttl_credit=''; $ttl_balances='';$depreciation_ttl=''; $depreciation_ttls='';
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
                            <td><b>{{ $item1->name }}</b></td>
                            <td class=" text-right"></td>
                            <td class=" text-right"></td>

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
								
								// depreciation condition
								$dcon=DB::table('acc_coaconditions')->where('com_id',$com_id)->where('acc_id',$item2->id)->first();
								$dcon_ratio=''; isset($dcon) && $dcon->id>0 && $dcon->depreciation==1 ? $dcon_ratio=$dcon->dep_formula : $dcon_ratio='';
								$depreciation='';$depreciations='';
								if( $item2->amount> 0 && $dcon_ratio> 0):
									$depreciation= $item2->amount * $dcon_ratio /100 /12;
								endif;
								$depreciation> 0 ? $depreciations=number_format($depreciation,2) : '';
								$depreciation> 0 ? $depreciation_ttl +=$depreciation : '';
								if ($flag==1):
							?>
                                  <tr>
                                    <td style="padding-left:30px">{{ $item2->name }} </td>
                                    <td class=" text-right">{{ $debit }}</td>
                                    <td class=" text-right">{{ $dcon_ratio }} %</td>
                                    <td class=" text-right">{{ $depreciations }}</td>
        
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
                            <td style="padding-left:30px"><b>{{ $item2->name }}</b></td>
                            <td class=" text-right"></td>
                            <td class=" text-right"></td>

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

										// depreciation condition
										$dcon=DB::table('acc_coaconditions')->where('com_id',$com_id)->where('acc_id',$item3->id)->first();
										$dcon_ratio=''; isset($dcon) && $dcon->id> 0 && $dcon->depreciation==1 ? $dcon_ratio=$dcon->dep_formula : $dcon_ratio='';
										$depreciation='';$depreciations='';
										if( $item3->amount> 0 && $dcon_ratio> 0):
											$depreciation= $item3->amount * $dcon_ratio /100 /12;
										endif;
										$depreciation> 0 ? $depreciations=number_format($depreciation,2) : '';
										$depreciation> 0 ? $depreciation_ttl +=$depreciation : '';
										isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
										
										if ($flag==1):
                                    ?>
                                          <tr>
                                            <td style="padding-left:60px">{{ $item3->name }} </td>
                                            <td class=" text-right">{{ $debit }} </td>
                                            <td class=" text-right">{{ $dcon_ratio }} %</td>
                                            <td class=" text-right">{{ $depreciations }}</td>
                
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
                                        <td style="padding-left:60px"><b>{{ $item3->name }}</b></td>
                                        <td class=" text-right"></td>
                                        <td class=" text-right"></td>
            
                                      </tr>
               										<!----------------third---------------->
                                                    <?php 
									endif;			
													$recordx=array();
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

														// depreciation condition
														$dcon=DB::table('acc_coaconditions')->where('com_id',$com_id)->where('acc_id',$item4->id)->first();
														$dcon_ratio=''; isset($dcon) && $dcon->id> 0 &&  $dcon->depreciation==1 ? $dcon_ratio=$dcon->dep_formula : $dcon_ratio='';
														$depreciation='';$depreciations='';
														if( $item4->amount> 0 && $dcon_ratio> 0):
															$depreciation= $item4->amount * $dcon_ratio /100 /12;
														endif;
														$depreciation> 0 ? $depreciations=number_format($depreciation,2) : '';
														$depreciation> 0 ? $depreciation_ttl +=$depreciation : '';
														isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
										
														
														if ($flag==1):
                                                        
                                                    ?>
                                                      <tr>
                                                        <td style="padding-left:90px">{{ $item4->name }}</td>
                                                        <td class=" text-right">{{ $debit }}</td>
                                                        <td class=" text-right">{{ $dcon_ratio }} %</td>
                                                        <td class=" text-right">{{ $depreciations }}</td>
                            
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
															<td class=" text-right"></td>
															<td class=" text-right"></td>
								
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
                                                                        <td class=" text-right">{{ $debit }} 567</td>
                                                                        <td class=" text-right">{{ $credit }}</td>
                                            
                                                                      </tr>
                                                                      <?php 
																	  	endif;
																	  endif; 
																	  //echo "osama";
																	  ?>
                                                                            <!--------------fift------------------>
                                                                            <?php 
                                                                                $recordz=array();
                                                                                if (isset($item5->atype) && $item5->atype=='Account'): echo $item5->name;
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
                                                                                <td class=" text-right">{{ $debit }} 567</td>
                                                                                <td class=" text-right">{{ $credit }}</td>
                                                    
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
							$depreciation_ttl>0 ? $depreciation_ttls= number_format($depreciation_ttl,2) : '';
						?>
                        <tr>
                            <td  class=" text-right">Total</td>
                            <td class=" text-right" id="top">{{ $ttl_debits }}</td>
                            <td class=" text-right">{{ $ttl_credits }}</td>
                            <td class=" text-right" id="top">{{ $depreciation_ttls }}</td>
                        </tr>

                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Transaction->Trial Balance</td><td class="text-right">Report generated by: {{ $user_name}}</td></tr>
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
