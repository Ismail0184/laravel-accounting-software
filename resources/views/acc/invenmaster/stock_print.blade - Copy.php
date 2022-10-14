@extends('print')

@section('htmlheader_title', ' Stock')

@section('contentheader_title', 	  'Stock')
@section('main-content')
<style>
	#hdr td, #hdr th{ padding:5px }
	.qty { padding-right:50px;}
	.tables { font-size:10px}
	.rpt { font-size:12px}
	.tdate { font-size:10px}
	.cname { font-size:16px}
	.break {display:block; clear:both; page-break-after:always}
    tr { page-break-inside: avoid }

</style>


        <table width="100%  id="hdr">
        <?php 
			Session::put('lgdfrom', date('Y-m-01'));
			Session::put('lgdto', date('Y-m-d'));
			Session::put('lgwh_id', Session::get('sbwar_id'));
			//-- For stock ledger------
				Session::put('lgwh_id', '');
				Session::put('lgdfrom', date('Y-m-01'));
				Session::put('lgdto', date('Y-m-d'));
			//-----------------------------------------------
			//$x='';
			Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 
			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h3 align="center" class="cname">'.$com_name.'</h3></td></tr>';

			// data collection filter method by session	
			$data=array('war_id'=>'','group_id'=>'','dto'=>'0000-00-00');
			
			Session::has('sbdto') ? 
			$data=array('war_id'=>Session::get('sbwar_id'),'group_id'=>Session::get('sbgroup_id'),'dto'=>Session::get('sbdto')) : 
			$data=array('war_id'=>'','group_id'=>'','dto'=>date('Y-m-d')); 

			$wh=DB::table('acc_warehouses')->where('com_id',$com_id)->where('id',$data['war_id'])->first(); //echo $item->war_id;						
			$wh_name=''; isset($wh) && $wh->id > 0 ? $wh_name=$wh->name : $wh_name=''; //echo $wh_name;
			
			$data['group_id']> 0 ? $group_name=$p_groups[$data['group_id']] : $group_name='';

			if (isset($data['group_id']) && $data['group_id']>0):
				// for single account
				
				echo '<tr><td ><h3 class="pull-left rpt">Stock Balance</h3></td>
				<td class="text-right" ><h3 aling="right" class="rpt">Category : '.$group_name.'</h3><h5 ></h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2">
				<h4 class="rpt">Stock Balance</h4>
				<h4 class="rpt">Warehouse :'.$wh_name.'</h4>
				<h5 class="tdate">Dated on :'.$data['dto'].'</h5>
				</td></tr>';
			endif;
		?>
        
        </table>

            <table id="buyerinfo-table" class="table tables">
                <thead>
                    <tr>
                        <th class="col-md-1">{{ $langs['sl'] }}  </th>
                        <th class="col-md-3">{{ $langs['name'] }}  </th>
                        <th class="col-md-2 text-right">{{ $langs['qty'] }} </th>
                    </tr>
                </thead>
                <tbody>
                <?php 
					if (isset($data['group_id']) && $data['group_id'] > 0): 
							$product=DB::table('acc_products')->where('com_id',$com_id)->where('id', $data['group_id'])->get();
					endif;
				?>
                @foreach($product as $item)
                <?php
					//$item->name;
					$flag='';
					if ($item->ptype=='Product'): 
						$tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$item->id)->sum('qty');
						isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
					elseif ($item->ptype=='Top Group' && $flag==''): 
						$find=DB::table('acc_products')->where('com_id',$com_id)->where('group_id',$item->id)->get();
						foreach( $find as $items): //echo  $items->name;
							if ($items->ptype=='Product'): 
								$tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$items->id)->sum('qty');
								isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
							elseif ($items->ptype=='Group'  && $flag==''): 
								$find=DB::table('acc_products')->where('com_id',$com_id)->where('group_id',$items->id)->get();
								foreach( $find as $items):
									if ($items->ptype=='Product'):
										$tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$items->id)->sum('qty');
										isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
									elseif ($items->ptype=='Group'  && $flag==''):
										$find=DB::table('acc_products')->where('com_id',$com_id)->where('group_id',$items->id)->get();
										foreach( $find as $items):
											$tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$items->id)->sum('qty');
											isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
										endforeach;	
									endif;					
								endforeach;
							endif;					
						endforeach;
					endif;
					//echo $flag.' 1<br>';
					//echo $item->name.'<br>';
				?>
                @if ($item->ptype=='Top Group'): 
                <?php $qty=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',  $item->id)->sum('qty');  ?>
                <tr>
                       	<td colspan="3">{{ $item->name }}</td>
                 </tr>
                 @endif
                 		
                    	<?php $record = DB::table('acc_products')->where('com_id',$com_id)->where('group_id', $item->id)->orderby('sl')->get(); ?>  
				{{-- */$x=0;/* --}}
                        @foreach($record as $item)
							<?php
								//echo $item->name.'<br>';
                                $flag='';
                                if ($item->ptype=='Product'): //echo 123;
                                    $tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$item->id)->sum('qty');;
                                    isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
                                elseif ($item->ptype=='Group' && $flag==''): //echo 456;
                                    $find=DB::table('acc_products')->where('com_id',$com_id)->where('group_id',$item->id)->get();
                                    foreach( $find as $items): //echo  '-----'.$items->name.'<br>';
                                        if ($items->ptype=='Product'): //echo $items->id;
                                            $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
											->where('item_id',$items->id)->sum('qty');
                                            isset($tran) && $tran > 0 ? $flag='yes' : $flag=''; //echo $flag;
                                        elseif ($items->ptype=='Group'  && $flag==''): 
                                            $find=DB::table('acc_products')->where('com_id',$com_id)
											->where('group_id',$items->id)->get();
                                            foreach( $find as $items): 
                                                if ($items->ptype=='Product'): //echo  $items->name;
                                                    $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
													->where('item_id',$items->id)->sum('qty');
                                                    isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
                                                elseif ($items->ptype=='Group'  && $flag==''): 
                                                    $find=DB::table('acc_products')->where('com_id',$com_id)
													->where('group_id',$items->id)->get();
                                                    foreach( $find as $items): //echo  $items->name;
                                                        $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
														->where('item_id',$items->id)->sum('qty');
                                                        isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
                                                    endforeach;	
                                                endif;					
                                            endforeach;
                                        endif;					
                                    endforeach;
                                endif;
								
                            ?>
                            
                                @if( $flag=='yes')
								 <?php 
										if ($data['war_id']==''):
											$qty=DB::table('acc_invendetails')
											->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
											->where('acc_invenmasters.com_id',$com_id)
											->where('idate','<=', $data['dto'])->where('item_id',  $item->id)->sum('qty');
										else:
											$qty=DB::table('acc_invendetails')
											->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
											->where('acc_invenmasters.com_id',$com_id)
											->where('acc_invenmasters.wh_id',$data['war_id'])
											->where('idate','<=', $data['dto'])->where('item_id',  $item->id)->sum('qty');
										endif;
                                        $unit=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',  $item->id)->first();
                                        $unit_name='';
										if($qty !=null): 
											$unit=DB::table('acc_units')
											->where('id', $item->unit_id)->first() ; $unit_name='';
											isset( $unit) &&  $unit->id > 0 ? $unit_name= $unit->name :  $unit_name='';
										endif;
                                        $qtys=$qty !=null ? $qty.'  '.$unit_name : '';
										
										
                                     ?>
                                     @if($qtys!=='')
						               {{-- */$x++;/* --}}
                                        <tr>
                                        <td>{{ $x }}</td>
                                        <td style="padding-left:30px">{{ $item->name }}</td>
                                        <td class="text-right qty">{{ $qtys }}</td>
                                        </tr>
                                    @endif
                                @endif
									<?php $records = DB::table('acc_products')->where('com_id',$com_id)->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                                    @foreach($records as $item)
												<?php
                                            //echo $item->ptype;
                                            $flag='';
                                            if ($item->ptype=='Product'): //echo 123;
                                                $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
												->where('item_id',$item->id)->sum('qty');
                                                isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
                                            elseif ($item->ptype=='Group' && $flag==''): //echo 456;
                                                $find=DB::table('acc_products')->where('com_id',$com_id)
												->where('group_id',$item->id)->get();
                                                foreach( $find as $items): //echo  $items->name;
                                                    if ($items->ptype=='Product'): //echo 988;
                                                        $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
														->where('item_id',$items->id)->sum('qty');
                                                        isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
                                                    elseif ($items->ptype=='Group'  && $flag==''): 
                                                        $find=DB::table('acc_products')->where('com_id',$com_id)
														->where('group_id',$items->id)->get();
                                                        foreach( $find as $items): 
                                                            if ($items->ptype=='Product'): //echo  $items->name;
                                                                $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
																->where('item_id',$items->id)->sum('qty');
                                                                isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
                                                            elseif ($items->ptype=='Group'  && $flag==''): 
                                                                $find=DB::table('acc_products')->where('com_id',$com_id)
																->where('group_id',$items->id)->get();
                                                                foreach( $find as $items): //echo  $items->name;
                                                                    $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
																	->where('item_id',$items->id)->sum('qty');
                                                                    isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
                                                                endforeach;	
                                                            endif;					
                                                        endforeach;
                                                    endif;					
                                                endforeach;
                                            endif;
                                        ?>
            
                                            @if( $flag=='yes')
											 <?php 
													$qty=DB::table('acc_invendetails')
													->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
													->where('idate','<=', $data['dto'])->where('item_id',  $item->id)
													->where('acc_invendetails.war_id',$data['war_id'])->groupBy('item_id')->sum('qty'); //echo $qty.'-osama';
                                                    
													$unit=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',  $item->id)->first();
                                                    $qty !=null ? 
                                                    $unit=DB::table('acc_units')
                                                    ->where('id', $item->unit_id)->first() : '';
													isset( $unit) &&  $unit->id && $qty !=null> 0 ? $unit_name= $unit->name :  $unit_name='';
                                                    $qtys=$qty !=null ? $qty.'  '.$unit_name : '';
                                                 ?>
                                                 @if($qtys!=='')
								                {{-- */$x++;/* --}}
                                                   <tr>
                                        			<td>{{ $x }}</td>
                                                    <td style="padding-left:50px">{{ $item->name }}</td>
                                                    <td class="text-right qty">{{ $qtys }}</td>
                                                    </tr>
                                                @endif
                                            @endif
                                     
												<?php $recordz = DB::table('acc_products')->where('com_id',$com_id)->where('group_id', $item->id)
												->orderby('sl')->get(); ?>  
                                                @foreach($recordz as $item)
                    										<?php
                                                            //echo $item->ptype;
                                                            $flag='';
                                                            if ($item->ptype=='Product'): //echo 123;
                                                                $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
																->where('item_id',$item->id)->sum('qty');
                                                                 isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
                                                            elseif ($item->ptype=='Group' && $flag==''): //echo 456;
                                                                $find=DB::table('acc_products')->where('com_id',$com_id)
																->where('group_id',$item->id)->get();
                                                                foreach( $find as $items): //echo  $items->name;
                                                                    if ($items->ptype=='Product'): //echo 988;
                                                                        $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
																		->where('item_id',$items->id)->sum('qty');
                                                                        isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
                                                                    elseif ($items->ptype=='Group'  && $flag==''): 
                                                                        $find=DB::table('acc_products')->where('com_id',$com_id)
																		->where('group_id',$items->id)->get();
                                                                        foreach( $find as $items): 
                                                                            if ($items->ptype=='Product'): //echo  $items->name;
                                                                                $tran=DB::table('acc_invendetails')
																				->where('com_id',$com_id)->where('item_id',$items->id)
																				->sum('qty');
                                                                                isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
                                                                            elseif ($items->ptype=='Group'  && $flag==''): 
                                                                                $find=DB::table('acc_products')->where('com_id',$com_id)
																				->where('group_id',$items->id)->get();
                                                                                foreach( $find as $items): //echo  $items->name;
                                                                                    $tran=DB::table('acc_invendetails')
																					->where('com_id',$com_id)->where('item_id',$items
																					->id)->sum('qty');
                                                                                    isset($tran) && $tran > 0 ? $flag='yes' : $flag='';
                                                                                endforeach;	
                                                                            endif;					
                                                                        endforeach;
                                                                    endif;					
                                                                endforeach;
                                                            endif;
                                                        ?>                                                
                                                        @if( $flag=='yes')
														 <?php 
																$qty=DB::table('acc_invendetails')
																->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
																->where('idate','<=', $data['dto'])->where('item_id',  $item->id)
																->where('acc_invenmasters.wh_id',$data['war_id'])->sum('qty'); 
																$unit=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',  $item->id)->first();
																$qty !=null ? 
																$unit=DB::table('acc_units')
																->where('id', $item->unit_id)->first() : '';
																$qtys=$qty !=null ? $qty.'  '.$unit_name : '';
                                                             ?>
															 @if($qtys!=='')
                                                                 <tr>
                                                                <td style="padding-left:70px">{{ $item->name }}</td>
                                                                <td class="text-right qty">{{ $qtys }}</td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                 
														<?php $recordX = DB::table('acc_products')->where('com_id',$com_id)->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                                                        @foreach($recordX as $item)
<!--                                                        {{-- */$x++;/* --}}
-->																	<?php
                                                                    //echo $item->ptype;
                                                                    $flag='';
                                                                    if ($item->ptype=='Product'): //echo 123;
                                                                        $tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$item->id)->first();
                                                                        isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                                    elseif ($item->ptype=='Group' && $flag==''): //echo 456;
                                                                        $find=DB::table('acc_products')->where('com_id',$com_id)->where('group_id',$item->id)->get();
                                                                        foreach( $find as $items): //echo  $items->name;
                                                                            if ($items->ptype=='Product'): //echo 988;
                                                                                $tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$items->id)->first();
                                                                                isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                                            elseif ($items->ptype=='Group'  && $flag==''): 
                                                                                $find=DB::table('acc_products')->where('com_id',$com_id)->where('group_id',$items->id)->get();
                                                                                foreach( $find as $items): 
                                                                                    if ($items->ptype=='Product'): //echo  $items->name;
                                                                                        $tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$items->id)->first();
                                                                                        isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                                                    elseif ($items->ptype=='Group'  && $flag==''): 
                                                                                        $find=DB::table('acc_products')->where('com_id',$com_id)->where('group_id',$items->id)->get();
                                                                                        foreach( $find as $items): //echo  $items->name;
                                                                                            $tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$items->id)->first();
                                                                                            isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                                                        endforeach;	
                                                                                    endif;					
                                                                                endforeach;
                                                                            endif;					
                                                                        endforeach;
                                                                    endif;
																?>                                                
                                                                @if( $flag=='yes')
                                                                	 <?php 
																$qty=DB::table('acc_invendetails')->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
																->where('idate','<=', $data['dto'])->where('item_id',  $item->id)
																->where('acc_invenmasters.wh_id',$data['war_id'])->sum('qty'); 
																		$unit=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',  $item->id)->first();
																		$qty !=null ? 
																		$unit=DB::table('acc_units')
																		->where('id', $item->unit_id)->first() : '';
																		$qtys=$qty !=null ? $qty.'  '.$unit_name : '';
																		 ?>
                                                                    <td style="padding-left:90px">{{ $item->name }}</td>
                                                                    <td class="text-right qty">{{ $qtys }}</td>
                                                                    </tr>
                                                                @endif                                                         
                                                        @endforeach      
                                                 
                                                @endforeach                                      
                                     
                                    @endforeach                         
                         
                        @endforeach

                @endforeach

                </tbody>
            </table>
            <div class="break"></div>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Import->Product</td><td class="text-right">Report generated by: </td></tr>
                </table>
            </div><!-- /.box-header -->
@endsection

