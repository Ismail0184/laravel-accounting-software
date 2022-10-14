@extends('app')

@section('htmlheader_title', 'Settings')

@section('contentheader_title', 'Settings')

@section('main-content')
<style>
	#a1 { color:#00C; font-weight:bold}
	#a0 { color:#900; font-weight:bold}
</style>
    <div class="box">
        <div class="box-header">
        	<a href="{{ url('/setting/settinghelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_setting'))
            <a href="{{ URL::route('setting.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Setting</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="setting-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['gname'] }}</th>
                        <th>{{ $langs['ccount'] }}</th>
                        <th>{{ $langs['onem'] }}</th>
                        <th>{{ $langs['m1'] }}</th>
                        <th>{{ $langs['m2'] }}</th>
                        <th>{{ $langs['m3'] }}</th>
                        <th>{{ $langs['m4'] }}</th>
 						<th>{{ $langs['m5'] }}</th>
                        <th>{{ $langs['m6'] }}</th>
                        <th>{{ $langs['m7'] }}</th>
                        <th>{{ $langs['m8'] }}</th>
                        <!--<th>{{ $langs['m9'] }}</th>-->
                        @if (Entrust::can('update_setting'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_setting'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                <?php $active=array(0=>'Inactive', 1=>'Active' ); $onem=array('' => 'Select ...', 'm1'=>'Accounting', 'all'=>'All Module'); ?>
                {{-- */$x=0;/* --}}
                @foreach($settings as $item)
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/setting', $item->id) }}">{{ $item->gname }}</a></td>
                        <td>{{ $item->ccount }}</td>
                        <td>{{ $onem[$item->onem] }}</td>
                        <td><span id="a<?php echo $item->m1 ?>">{{ $active[$item->m1] }}</span></td>
                        <td><span id="a<?php echo $item->m2 ?>">{{ $active[$item->m2] }}</span></td>
                        <td><span id="a<?php echo $item->m3 ?>">{{ $active[$item->m3] }}</span></td>
                        <td><span id="a<?php echo $item->m4 ?>">{{ $active[$item->m4] }}</span></td>
						<td><span id="a<?php echo $item->m5 ?>">{{ $active[$item->m5] }}</span></td>
                        <td><span id="a<?php echo $item->m6 ?>">{{ $active[$item->m6] }}</span></td>
                        <td><span id="a<?php echo $item->m7 ?>">{{ $active[$item->m7] }}</span></td>
                        <td><span id="a<?php echo $item->m8 ?>">{{ $active[$item->m8] }}</span></td>    
                       <!-- <td><span id="a<?php echo $item->m9 ?>">{{ $active[$item->m9] }}</span></td> -->                       
                        @if (Entrust::can('update_setting'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('setting.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_setting'))
                        <td width="80">{!! Form::open(['route' => ['setting.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#setting-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, null, null, null, null, null, null<?php if (Entrust::can("update_setting")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_setting")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
