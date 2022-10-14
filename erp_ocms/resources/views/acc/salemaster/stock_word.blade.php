@extends('word')

@section('htmlheader_title', $langs['edit'] . ' Trandetail')

@section('contentheader_title', 	  'Inventory')
@section('main-content')
<style>
	#hdr td, #hdr th{ padding:5px }
</style>

 <div class="container">
 <div class="box" >
         <div class="box-header">
        </div><!-- /.box-header -->

    <div class="table-responsive">
        <table  width="100%  id="hdr">
        <?php 
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; 
			isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h1 align="center">'.$com_name.'</h1></td></tr>';

			// data collection filter method by session	
			$data=array('acc_id'=>'','dto'=>'0000-00-00');
			
			Session::has('sbdto') ? 
			$data=array('acc_id'=>Session::get('sbacc_id'),'dto'=>Session::get('sbdto')) : ''; 
			
			$data['acc_id']> 0 ? $group_name=$p_groups[$data['acc_id']] : $group_name='';

			if (isset($data['acc_id']) && $data['acc_id']>0):
				// for single account
				
				echo '<tr><td ><h3 class="pull-left">Stock Balance</h3></td>
				<td class="text-right" ><h3 aling="right">Category : '.$group_name.'</h3><h5 ></h5></td></tr>';
			else:
				// for multiple account
				echo '<tr><td class="text-center" colspan="2"><h5>Stock Balance</h5><h5 >'.$data['dto'].'</h5></td></tr>';
			endif;
		?>
        
        </table>

            <table id="buyerinfo-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-3">{{ $langs['name'] }}  </th>
                        <th class="col-md-2 text-right">{{ $langs['qty'] }} </th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
                <?php 
					if (isset($data['acc_id']) && $data['acc_id'] > 0): 
							$product=DB::table('acc_products')->where('id', $data['acc_id'])->get();
					endif;
				?>
                @foreach($product as $item)
               {{-- */$x++;/* --}}
                <?php
					//$item->name;
					$flag='';
					if ($item->ptype=='Product'): 
						$tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$item->id)->first();
						isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
					elseif ($item->ptype=='Top Group' && $flag==''): 
						$find=DB::table('acc_products')->where('com_id',$com_id)->where('group_id',$item->id)->get();
						foreach( $find as $items): //echo  $items->name;
							if ($items->ptype=='Product'): 
								$tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$items->id)->first();
								isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
							elseif ($items->ptype=='Group'  && $flag==''): 
								$find=DB::table('acc_products')->where('com_id',$com_id)->where('group_id',$items->id)->get();
								foreach( $find as $items):
									if ($items->ptype=='Product'):
										$tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$items->id)->first();
										isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
									elseif ($items->ptype=='Group'  && $flag==''):
										$find=DB::table('acc_products')->where('com_id',$com_id)->where('group_id',$items->id)->get();
										foreach( $find as $items):
											$tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$items->id)->first();
											isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
										endforeach;	
									endif;					
								endforeach;
							endif;					
						endforeach;
					endif;
					//echo $flag.' 1<br>';
					//echo $item->name.'<br>';
				?>
                @if( $flag=='yes')
                <?php $qty=DB::table('acc_invendetails')->where('item_id',  $item->id)->sum('qty');  ?>
                <tr>
                       	<td>{{ $item->name }}</td>
                 </tr>
                 @endif
                 		
                    	<?php $record = DB::table('acc_products')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                        @foreach($record as $item)
                        {{-- */$x++;/* --}}
							<?php
								//echo $item->name.'<br>';
                                $flag='';
                                if ($item->ptype=='Product'): //echo 123;
                                    $tran=DB::table('acc_invendetails')->where('com_id',$com_id)->where('item_id',$item->id)->first();
                                    isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                elseif ($item->ptype=='Group' && $flag==''): //echo 456;
                                    $find=DB::table('acc_products')->where('com_id',$com_id)->where('group_id',$item->id)->get();
                                    foreach( $find as $items): //echo  '-----'.$items->name.'<br>';
                                        if ($items->ptype=='Product'): //echo $items->id;
                                            $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
											->where('item_id',$items->id)->first();
                                            isset($tran) && $tran->id > 0 ? $flag='yes' : $flag=''; //echo $flag;
                                        elseif ($items->ptype=='Group'  && $flag==''): 
                                            $find=DB::table('acc_products')->where('com_id',$com_id)
											->where('group_id',$items->id)->get();
                                            foreach( $find as $items): 
                                                if ($items->ptype=='Product'): //echo  $items->name;
                                                    $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
													->where('item_id',$items->id)->first();
                                                    isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                elseif ($items->ptype=='Group'  && $flag==''): 
                                                    $find=DB::table('acc_products')->where('com_id',$com_id)
													->where('group_id',$items->id)->get();
                                                    foreach( $find as $items): //echo  $items->name;
                                                        $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
														->where('item_id',$items->id)->first();
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
                                        $qty=DB::table('acc_invendetails')
										->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
										->where('idate','<=', $data['dto'])->where('item_id',  $item->id)->sum('qty'); 
                                        $unit=DB::table('acc_invendetails')->where('item_id',  $item->id)->first();
                                        $qty !=null ? 
                                        $unit=DB::table('acc_Units')
                                        ->where('id', $unit->unit_id)->first() : '';
                                        $qtys=$qty !=null ? $qty.'  '.$unit->name : '';
                                     ?>
                                    <td style="padding-left:30px">{{ $item->name }} </td>
                                    <td class="text-right">{{ $qtys }}</td>
                                    </tr>
                                @endif
									<?php $records = DB::table('acc_products')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                                    @foreach($records as $item)
                                    {{-- */$x++;/* --}}
												<?php
                                            //echo $item->ptype;
                                            $flag='';
                                            if ($item->ptype=='Product'): //echo 123;
                                                $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
												->where('item_id',$item->id)->first();
                                                isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                            elseif ($item->ptype=='Group' && $flag==''): //echo 456;
                                                $find=DB::table('acc_products')->where('com_id',$com_id)
												->where('group_id',$item->id)->get();
                                                foreach( $find as $items): //echo  $items->name;
                                                    if ($items->ptype=='Product'): //echo 988;
                                                        $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
														->where('item_id',$items->id)->first();
                                                        isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                    elseif ($items->ptype=='Group'  && $flag==''): 
                                                        $find=DB::table('acc_products')->where('com_id',$com_id)
														->where('group_id',$items->id)->get();
                                                        foreach( $find as $items): 
                                                            if ($items->ptype=='Product'): //echo  $items->name;
                                                                $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
																->where('item_id',$items->id)->first();
                                                                isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                            elseif ($items->ptype=='Group'  && $flag==''): 
                                                                $find=DB::table('acc_products')->where('com_id',$com_id)
																->where('group_id',$items->id)->get();
                                                                foreach( $find as $items): //echo  $items->name;
                                                                    $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
																	->where('item_id',$items->id)->first();
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
													$qty=DB::table('acc_invendetails')
													->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
													->where('idate','<=', $data['dto'])->where('item_id',  $item->id)->sum('qty'); 
                                                    $unit=DB::table('acc_invendetails')->where('item_id',  $item->id)->first();
                                                    $qty !=null ? 
                                                    $unit=DB::table('acc_Units')
                                                    ->where('id', $unit->unit_id)->first() : '';
                                                    $qtys=$qty !=null ? $qty.'  '.$unit->name : '';
                                                 ?>
                                                <td style="padding-left:50px">{{ $item->name }}</td>
                                                <td class="text-right">{{ $qtys }}</td>
                                                </tr>
                                            @endif
                                     
												<?php $recordz = DB::table('acc_products')->where('group_id', $item->id)
												->orderby('sl')->get(); ?>  
                                                @foreach($recordz as $item)
                                                                {{-- */$x++;/* --}}
                    										<?php
                                                            //echo $item->ptype;
                                                            $flag='';
                                                            if ($item->ptype=='Product'): //echo 123;
                                                                $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
																->where('item_id',$item->id)->first();
                                                                 isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                            elseif ($item->ptype=='Group' && $flag==''): //echo 456;
                                                                $find=DB::table('acc_products')->where('com_id',$com_id)
																->where('group_id',$item->id)->get();
                                                                foreach( $find as $items): //echo  $items->name;
                                                                    if ($items->ptype=='Product'): //echo 988;
                                                                        $tran=DB::table('acc_invendetails')->where('com_id',$com_id)
																		->where('item_id',$items->id)->first();
                                                                        isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                                    elseif ($items->ptype=='Group'  && $flag==''): 
                                                                        $find=DB::table('acc_products')->where('com_id',$com_id)
																		->where('group_id',$items->id)->get();
                                                                        foreach( $find as $items): 
                                                                            if ($items->ptype=='Product'): //echo  $items->name;
                                                                                $tran=DB::table('acc_invendetails')
																				->where('com_id',$com_id)->where('item_id',$items->id)
																				->first();
                                                                                isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                                            elseif ($items->ptype=='Group'  && $flag==''): 
                                                                                $find=DB::table('acc_products')->where('com_id',$com_id)
																				->where('group_id',$items->id)->get();
                                                                                foreach( $find as $items): //echo  $items->name;
                                                                                    $tran=DB::table('acc_invendetails')
																					->where('com_id',$com_id)->where('item_id',$items
																					->id)->first();
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
																$qty=DB::table('acc_invendetails')
																->join('acc_invenmasters','acc_invendetails.im_id','=','acc_invenmasters.id')
																->where('idate','<=', $data['dto'])->where('item_id',  $item->id)->sum('qty'); 
																$unit=DB::table('acc_invendetails')->where('item_id',  $item->id)->first();
																$qty !=null ? 
																$unit=DB::table('acc_Units')
																->where('id', $unit->unit_id)->first() : '';
																$qtys=$qty !=null ? $qty.'  '.$unit->name : '';
                                                             ?>

                                                            <td style="padding-left:70px">{{ $item->name }}</td>
                                                            <td class="text-right">{{ $qtys }}</td>
                                                            </tr>
                                                        @endif
                                                 
														<?php $recordX = DB::table('acc_products')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                                                        @foreach($recordX as $item)
                                                        {{-- */$x++;/* --}}
																	<?php
                                                                    //echo $item->ptype;
                                                                    $flag='';
                                                                    if ($item->ptype=='Product'): //echo 123;
                                                                        $tran=DB::table('acc_invendetails')->where('item_id',$item->id)->first();
                                                                        isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                                    elseif ($item->ptype=='Group' && $flag==''): //echo 456;
                                                                        $find=DB::table('acc_products')->where('group_id',$item->id)->get();
                                                                        foreach( $find as $items): //echo  $items->name;
                                                                            if ($items->ptype=='Product'): //echo 988;
                                                                                $tran=DB::table('acc_invendetails')->where('item_id',$items->id)->first();
                                                                                isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                                            elseif ($items->ptype=='Group'  && $flag==''): 
                                                                                $find=DB::table('acc_products')->where('group_id',$items->id)->get();
                                                                                foreach( $find as $items): 
                                                                                    if ($items->ptype=='Product'): //echo  $items->name;
                                                                                        $tran=DB::table('acc_invendetails')->where('item_id',$items->id)->first();
                                                                                        isset($tran) && $tran->id > 0 ? $flag='yes' : $flag='';
                                                                                    elseif ($items->ptype=='Group'  && $flag==''): 
                                                                                        $find=DB::table('acc_products')->where('group_id',$items->id)->get();
                                                                                        foreach( $find as $items): //echo  $items->name;
                                                                                            $tran=DB::table('acc_invendetails')->where('item_id',$items->id)->first();
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
																->where('idate','<=', $data['dto'])->where('item_id',  $item->id)->sum('qty'); 
																		$unit=DB::table('acc_invendetails')->where('item_id',  $item->id)->first();
																		$qty !=null ? 
																		$unit=DB::table('acc_Units')
																		->where('id', $unit->unit_id)->first() : '';
																		$qtys=$qty !=null ? $qty.'  '.$unit->name : '';
																		 ?>
                                                                    <td style="padding-left:90px">{{ $item->name }}</td>
                                                                    <td class="text-right">{{ $qtys }}</td>
                                                                    </tr>
                                                                @endif                                                         
                                                        @endforeach      
                                                 
                                                @endforeach                                      
                                     
                                    @endforeach                         
                         
                        @endforeach

                @endforeach

                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: Import->Product</td><td class="text-right">Report generated by: {{ $item->user_id }}</td></tr>
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
