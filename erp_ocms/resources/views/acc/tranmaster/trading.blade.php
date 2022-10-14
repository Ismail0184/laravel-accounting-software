@extends('app')

@section('htmlheader_title', 'Trading Account')

@section('contentheader_title', 'Trading Account')

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
	#cls { font-size:16px; font-weight:bold;}
	#top { border-top: thick double black;}
	#uper_single { border-top: thick solid black;}
	#grp { font-size:14px; font-weight:bold;}
</style>
@section('main-content')

 <div class="container">
 <div class="box" >
    <div class="table-responsive">
			<div class="box-header">
            <a href="{{ url('tranmaster/trading_print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('tranmaster/trading_pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('tranmaster/trading_pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('tranmaster/trading_excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('tranmaster/trading_csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('tranmaster/trading_word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>

            </div><!-- /.box-header -->        
        <table  width="100%>
        <?php 
			$user_name=''; Session::has('user_name') ? $user_name=Session::get('user_name') : $user_name='';

			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h2 align="center">'.$com_name.'</h2></td></tr>';

			$data=array('acc_id'=>'','dfrom'=>'0000-00-00','dto'=>'0000-00-00');
			Session::has('trdto') ? 
			$data=array('acc_id'=>Session::get('tracc_id'),'dfrom'=>Session::get('trdfrom'),'dto'=>Session::get('trdto')) : 
			$data=array('acc_id'=>'','dfrom'=>date('Y-m-01'),'dto'=>date('Y-m-d')); 

			if (isset($data['acc_id']) && $data['acc_id']>0):
				
			// for single account
			echo '<tr><td ><h3 class="pull-left">Group Account</h3></td>
				<td class="text-right" ><h3 aling="right">'.$acccoa[$data['acc_id']].'</h3><h5 >'.$data['dto'].'</h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h4>Trading Account</h4><h5 >'.$data['dfrom'].' to '.$data['dto'].'</h5></td></tr>';
			endif;
			$g_total='';
		?>
		</table>
            <table id="buyerinfo-table" class="table table-bordered ">
                <thead>
                <tr><td colspan="8"><a href="{!! url('/tranmaster/trading?flag=filter') !!}"> Filter  </a>
                <?php 
                    	$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'tranmaster/trfilter', 'class' => 'form-horizontal']) !!}
            
                            <div class="form-group">
                                {!! Form::label('acc_id', $langs['acc_id'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::select('acc_id', $acccoa, null, ['class' => 'form-control']) !!}
                                </div>    
                            </div>
                            <div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  null, ['class' => 'form-control', 'id'=>'dfrom', 'required']) !!}
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
                        <th class="col-md-8" id="nt">{{ $langs['acc_id'] }}</th>
                        <th class="col-md-2 text-right" colspan="2"></th>
                        <th class="col-md-2 text-right" colspan="2">{{ $langs['amount'] }}</th>
                    </tr>
                </thead>
                <tbody>
				<?php 
                	$cur='Tk'; $debit=0; $credit=0; $balance=0;  $revenue=''; $pls=''; $ttls='';
					$balances='';$balance=0; $ttl_debit=''; $ttl_credit=''; $ttl_balances='';
					$tdcur=''; $tccur=''; $ttl_debit=''; $ttl_credit=''; $ttl_balances='';   $ttl_debits=''; $ttl_credits='';  
					$atype='';  $asset=''; $liabi=''; $ttl='';           
					?>
                   <?php 
				   // to create group account
				   isset($data['acc_id']) && $data['acc_id']>0 ?
				   $tran=DB::table('acc_coas')->where('com_id',$com_id)->where('id', $data['acc_id'])->groupBy('sl')->get() : '';
				   ?> 
                  @foreach($tran as $item)
                  	<?php
					 //DB::table('acc_coas1')->get();
						// find child account has or not?
						$flg='';
							$seek=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item->id)->get(); //echo $item->name.'<br>';
							foreach( $seek as $value):
									$acc_seek=$value->id; //echo $value->name.'<br>'; 
									
									$find=DB::table('acc_trandetails')
									->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
									->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
									->where('tdate','<=',$data['dto'])
									->where('acc_tranmasters.com_id',$com_id)
									->where('acc_coas.id', $acc_seek)
									->first();
									isset($find->acc_id) && $find->acc_id >0 ? $flg='ok' : '';
										$seek2=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
										foreach( $seek2 as $value):
												$acc_seek=$value->id; //echo $value->name.'<br>'; 
												$find=DB::table('acc_trandetails')
												->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
												->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
												->where('tdate','<=',$data['dto'])
												->where('acc_tranmasters.com_id',$com_id)
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
															->where('acc_tranmasters.com_id',$com_id)
															->where('acc_coas.id', $acc_seek)
															->first();
															isset($find->acc_id) >0  && $find->acc_id? $flg='ok' : '';
													endforeach;
										endforeach;
							endforeach;
							 
//						isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
	
						// find transaction of find group
						if (isset($item->atype) && $item->atype=='Account'): 
							$details=DB::table('acc_trandetails')->where('acc_id', $item->id)->groupBy('acc_id')->get() ;
						elseif (isset($item->atype) && $item->atype=='Group'):
							$details=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item->id)->groupBy('id')->get() ;
						endif;
						
						// to calculate sum of fixed asset group
						$ttl='';     
						?>
                        @foreach($details as $item)
                        <?php 
							if (isset($item->atype) && $item->atype=='Account'):
								
								// find account-wise transaction sum
								$sum=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
								->where('tdate','<=',$data['dto'])
								->where('acc_trandetails.acc_id', $item->id)
								->groupBy('acc_trandetails.acc_id')
								->sum('acc_trandetails.amount') ; 
								
								$item->amount +=$sum; 
								$debit=''; $credit=''; $bc=''; $dcur=''; $ccur=''; 
								// to tal calculation
								$ttl+=$item->amount; $balance += $item->amount; //echo $ttl.'<br>';
								
								// to create amount and formate
								$item->amount <0  ? $debits= substr($item->amount,1) :  $debits= $item->amount; 
								$debit=number_format($debits, 2); 
								
								$debit!='' ? $dcur=$cur : $dcur=''; $credit!='' ? $ccur=$cur : $ccur='';
								// make total of debit and credit and thier currency
								$item->amount>0 ? $ttl_debit += $item->amount :  $ttl_credit += $item->amount ; //echo $ttl_credit;
								$ttl_debit!='' ? $tdcur=$cur : $tdcur=''; $ttl_credit!='' ? $tccur=$cur : $tccur='';
								
								// find transaction 
								$find=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
								->where('tdate','<=',$data['dto'])																		
								->where('acc_trandetails.acc_id', $item->id)
								->first(); 
								isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
								
								if ($flag==1):
							?>
                                  <tr>
                                    <td style="padding-left:30px">{{ $item->name }} </td>
                                    <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }}</td>
                                    <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $credit }}</td>
        
                                  </tr>
							
							<?php 
								endif;
							
							endif;
							
							// find child account has or not?
							$flg=''; $ttl=''; $ttls=''; $dcur='';
							$seek=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item->id)->get(); //echo $item->sl.'<br>';
							$sl=$item->sl;
							foreach( $seek as $value):
									$acc_seek=$value->id; //echo $value->name.'<br>'; 
									
									$find=DB::table('acc_trandetails')
									->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
									->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
									->where('tdate','<=',$data['dto'])
									->where('acc_tranmasters.com_id',$com_id)
									->where('acc_coas.id', $acc_seek)
									->first();
									isset($find->acc_id) && $find->acc_id >0 ? $flg='ok' : '';
										$seek2=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$value->id)->get(); 
										foreach( $seek2 as $value):
												$acc_seek=$value->id; //echo $value->name.'<br>'; 
												$find=DB::table('acc_trandetails')
												->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
												->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
												->where('tdate','<=',$data['dto'])
												->where('acc_tranmasters.com_id',$com_id)
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
															->where('acc_tranmasters.com_id',$com_id)
															->where('acc_coas.id', $acc_seek)
															->first();
															isset($find->acc_id) && $find->acc_id>0 ? $flg='ok' : '';
													endforeach;
										endforeach;
							endforeach;
							 
							isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
							
							
							if (isset($item->atype) && $item->atype=='Group' && $flg=='ok'):
							$item->name=='Revenue' ? $revenue=$item->name : $revenue='';
						?>
                        <tr>
                            <td style="padding-left:30px" id='grp'>{{ $item->name }} </td>
                            <td id="cur"></td><td class=" text-right"></td>
                            <td id="cur"></td><td class=" text-right"></td>

                          </tr>
                                   <!---------------second----------------->
                                    <?php 
							endif;		
										
										// find transaction of find group
										if (isset($item->atype) && $item->atype=='Account'): 
											$records=DB::table('acc_trandetails')->where('acc_id', $item->id)->groupBy('acc_id')->get() ;
										elseif (isset($item->atype) && $item->atype=='Group'): 
											$records=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item->id)->groupBy('id')->get() ;
										endif;   
										$ttl=''; $total='';    
									?>
                                    @foreach($records as $item)
                                    <?php
									
									if (isset($item->atype) && $item->atype=='Account'):
									
										// find account-wise transaction sum
										$sum=DB::table('acc_trandetails')
										->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
										->where('tdate','<=',$data['dto'])
										->where('acc_trandetails.acc_id', $item->id)
										->groupBy('acc_trandetails.acc_id')
										->sum('acc_trandetails.amount') ; 
								
                                        $item->amount=$sum; 
                                        $debit=''; $credit=''; $bc=''; $dcur=''; $ccur=''; 
                                        // total calculation
                                        $ttl+=$item->amount; $balance += $item->amount; 
                                        $total+=$item->amount; $g_total+=$item->amount;
										// to create amount and formate
										$item->amount <0  ? $debits= substr($item->amount,1) :  $debits= $item->amount; 
										$debit=number_format($debits, 2); 
                                        
                                        $debit!='' ? $dcur=$cur : $dcur=''; $credit!='' ? $ccur=$cur : $ccur='';
                                        // make total of debit and credit and thier currency
                                        $item->amount>0 ? $ttl_debit += $item->amount :  $ttl_credit += $item->amount ; //echo $ttl_credit;
                                        $ttl_debit!='' ? $tdcur=$cur : $tdcur=''; $ttl_credit!='' ? $tccur=$cur : $tccur='';
										// find transaction 
										$find=DB::table('acc_trandetails')
										->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
										->where('tdate','<=',$data['dto'])																		
										->where('acc_trandetails.acc_id', $item->id)
										->first(); 
										isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
										
										if ($flag==1):
                                    ?>
                                          <tr>
                                            <td style="padding-left:60px">{{ $item->name }}</td>
                                            <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }}</td>
                                            <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $credit }}</td>
                
                                          </tr>
                                      <?php
									  	endif;
									  endif;
									// create manufacturing account
								$man=DB::table('acc_coas')->where('com_id',$com_id)->where('name','Manufacturing Account')->first();
								$man_id=''; isset($man) && $man->id>0 ? $man_id=$man->id : $man_id='';
								$pls=DB::table('acc_trandetails')
								->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
								->join('acc_coas', 'acc_trandetails.acc_id','=', 'acc_coas.id')
								->where('tdate','<=',$data['dto'])
								->where('acc_tranmasters.com_id',$com_id)
								->where('topGroup_id',$man_id)
								->sum('acc_trandetails.amount') ; 
								
								$pls> 0 ? $pl_text="Process cost" : $pl_text="";
								$pls> 0 ? $pl=number_format($pls, 2) : $pl='('.substr(number_format($pls, 2), 1).')';
								$pls!='' ? $bcur=$cur : $bcur=''; 
								if (isset($pls) && $pls!='' && $item->name=='Export'):	
								?>
									<!-- Group Head-->
									<tr>
										<td id='grp' style="padding-left:60px">Less: {{ $pl_text }}<br> (Transfered from Manufacturing Account)</td>
										<td id="cur">{{ $bcur }}</td><td class=" text-right">{{ $pl }}</td>
										<td id="cur"></td><td class=" text-right"></td>
			
									  </tr>
									<?php 
									endif;
									//echo $total.'-osama';
									$gttl=''; $gttls='';
									$gttl =$total+$pls;
									$gttl > 0 ? $pl_sign="Gross Loss " : $pl_sign="Gross Profit";
									$gttl <0 ? $gttl=substr($gttl,1) : '';
									$gttl!='' ? $gttls=number_format($gttl, 2) : ''; 
									$gttls !='' ?  $dcur=$cur : '';
									if ($gttl!='' && $item->name=='Export'):
									?>
                                     <tr>
                                        <td style="padding-left:120px">{{ $pl_sign }}</td>
                                        <td id="cur">{{ $dcur }}</td><td class=" text-right" id="uper_single">{{ $gttls }}</td>
                                        <td id="cur"></td><td class=" text-right" id=""></td>
                                      </tr>
							         <?php endif;      

									  // find child account has or not?
										$flg='';
										$seek=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id',$item->id)->get(); //echo $item->id.'<br>';
										foreach( $seek as $value):
												$acc_seek=$value->id; //echo $value->group_id.'<br>'; 
												
												$find=DB::table('acc_trandetails')
												->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
												->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
												->where('tdate','<=',$data['dto'])
												->where('acc_tranmasters.com_id',$com_id)
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
															->where('acc_tranmasters.com_id',$com_id)
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
																		->where('acc_tranmasters.com_id',$com_id)
																		->where('acc_coas.id', $acc_seek)
																		->first();
																		isset($find->acc_id) && $find->acc_id >0 ? $flg='ok' : ''; //echo $flg;
																endforeach;
																endif;
													endforeach;
													endif;
										endforeach;
										if (isset($item->atype) && $item->atype=='Group' && $flg=='ok'):
									  ?>
                                      <tr>
                                        <td style="padding-left:60px">{{ $item->name }}</td>
                                        <td id="cur"></td><td class=" text-right"></td>
                                        <td id="cur"></td><td class=" text-right"></td>
            
                                      </tr>
               										<!----------------third---------------->
                                                    <?php 
									endif;
													if (isset($item->atype) && $item->atype=='Account'):
														$recordx=DB::table('acc_trandetails')->where('acc_id', $item->id)->groupBy('acc_id')->get() ;
													elseif (isset($item->atype) && $item->atype=='Group'):
														$recordx=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item->id)->groupBy('id')->get() ;
													endif;                                 
													                       
													?>
                                                    @foreach($recordx as $item)
                                                    <?php 
													if (isset($item->atype) && $item->atype=='Account'):
														
														// find account-wise transaction sum
														$sum=DB::table('acc_trandetails')
														->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
														->where('tdate','<=',$data['dto'])
														->where('acc_trandetails.acc_id', $item->id)
														->groupBy('acc_trandetails.acc_id')
														->sum('acc_trandetails.amount') ; 
								
                                                        $item->amount=$sum; 
                                                        $debit=''; $credit=''; $bc=''; $dcur=''; $ccur=''; 
                                                        // to tal calculation
                                                        $ttl+=$item->amount; $balance += $item->amount;
                                                        $sl<4 ? $asset +=$item->amount : $liabi += $item->amount ; //echo $asset.' -2<br>';
														
														// to create amount and formate
														$item->amount <0  ? $debits= substr($item->amount,1) :  $debits= $item->amount; 
														$debit=number_format($debits, 2); 
                                                        
                                                        $debit!='' ? $dcur=$cur : $dcur=''; $credit!='' ? $ccur=$cur : $ccur='';
                                                        // make total of debit and credit and thier currency
                                                        $item->amount>0 ? $ttl_debit += $item->amount :  $ttl_credit += $item->amount ; //echo $ttl_credit;
                                                        $ttl_debit!='' ? $tdcur=$cur : $tdcur=''; $ttl_credit!='' ? $tccur=$cur : $tccur='';
														// find transaction 
														$find=DB::table('acc_trandetails')
														->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
														->where('tdate','<=',$data['dto'])																		
														->where('acc_trandetails.acc_id', $item->id)
														->first(); 
														isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
														
														if ($flag==1):
                                                        
                                                    ?>
                                                      <tr>
                                                        <td style="padding-left:90px">{{ $item->name }}</td>
                                                        <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }}</td>
                                                        <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $credit }}</td>
                            
                                                      </tr>
                                                      <?php 
													  	endif;
													  endif;
													  
													  // find child account has or not?
														$find=DB::table('acc_trandetails')
														->join('acc_coas', 'acc_trandetails.acc_id', '=', 'acc_coas.id')
														->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
														->where('tdate','<=',$data['dto'])
														->where('acc_tranmasters.com_id',$com_id)
														->where('acc_coas.group_id', $item->id)
														->first(); 
														isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
														
														if (isset($item->atype) && $item->atype=='Group' && $flag==1):
														 ?>
														 <tr>
															<td style="padding-left:90px">{{ $item->name }}</td>
															<td id="cur"></td><td class=" text-right"></td>
															<td id="cur"></td><td class=" text-right"></td>
								
														  </tr>

                                                                   
                                                                    <!--------------forth------------------>
                                                                    <?php 
																	
													endif;				
																		$recordz=array();
																		if (isset($item->atype) && $item->atype=='Account'):
																			$recordz=DB::table('acc_trandetails')->where('acc_id', $item->id)->groupBy('acc_id')->get() ;
																		elseif (isset($item->atype) && $item->atype=='Group'):
																			$recordz=DB::table('acc_coas')->where('com_id',$com_id)->where('group_id', $item->id)->groupBy('id')->get() ;
																		endif;                                                     
																		?>
                                                                    
                                                                    @foreach($recordz as $item)
                                                                    <?php 
																	if (isset($item->atype) && $item->atype=='Account'):
																		
																		// find account-wise transaction sum
																		$sum=DB::table('acc_trandetails')
																		->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
																		->where('tdate','<=',$data['dto'])	 
																		->where('acc_trandetails.acc_id', $item->id)
																		->groupBy('acc_trandetails.acc_id')
																		->sum('acc_trandetails.amount') ; 
								
                                                                        $item->amount=$sum; 
                                                                        $debit=''; $credit=''; $bc=''; $dcur=''; $ccur=''; 
                                                                        // to tal calculation
                                                                        $ttl+=$item->amount; $balance += $item->amount;
                                                                        $sl<4 ? $asset +=$item->amount : $liabi += $item->amount ; //echo $asset.' -3<br>';
																		
																		// to create amount and formate
																		$item->amount <0  ? $debits= substr($item->amount,1) :  $debits= $item->amount; 
																		$debit=number_format($debits, 2); 
                                                                        
                                                                        $debit!='' ? $dcur=$cur : $dcur=''; $credit!='' ? $ccur=$cur : $ccur='';
                                                                        // make total of debit and credit and thier currency
                                                                        $item->amount>0 ? $ttl_debit += $item->amount :  $ttl_credit += $item->amount ; //echo $ttl_credit;
                                                                        $ttl_debit!='' ? $tdcur=$cur : $tdcur=''; $ttl_credit!='' ? $tccur=$cur : $tccur='';
																		
																		// find transaction 
																		$find=DB::table('acc_trandetails')
																		->join('acc_tranmasters', 'acc_trandetails.tm_id','=', 'acc_tranmasters.id')
																		->where('tdate','<=',$data['dto'])																		
																		->where('acc_trandetails.acc_id', $item->id)
																		->first(); 
																		isset($find->acc_id) ? $flag=1 : $flag=0; //echo $flag;
																		
																		if ($flag==1):
                                                                        
                                                                    ?>
                                                                      <tr>
                                                                        <td style="padding-left:120px">{{ $item->name }}</td>
                                                                        <td id="cur">{{ $dcur }}</td><td class=" text-right">{{ $debit }}</td>
                                                                        <td id="cur">{{ $ccur }}</td><td class=" text-right">{{ $credit }}</td>
                                            
                                                                      </tr>
                                                                      <?php 
																	  	endif;
																	  endif; ?>
                                                                    @endforeach 
                                                                    <!---------------------forth-------------------------->                                                     
                                                    @endforeach 
                                                    <!-----------------------third------------------------>   
                                   
                                    @endforeach 
                                    <!-------------------second---------------------------->
                                 
                                 
                                    <?php
									$revenue!='' ? $ttl += $pls : ''; 
									$ttl > 0 ? $pl_sign="Sub total" : $pl_sign="Sub total";
									$ttl <0 ? $ttl=substr($ttl,1) : '';
									$ttl!='' ? $ttls=number_format($ttl, 2) : ''; 
									$ttls !='' ?  $dcur=$cur : '';
									if ($ttl!=''):
									?>
                                     <tr>
                                        <td class="text-right">{{ $pl_sign }} </td>
                                        <td id="cur"></td><td class=" text-right"></td>
                                        <td id="cur">{{ $dcur }}</td><td class=" text-right" id="">{{ $ttls }}</td>
                                      </tr>
							         <?php endif; $ttl='';?>          
                        @endforeach 

                   @endforeach 
                                    <?php
									
									$ttl += $pls+$g_total;
									$ttl > 0 ? $pl_sign="Balance" : $pl_sign="Balance";  //echo $ttl.'-osama';
									$ttl <0 ? $ttl=substr($ttl,1) : '';
									$ttl!='' ? $ttls=number_format($ttl, 2) : ''; 
									$ttls !='' ?  $dcur=$cur : '';
									if ($ttl!=''):
									?>
                                     <tr>
                                        <td class="text-right">{{ $pl_sign }} <br> (Transfred to Profit anf Loss Account)</td>
                                        <td id="cur"></td><td class=" text-right"></td>
                                        <td id="cur">{{ $dcur }}</td><td class=" text-right" id="top">{{ $ttls }}</td>
                                      </tr>
							         <?php endif; $ttl='';?>          

                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Transaction->Trading Account</td><td class="text-right">Report generated by: {{ $user_name }}</td></tr>
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
