@extends('app')

@section('contentheader_title', 'Technical Check')

@section('main-content')
	<style>
    	#vn { width:100px; text-align:center }
    	#nt { width:200px; }
		#dt, #user { width:100px; text-align:center }
		#amt { width:100px; text-align:right }
		#acc_id { width:200px; }
    </style>
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		$option=DB::table('acc_options')->where('com_id',$com_id)->first();
		isset($option) && $option->id> 0 ? $option_check_id=$option->tcheck_id : $option_check_id=0;
		Session::put('m_name',"account");

		?>
    <div class="box">
        <div class="box-header"><h3 style="margin:0px; padding:0px">{{ $com_name }}</h3></div>
             <table id="tranmaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">{{ $langs['sl'] }}</th>
                        <th id="vn" class="text-center">{{ $langs['vnumber'] }}</th>
                        <th id="">{{ $langs['ttype'] }}</th>
                        <th id="nt">{{ $langs['note'] }}</th>
                        <th id="acc_id">{{ $langs['sfund'] }}</th>
                        <th id="amt">{{ $langs['amount'] }}</th>
                        <th id="tp">{{ $langs['inputby'] }}</th>
                        <th id="tp">{{ $langs['tcheck_id'] }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($tranmasters as $item)
                    {{-- */$x++;/* --}}
                     <?php 
						$td=DB::table('acc_trandetails')->where('com_id',$com_id)->where('tm_id',$item->id)->first(); 
						$td_accid=''; isset($td) && $td->id >0 ? $td_accid=$td->acc_id : $td_accid=''; //echo $td_accid;
						
						$coa=''; $coa=DB::table('acc_coas')->where('id',$td_accid)->first(); 
						$coa_name=''; isset($coa) && $coa->id>0 ? $coa_name=$coa->name : $coa_name='';
						if ($coa_name!=''):
						 	$item->note!='' ? $item->note=$coa_name. ', '.$item->note :  $item->note=$coa_name;
						 endif;	
						$tranwith=DB::table('acc_coas')->where('id',$item->tranwith_id)->first(); 
						$tranwith_name=''; isset($tranwith) && $tranwith->id>0 ? $tranwith_name=$tranwith->name : $coa_name='';	
						$item->tmamount>0 ? $item->tmamount=number_format($item->tmamount,2) : '';					 					 
						 ?>
                   <tr>
                  {!! Form::model($tranmasters, ['url' => ['tranmaster/techecked', $item->id], 'method' => 'UPDATE', 'class' => 'form-horizontal tranmaster']) !!}
                        <td width="50" class="text-center">{{ $x }}</td>
                        <td id="vn"><a href="{{ url('/tranmaster/voucher', $item->id) }}">{{ $item->tdate.'/ V No: '.$item->vnumber }}</a></td>
                         <td id="">{{ $item->ttype }}</td>
                        <td id="nt">{{ $item->note }}</td>
                        <td id="acc_id">{{ $tranwith_name }}</td>
                        <td id="amt">{{ $item->tmamount }}</td>
                       <td id="amt">{{ $users[$item->user_id] }}</td>
                        <td id="tp">{!! Form::select('check_id', $users, $option_check_id, ['class' => 'form-control' , 'required', 'style'=>'width:200px']) !!}
                       	<a href="{{ url('/fileentry',$item->vnumber) }}">View Document</a>
                        </td>
                        <td width="200px">
                        	{!! Form::text('techeck_note', 'ok', ['class' => 'form-control', 'required','maxlength'=>200 , 'style'=>'width:200px']) !!}
							{!! Form::select('techeck_action', array(''=>'Select ...', '1' => 'Check', '2' => 'Reject', '3' => 'Later'), null, ['class' => 'form-control' , 'required', 'style'=>'width:200px']) !!}                            
                            {!! Form::submit($langs['check'], ['class' => 'btn btn-primary btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                  {!!  Form::close() !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#tranmaster-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null<?php  if (Entrust::can("delete_tranmaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
