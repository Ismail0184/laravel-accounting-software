@extends('print')

@section('htmlheader_title', $langs['edit'] . ' Trandetail')

@section('contentheader_title', 	  ' COA')
@section('main-content')
<style>
    table.borderless td,table.borderless th{
     border: none !important;
	}

	h1{
		font-size: 1.6em;
	}
	h5{
		font-size: 1.2em; margin:0px
	}
</style>
	 
        <table class="table borderless">
        <?php 
			$user_name=''; Session::has('user_name') ? $user_name=Session::get('user_name') : $user_name='';
	
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h1 align="center">'.$com_name.'</h1></td></tr>';
		?>
        <tr><td class="text-center"><h5>Chart of Account</h5></td></tr>
        </table>

            <table id="buyerinfo-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="col-md-2 text-center">{{ $langs['sl'] }}    </th>
                        <th class="col-md-6">{{ $langs['name'] }}  </th>
                        <th class="col-md-4">{{ $langs['ptype'] }} </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($coa as $item)
                <tr>
                        <td width="50" class="text-center"></td>
                        @if($item->atype=='Group')
                       	<td><h4><b>{{ $item->name }}</b></h4></td>
                        @else
                        <td>{{ $item->name }}</td>
                        @endif
                        <td>{{ $item->atype }}</td>
                 </tr>
                 		
                    	<?php $record = DB::table('acc_coas')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                        @foreach($record as $item)

                        <tr>
                                <td width="50" class="text-center">{{ $item->sl  }}</td>
                                @if($item->atype=='Group')
                                <td style="padding-left:30px; font-weight:bold">{{ $item->name }}</td>
                                @else
                                <td style="padding-left:30px">{{ $item->name }}</td>
                                @endif
                                <td>{{ $item->atype }}</td>
                         </tr>
									<?php $records = DB::table('acc_coas')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                                    @foreach($records as $item)
                                    <tr>
                                            <td width="0" class="text-center"></td>
                                            @if($item->atype=='Group')
                                            <td style="padding-left:50px">{{ $item->sl  }}<span style="padding-left:30px"></span>{{ $item->name }}</td>
                                            @else
                                            <td style="padding-left:60px">{{ $item->sl  }}<span style="padding-left:30px"></span>{{ $item->name }}</td>
                                            @endif
                                            <td>{{ $item->atype }}</td>
                                     </tr>
                                     
												<?php $recordz = DB::table('acc_coas')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                                                @foreach($recordz as $item)
                                                <tr>
                                                        <td width="50" class="text-center"></td>
                                                        @if($item->atype=='Group')
                                                        <td style="padding-left:70px">{{ $item->sl  }}<span style="padding-left:30px"></span>{{ $item->name }}</td>
                                                        @else
                                                        <td style="padding-left:90px"> {{ $item->sl  }}<span style="padding-left:30px"></span>{{ $item->name }}</td>
                                                        @endif
                                                        <td>{{ $item->atype }}</td>
                                                 </tr>
                                                 
														<?php $recordX = DB::table('acc_coas')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                                                        @foreach($recordX as $item)
                                                        <tr>
                                                                <td width="50" class="text-center"></td>
                                                                @if($item->atype=='Group')
                                                                <td style="padding-left:90px">{{ $item->name }}</td>
                                                                @else
                                                                <td style="padding-left:90px">{{ $item->name }}</td>
                                                                @endif
                                                                <td>{{ $item->atype }}</td>
                                                         </tr>
                                                         
                                                        @endforeach      
                                                 
                                                @endforeach                                      
                                     
                                    @endforeach                         
                         
                        @endforeach

                @endforeach

                </tbody>
            </table>
			<div class="box-header">
                <table class="table borderless">
                <tr><td class="text-left">Source: COA->report</td><td class="text-right">Report generated by: {{ $user_name }}</td></tr>
                </table>
            </div><!-- /.box-header -->
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
