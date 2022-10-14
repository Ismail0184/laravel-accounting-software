@extends('app')

@section('htmlheader_title', 'Subheads')

@section('contentheader_title', 'Subheads')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		

		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
            @if (Entrust::can('create_subhead'))
            <a href="{{ URL::route('subhead.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Subhead</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="subhead-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_subhead'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_subhead'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($subheads as $item)

<?php 
		$check_delete = DB::table('acc_trandetails')->where('com_id',$com_id)
		->where('sh_id',$item->id)
		->first(); 
		isset($check_delete) && $check_delete->tm_id>0 ? $disabled="disabled" : $disabled=""; //echo $disabled;
?>                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/subhead', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_subhead'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('subhead.edit', $item->id) }}"><i class="fa fa-edit"></i></a></td> 
                        @endif
                        @if (Entrust::can('delete_subhead'))
                        <td width="80">{!! Form::open(['route' => ['subhead.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#subhead-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_subhead")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_subhead")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
