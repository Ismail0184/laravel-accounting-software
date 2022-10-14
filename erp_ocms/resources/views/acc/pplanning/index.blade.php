@extends('app')

@section('htmlheader_title', 'Pplannings')

@section('contentheader_title', 'Project Plannings')

@section('main-content')
	<style>
    	#an { width:50px}
		#std { width:120px}
		#cld { width:120px}
		#amt { width:120px}
    </style>
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/pplanning/pplanninghelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_pplanning'))
            <a href="{{ URL::route('pplanning.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Planning</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="pplanning-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th colspan="4">{{ $langs['segment'] }}</th>
                        <th id="std">{{ $langs['stdate'] }}</th>
                        <th id="cld">{{ $langs['cldate'] }}</th>
                        <th id="amt" class="text-right">{{ $langs['amount'] }}</th>
                        <th id="an"></th>
                        @if (Entrust::can('update_pplanning'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_pplanning'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($pplannings as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td colspan="4"><a href="{{ url('/pplanning', $item->id) }}">{{ $item->segment }} </a></td>
                        <td id="std">{{ $item->stdate }}</td>
                        <td id="cld">{{ $item->cldate }}</td>
                        <td id="amt" class="text-right">{{ $item->bamount }}</td>
                        <td><a href="{{ url('/pplanning/create?p='.$item->pro_id.'&g='.$item->id ) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }}</a></td>
                        @if (Entrust::can('update_pplanning'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('pplanning.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_pplanning'))
                        <td width="80">{!! Form::open(['route' => ['pplanning.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit($langs['delete'], ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
                        @endif
                    </tr>
                           <?php
                                	$record = DB::table('acc_pplannings')->where('group_id', $item->id)->orderby('sl')->get();
                                ?>  
                           {{-- */$y=0;/* --}}
                           @foreach($record as $item)
                                {{-- */$y++;/* --}} {{-- */$x++;/* --}}
                                <tr>
                                    <td width="50">{{ $x }}</td>
                        			<td>{{ $y }}</td><td style="padding-left:30px" colspan="3"><a href="{{ url('/pplanning', $item->id) }}">{{ $item->segment }} </a></td>
                                    <td>{{ $item->stdate }}</td>
                                    <td id="cld">{{ $item->cldate }}</td>
                                    <td class="text-right">{{ $item->bamount }}</td>
                        			<td> <a href="{{ url('/pplanning/create?p='.$item->pro_id.'&g='.$item->id ) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }}</a></td>
                                    @if (Entrust::can('update_pplanning'))
                                    <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('pplanning.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                                    @endif
                                    @if (Entrust::can('delete_pplanning'))
                                    <td width="80">{!! Form::open(['route' => ['pplanning.destroy', $item->id], 'method' => 'DELETE']) !!}
                                        {!! Form::submit($langs['delete'], ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                                        {!!  Form::close() !!}</td>
                                    @endif
                                </tr>
											<?php
                                                $records = DB::table('acc_pplannings')->where('group_id', $item->id)->orderby('sl')->get();
                                            ?>     
                                            {{-- */$z=0;/* --}}                                       
                                			@foreach($records as $item)
                                                {{-- */$z++;/* --}} {{-- */$x++;/* --}}
                                                <tr>
                                                    <td width="80">{{ $x }}</td>
                        							<td></td><td>{{ $z }}</td><td style="padding-left:60px" colspan="2"><a href="{{ url('/pplanning', $item->id) }}">{{ $item->segment }} </a></td>
                                                    <td>{{ $item->stdate }}</td>
                                                    <td id="cld">{{ $item->cldate }}</td>
                                                    <td class="text-right">{{ $item->bamount }}</td>
                        							<td> <a href="{{ url('/pplanning/create?p='.$item->pro_id.'&g='.$item->id ) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }}</a></td>
                                                    @if (Entrust::can('update_pplanning'))
                                                    <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('pplanning.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                                                    @endif
                                                    @if (Entrust::can('delete_pplanning'))
                                                    <td width="80">{!! Form::open(['route' => ['pplanning.destroy', $item->id], 'method' => 'DELETE']) !!}
                                                        {!! Form::submit($langs['delete'], ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                                                        {!!  Form::close() !!}</td>
                                                    @endif
                                                </tr>
															<?php
                                                                $recordz = DB::table('acc_pplannings')->where('group_id', $item->id)->orderby('sl')->get();
                                                            ?> 
                                                            {{-- */$n=0;/* --}}                                             
                                                            @foreach($recordz as $item)
                                                                {{-- */$n++;/* --}} {{-- */$x++;/* --}}
                                                                <tr>
                                                                    <td width="80">{{ $x }}</td>
                                                                    <td></td><td></td><td>{{ $n }}</td><td style="padding-left:80px"><a href="{{ url('/pplanning', $item->id) }}">{{ $item->segment }} </a></td>
                                                                    <td>{{ $item->stdate }}</td>
                                                                    <td id="cld">{{ $item->cldate }}</td>
                                                                    <td class="text-right">{{ $item->bamount }}</td>
                                                                    <td> <a href="{{ url('/pplanning/create?p='.$item->pro_id.'&g='.$item->id ) }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }}</a></td>
                                                                    @if (Entrust::can('update_pplanning'))
                                                                    <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('pplanning.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                                                                    @endif
                                                                    @if (Entrust::can('delete_pplanning'))
                                                                    <td width="80">{!! Form::open(['route' => ['pplanning.destroy', $item->id], 'method' => 'DELETE']) !!}
                                                                        {!! Form::submit($langs['delete'], ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                                                                        {!!  Form::close() !!}</td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                            @endforeach
                            @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#pplanning-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null<?php if (Entrust::can("update_pplanning")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_pplanning")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
