@extends('app')

@section('htmlheader_title', 'Coaconditions')

@section('contentheader_title', 'Coaconditions')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
            @if (Entrust::can('create_coacondition'))
            <a href="{{ URL::route('coacondition.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Coacondition</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="coacondition-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['acc_id'] }}</th>
                        <th>{{ $langs['interval'] }}</th>
                        <th>{{ $langs['amount'] }}</th>
                        <th>{{ $langs['depreciation'] }}</th>
                        <th>{{ $langs['dep_formula'] }}</th>
                        <th>{{ $langs['dep_interval'] }}</th>
                        @if (Entrust::can('update_coacondition'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_coacondition')) 
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                <?php  $interval=array(''=> 'Select ...', 1=>'Monthly', 2=> 'Yearly', '0'=>'');  
					$flag=array(''=> 'Select ...', 1=>'Yes', 2=> 'No'); ?>
                @foreach($coaconditions as $item)
                     <?php $coa=DB::table('acc_coas')->where('id',$item->acc_id)->first(); isset($coa) && $coa->id>0 ? $coas=$coa->name : $coas=''; ?>         	
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/coacondition', $item->id) }}">{{ $coas }}</a></td>
                        <td>{{ $interval[$item->interval] }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $flag[$item->depreciation] }}</td>
                        <td>{{ $item->dep_formula }}</td>
                        <td>{{ $interval[$item->dep_interval] }}</td>
                        @if (Entrust::can('update_coacondition'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('coacondition.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_coacondition'))
                        <td width="80">{!! Form::open(['route' => ['coacondition.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit($langs['delete'], ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#coacondition-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null<?php if (Entrust::can("update_coacondition")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_coacondition")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
