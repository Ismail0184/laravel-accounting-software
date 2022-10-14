@extends('app')

@section('htmlheader_title', 'Orderinfos')

@section('contentheader_title', 'Order information')

@section('main-content')

 <div class="container">
 <div class="box" >
    <div class="table-responsive">
        <div class="box-header">
        <table class="table borderless">
        <?php 
			Session::has('com_id') ? 
			$com_id=Session::get('com_id') : $com_id='' ;// echo $com_id.'osama';
			$com=DB::table('acc_companies')->where('id',$com_id)->first(); $com_name=''; isset($com) && $com->id>0 ? $com_name=$com->name : $com_name=''; 
			echo '<tr><td colspan="2"><h2 align="center">'.$com_name.'</h2></td></tr>';
		?>
        <tr><td class="text-center"><h4>Product List</h4></td></tr>
        </table>
        </div><!-- /.box-header -->

            <table id="buyerinfo-table" class="table table-bordered ">
                <thead>
                    <tr>
                        <th class="col-md-1">{{ $langs['sl'] }}    </th>
                        <th class="col-md-3">{{ $langs['name'] }}  </th>
                        <th class="col-md-2">{{ $langs['ptype'] }} </th>
                    </tr>
                </thead>
                <tbody>
				{{-- */$x=0;/* --}}
                @foreach($product as $item)
                {{-- */$x++;/* --}}
                <tr>
                        <td width="50">{{ $x }}</td>
                        @if($item->ptype=='Group')
                       	<td>{{ $item->name }}</td>
                        @else
                        <td>{{ $item->name }}</td>
                        @endif
                        <td>{{ $item->ptype }}</td>
                 </tr>
                 		
                    	<?php $record = DB::table('acc_products')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                        @foreach($record as $item)
                        {{-- */$x++;/* --}}
                        <tr>
                                <td width="50">{{ $x }}</td>
                                @if($item->ptype=='Group')
                                <td style="padding-left:30px">{{ $item->name }}</td>
                                @else
                                <td style="padding-left:30px">{{ $item->name }}</td>
                                @endif
                                <td>{{ $item->ptype }}</td>
                         </tr>
									<?php $records = DB::table('acc_products')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                                    @foreach($records as $item)
                                    {{-- */$x++;/* --}}
                                    <tr>
                                            <td width="0">{{ $x }}</td>
                                            @if($item->ptype=='Group')
                                            <td style="padding-left:50px">{{ $item->name }}</td>
                                            @else
                                            <td style="padding-left:50px">{{ $item->name }}</td>
                                            @endif
                                            <td>{{ $item->ptype }}</td>
                                     </tr>
                                     
												<?php $recordz = DB::table('acc_products')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                                                @foreach($recordz as $item)
                                                {{-- */$x++;/* --}}
                                                <tr>
                                                        <td width="50">{{ $x }}</td>
                                                        @if($item->ptype=='Group')
                                                        <td style="padding-left:70px">{{ $item->name }}</td>
                                                        @else
                                                        <td style="padding-left:70px">{{ $item->name }}</td>
                                                        @endif
                                                        <td>{{ $item->ptype }}</td>
                                                 </tr>
                                                 
														<?php $recordX = DB::table('acc_products')->where('group_id', $item->id)->orderby('sl')->get(); ?>  
                                                        @foreach($recordX as $item)
                                                        {{-- */$x++;/* --}}
                                                        <tr>
                                                                <td width="50">{{ $x }}</td>
                                                                @if($item->ptype=='Group')
                                                                <td style="padding-left:90px">{{ $item->name }}</td>
                                                                @else
                                                                <td style="padding-left:90px">{{ $item->name }}</td>
                                                                @endif
                                                                <td>{{ $item->ptype }}</td>
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
                <tr><td class="text-left">Source: Import->Product</td><td class="text-right">Report generated by: {{ $item->user_id }}</td></tr>
                </table>
            </div><!-- /.box-header -->
        </div>
     </div>
</div>
@endsection