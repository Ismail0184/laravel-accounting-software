@extends('app')

@section('htmlheader_title', 'Projects')

@section('contentheader_title', 'Projects')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
        	<a href="{{ url('/acc-project/projecthelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_acc-project'))
            <a href="{{ URL::route('acc-project.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Project</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="project-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['description'] }}</th>
                        <th>{{ $langs['location'] }}</th>
                        <th class="text-right">{{ $langs['cost'] }}</th>
                        <th>{{ $langs['projdate'] }}</th>
                        <th>{{ $langs['pstrdate'] }}</th>
                        <th>{{ $langs['fdate'] }}</th>
                        @if (Entrust::can('update_acc-project'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_acc-project'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($projects as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/acc-project', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->location }}</td>
                        <td class="text-right">{{ number_format($item->cost) }}</td>
                        <td>{{ $item->pdate }}</td>
                        <td>{{ $item->sdate }}</td>
                        <td>{{ $item->fdate }}</td>
                        @if (Entrust::can('update_acc-project'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('acc-project.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td> 
                       @endif
                        @if (Entrust::can('delete_acc-project'))
                        <td width="80">{!! Form::open(['route' => ['acc-project.destroy', $item->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
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
        $("#project-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null, null<?php if (Entrust::can("update_acc-project")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_acc-project")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
