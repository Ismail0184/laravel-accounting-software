@extends('app')

@section('htmlheader_title', 'Mteams')

@section('contentheader_title', 'Mteams')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
		?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
            @if (Entrust::can('create_mteam'))
            <a href="{{ url('/client/clienthelp') }}" class="btn btn-primary pull-right btn-sm trash-btn">{{ $langs['help'] }}</a>
            <a href="{{ URL::route('mteam.create')}}" title="{{ $langs['add_new'] }}" class="btn btn-primary pull-right btn-sm trash-btn trash-btn"><i class="fa fa-plus"></i></a>
            <a href="{{ url('mteam/print') }}" title="{{ $langs['print'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-print"></i></a>
            <a href="{{ url('mteam/pdf') }}" title="{{ $langs['download'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-download"></i></a>
            <a href="{{ url('mteam/pdf') }}" title="{{ $langs['pdf'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ url('mteam/excel') }}" title="{{ $langs['excel'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('mteam/csv') }}" title="{{ $langs['csv'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-excel-o"></i></a>
            <a href="{{ url('mteam/word') }}" title="{{ $langs['word'] }}" class="btn btn-primary pull-right btn-sm trash-btn"><i class="fa fa-file-word-o"></i></a>

            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="mteam-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['designation'] }}</th>
                        <th>{{ $langs['salary'] }}</th>
                        <th>{{ $langs['dtarget'] }}</th>
                        <th>{{ $langs['mtarget'] }}</th>
                        <th>{{ $langs['ytarget'] }}</th>
                        @if (Entrust::can('update_mteam'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_mteam'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($mteams as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/mteam', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $item->designation }}</td>
                        <td>{{ $item->salary }}</td>
                        <td>{{ $item->dtarget }}</td>
                        <td>{{ $item->mtarget }}</td>
                        <td>{{ $item->ytarget }}</td>
                        @if (Entrust::can('update_mteam'))
						<td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('mteam.edit', $item['id']) }}"><i class="fa fa-edit"></i></a></td>                         @endif
                        @if (Entrust::can('delete_mteam'))
                        <td width="80">{!! Form::open(['route' => ['mteam.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#mteam-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_mteam")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_mteam")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
