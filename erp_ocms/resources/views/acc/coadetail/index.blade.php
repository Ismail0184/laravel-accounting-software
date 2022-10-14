@extends('app')

@section('htmlheader_title', 'Coadetails')

@section('contentheader_title', 'Coadetails')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
            @if (Entrust::can('create_coadetail'))
            <a href="{{ url('/coadetail/coadetailhelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            <a href="{{ URL::route('coadetail.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Coadetail</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="coadetail-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        @if (Entrust::can('update_coadetail'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_coadetail'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($coadetails as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/coadetail', $item->id) }}">{{ $item->name }}</a></td>
                        @if (Entrust::can('update_coadetail'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('coadetail.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_coadetail'))
                        <td width="80">{!! Form::open(['route' => ['coadetail.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#coadetail-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_coadetail")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_coadetail")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
