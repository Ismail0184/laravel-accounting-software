@extends('app')

@section('contentheader_title', 'Transaction Approve')

@section('main-content')
	<style>
    	#sl, #vn { width:80px; text-align:center }
		#dt, #user { width:100px; text-align:center }
		#nt { width:200px}
		#amt { width:100px; text-align:right }
		#acc_id { width:200px; }
    </style>
	<?php	
	use App\Models\Acc\Trandetails;
	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		Session::put('m_name',"account");
		
		?>
    <div class="box">
        <div class="box-header"><h3 style="margin:0px; padding:0px">{{ $com_name }}</h3></div>
             <table id="tranmaster-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th >{{ $langs['sl'] }}</th>
                        <th id="dt">{{ $langs['tdate'] }}</th>
                        <th id="">{{ $langs['ttype'] }}</th>
                        <th id="nt">{{ $langs['note'] }}</th>
                        <th id="nt">Project and Department</th>
                        <th id="acc_id">{{ $langs['sfund'] }}</th>
                        <th id="amt">{{ $langs['amount'] }}</th>
                        <th id="tp">Checked by</th>
                        @if (Entrust::can('delete_tranmaster'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($tranmasters as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                    <?php 

				$prj=Trandetails::join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')->where('acc_tranmasters.id', $item->id)->where('pro_id','>',0)->first();
				$dep=Trandetails::join('acc_tranmasters','acc_trandetails.tm_id','=','acc_tranmasters.id')->where('acc_tranmasters.id', $item->id)->where('dep_id','>',0)->first();

						$td=DB::table('acc_trandetails')->where('tm_id',$item->id)->first(); 
						$td_accid=''; isset($td) && $td->id >0 ? $td_accid=$td->acc_id : $td_accid=''; //echo $td_accid;
						
						$coa=''; $coa=DB::table('acc_coas')->where('id',$td_accid)->first(); 
						$coa_name=''; isset($coa) && $coa->id>0 ? $coa_name=$coa->name : $coa_name='';
						if ($coa_name!=''):
						 	$item->note!='' ? $item->note=$item->note. ', '.$coa_name :  $item->note=$coa_name;
						 endif;	
						$tranwith=DB::table('acc_coas')->where('id',$item->tranwith_id)->first(); 
						$tranwith_name=''; isset($tranwith) && $tranwith->id>0 ? $tranwith_name=$tranwith->name : $coa_name='';						 					 
					 	$item->tmamount > 0 ? $item->tmamount=number_format($item->tmamount,2) : '';
						 ?>
                        <td width="50">{{ $x }}</td>
                        <td id="vn"><a href="{{ url('/tranmaster/voucher', $item->id) }}">{{ $item->tdate.'/ VNo: '.$item->vnumber }}</a></td>
                        <td id="">{{ $item->ttype }}</td>
                        <td id="nt">{{ $item->note }}</td>
                        <td id="">{{ isset($prj->project->name) ? $prj->project->name : ''}} {{ isset($dep->department->name) ? ', '. $dep->department->name : ''}}</td>
                        <td id="acc_id">{{ $tranwith_name }}</td>
                        <td id="amt">{{ $item->tmamount }}</td>
                        <td id="tp">{{ $users[$item->check_id] }}<br>
                       	<a href="{{ url('/fileentry',$item->vnumber) }}">View Document</a>
                         </td>
    
                        @if (Entrust::can('appr_tranmaster'))
                        <td width="200px">
                        	{!! Form::model($tranmasters, ['url' => ['tranmaster/approved', $item->id], 'method' => 'UPDATE', 'class' => 'form-horizontal tranmaster']) !!}
                        	{!! Form::text('appr_note', 'ok', ['class' => 'form-control', 'required','maxlength'=>200, 'style'=>'width:200px']) !!}
							{!! Form::select('appr_action', array(''=>'Select ...', '1' => 'Approve', '2' => 'Reject', '3' => 'Later'), null, ['class' => 'form-control' , 'required', 'style'=>'width:200px']) !!}                            
                            {!! Form::submit($langs['approve'], ['class' => 'btn btn-primary btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
                        @endif
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
    		"aoColumns": [ null, null, null, null, null, null,null, null<?php  if (Entrust::can("delete_tranmaster")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
