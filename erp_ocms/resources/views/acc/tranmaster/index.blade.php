@extends('app')

@section('htmlheader_title', 'Tranmasters')

@section('contentheader_title', 'Transaction')

@section('main-content')
<style>
	#vnumber { width:120px; text-align:center}
	#tdate { width:80px}
	#amount { width:80px; text-align:right; padding-right:10px}
	#acc_head { width:150px; }
	#mod { width:80px; }
</style>
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		$edit_disabled='';
		Session::put('m_name',"account");
		
		$user_only = Auth::user()->can('user_only');
		$admin_user = Auth::user()->can('admin_user');
		$permission=array();
        if($user_only && !$admin_user) {
			$permission=array('user_id'=>Auth::id());
			}

/*		$record=DB::table('acc_tranmasters')->where('com_id',$com_id)->get();
		foreach($record as $ietm):
			$has=DB::table('acc_trandetails')->where('tm_id',$ietm->id)->first();
			if ($has->id>0):
			else:
				echo $ietm->id.'<br>';
			endif;
		endforeach;
		$record=DB::table('acc_trandetails')->where('com_id',$com_id)->get();
		foreach($record as $ietm):
			$has=DB::table('acc_tranmasters')->where('id',$ietm->tm_id)->first();
			if ($has->id>0):
			else:
				echo $ietm->vnumber.'<br>';
			endif;
		endforeach;
*/		?>

    <div class="box">
        <div class="box-header"><h3 style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/tranmaster?flag=filter') }}" class="btn btn-primary pull-left btn-sm">{{ $langs['filter'] }}</a>
        	<a href="{{ url('/tranmaster/tranmasterhelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_tranmaster'))
            <h4 style="margin:0px; padding:0px"> 
            	<?php 
					$marq_text='';
					$chekck=DB::table('acc_tranmasters')
					->where('check_id',Auth::user()->id)
					->where('id',$com_id)
					->where('check_action','')
					->first(); 
					isset($chekck->vnumber) && $chekck->id > 0  ?
					$marq_text="<a href='tranmaster/checkby' >Waiting for checking of ".number_format($chekck->tmamount,2).'-'.$chekck->note.'-created by '.$users[$chekck->user_id]."</a>" : '';
					
					//$marq_text='';
					$appr=DB::table('acc_tranmasters')
					->where('check_action',1)
					->where('appr_id',Auth::user()->id)
					->where('com_id',$com_id)
					->where('appr_action','')
					->first(); 
					isset($appr->vnumber) && $appr->id > 0  ?
					$marq_text=$marq_text.  "<a href='tranmaster/approveby' >Waiting for Approval of ".number_format($appr->tmamount,2).'-'.$appr->note.'-created by '.$users[$appr->user_id]."</a>" : '';

					//$marq_text='';
					$sis=DB::table('acc_trandetails')
					->join('acc_tranmasters', 'acc_trandetails.tm_id', '=', 'acc_tranmasters.id')
					->where('sis_id',$com_id)
					->where('acc_trandetails.sis_action','')
					->where('amount','>',0)
					->first(); 
					isset($sis->sis_id) && $sis->amount > 0  ?
					$marq_text=$marq_text.  "<a href='tranmaster/approveby' >Waiting for acceptance of ".number_format($sis->amount,2).'-'.$sis->note.'-created by '.$users[$sis->user_id]."</a>" : '';
					?>
                <marquee behavior="scroll" direction="left" width=80% onmouseover="this.stop();" onmouseout="this.start();"><?php echo $marq_text ?></marquee> 
            <a href="{{ URL::route('tranmaster.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Transaction</a>
             </h4>
            @endif
            
               
					<?php 
						$data=array('dfrom'=>'0000-00-00','dto'=>'0000-00-00');
						Session::has('tmdto') ? 
						$data=array('dfrom'=>Session::get('tmdfrom'),'dto'=>Session::get('tmdto')) : ''; 
                    	
						$flags=''; isset($_GET['flag']) ? $flags=$_GET['flag'] : ''; 
						 !isset($data['acc_id']) ? $data['acc_id']='' : '' ;
                   
				    // to get data by fileter
					?>
                    @if ($flags=='filter')
                           {!! Form::open(['url' => 'tranmaster/tmfilter', 'class' => 'form-horizontal']) !!}
            				<table><tr><td style="width:400px">
                    		<div class="form-group">
                                {!! Form::label('dfrom', $langs['dfrom'], ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6"> 
                                    {!! Form::text('dfrom',  date('Y-m-01'), ['class' => 'form-control', 'id'=>'dfrom', 'required']) !!}
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
                            </td></tr></table>
                          {!! Form::close() !!}
                     @endif
               
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="tranmaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['vnumber'] }}</th>
                        <th>{{ $langs['note'] }}</th>
                        <th>{{ $langs['tranwith_id'] }}</th>
                        <th>{{ $langs['amount'] }}</th>
                        <th>{{ $langs['ttype'] }}</th>
                        <th>{{ $langs['document'] }}</th>
                        @if($admin_user) 
                        <th>{{ $langs['user'] }}</th>
                        @endif
                       @if (Entrust::can('update_tranmaster'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_tranmaster'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                <?php 
				    $user_only = Auth::user()->can('user_only');
					$admin_user = Auth::user()->can('admin_user');
					$permission=array();
        			if($user_only && !$admin_user) {
						$permission=array('user_id'=>Auth::id());
						}

					$data['dfrom']!='0000-00-00' ? 
					$tranmasters=DB::table('acc_tranmasters')->where('com_id',$com_id)
					->whereBetween('acc_tranmasters.tdate', [$data['dfrom'], $data['dto']])->where($permission)->orderBy('tdate','DESC')->orderBy('id','DESC')->get() : ''; ?>
                @foreach($tranmasters as $item)
                    {{-- */$x++;/* --}}
                    <?php 
						$edit_disabled=''; $tmamount='';
						
						$check_delete = DB::table('acc_trandetails')
						->where('tm_id',$item->id)
						->first(); 
						isset($check_delete->tm_id) && $check_delete->tm_id>0 ? $disabled="disabled" : $disabled="";
						$coas=''; $coa=DB::table('acc_coas')->where('id',$item->tranwith_id)->first(); isset($coa) && $coa->id>0 ? $coas=$coa->name : $coas='';
						
						$item->tmamount > 0 ? $tmamount=number_format($item->tmamount,2): '';
						$item->tmamount < 0 ? $tmamount=number_format(substr($item->tmamount,1),2) : '';						
						
						$td=DB::table('acc_trandetails')->where('tm_id',$item->id)->first(); 
						
						$td_accid=''; isset($td) && $td->id >0 ? $td_accid=$td->acc_id : $td_accid=''; //echo $td->rmndr_id;
						$rmndr=''; isset($td) && $td->rmndr_id >0 ? $rmndr=', Reminder: '.$td->rmndr_id.', '.$td->rmndr_note.','.$td->rmndr_date: $rmndr=''; //echo $td_accid;

						$coa=''; $coa=DB::table('acc_coas')->where('id',$td_accid)->first(); 
						$coa_name=''; isset($coa) && $coa->id>0 ? $coa_name=$coa->name : $coa_name='';
						if ($coa_name!=''):
						 	$item->note!='' ? $item->note=$coa_name . ', '.$item->note :  $item->note=$coa_name;
						 endif;
						 $item->note=$item->note.$rmndr
						  
					?>
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td id="vnumber">
                        <a href="{{ url('/tranmaster/voucher', $item->id) }}">{{ $item->tdate. '/ VNo: '. $item->vnumber }}</a>
                        </td>
                        <td>{{ $item->note }}</td>
                        <td id="acc_head"><a href="{{ url('/tranmaster/ledger') }}">{{ $coas }}</a></td>
                        <td id="amount">{{ $tmamount }}</td>
                        @if($item->check_action=='0')
                         <td id="mod"><a href="{{ url('/tranmaster', $item->id) }}">{{ $item->ttype }}</a></td>
                        @else
                         <td id="mod">{{ $item->ttype }}</td>
                            <?php $edit_disabled="disabled"; ?>
                        @endif
                        <td id="amount"><a href="{{ url('/fileentry',$item->vnumber) }}">Upload Document</a></td>
                        @if($admin_user) 
                        <td width="80">{{  $users[$item->user_id] }}</td>
                        @endif
                        @if (Entrust::can('update_tranmaster'))
                        	<td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('tranmaster.edit', $item->id) }}">
                            <i class="fa fa-edit"></i></a></td> 
                       	@endif
                        @if (Entrust::can('delete_tranmaster'))
                        <td width="80">{!! Form::open(['route' => ['tranmaster.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa',$disabled, 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#tranmaster-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null<?php if ($admin_user): ?>, { "bSortable": false }<?php endif; if (Entrust::can("update_tranmaster")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_tranmaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
		$( "#dfrom" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
        $( "#dto" ).datepicker({ dateFormat: "yy-mm-dd" }).val();
    } );
</script>

@endsection
