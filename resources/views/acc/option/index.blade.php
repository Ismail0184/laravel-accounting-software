@extends('app')

@section('htmlheader_title', 'Options')

@section('contentheader_title', 'Options')

@section('main-content')
<?php 
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';

		$bstype=array(
			''	 => 'Select ...',
			'gf' => 'Garments Factory',
			'ex' => 'Export Business',
			'im' => 'Import Business',
			'ei' => 'Export and Import Business',
			'tr' => 'Trading Business',
			'ed' => 'Education',
			'st' => 'Training Center',
			
		);
		$active=array(0=>'Inactive', 1=>'Active' );
	?>
    <div class="box">
        <div class="box-header">
            <h3 style="margin:0px; padding:0px" class="pull-left">{{ $com_name }}</h3>
        	<a href="{{ url('/option/optionhelp') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['help'] }}</a>
            @if (Entrust::can('create_option'))
            <a href="{{ URL::route('option.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Option</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="option-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['bstype'] }}</th>
                        <th>{{ $langs['currency_id'] }}</th>
                        <th>{{ $langs['export'] }}</th>
                        <th>{{ $langs['import'] }}</th>
                        <th>{{ $langs['budget'] }}</th>
                        <!--<th>{{ $langs['audit'] }}</th>-->
                        <th>{{ $langs['project'] }}</th>
                        <!--<th>{{ $langs['inventory'] }}</th>-->
                        <!--<th>{{ $langs['scenter'] }}</th>-->
                        <th>{{ $langs['tcheck_id'] }}</th>
                        <th>{{ $langs['tappr_id'] }}</th>
                        <th>{{ $langs['rcheck_id'] }}</th>
                        <th>{{ $langs['rappr_id'] }}</th>
                        <!--<th>{{ $langs['frcheck_id'] }}</th>-->
                        <!--<th>{{ $langs['frappr_id'] }}</th>-->
                        @if (Entrust::can('update_option'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_option'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($options as $item)
                    {{-- */$x++;/* --}}
                    <?php 
						$cur=DB::table('acc_currencies')->where('id',$item->currency_id)->first(); 
						isset($cur) && $cur->id>0 ? $cur_name=$cur->name : $cur_name='';
						
						$user=DB::table('users')->where('id',$item->tacheck_id)->first(); 
						$tcheck_name=''; isset($user) && $user->id>0 ? $tcheck_name=$cur->name : $tcheck_name='';

						$user=DB::table('users')->where('id',$item->tappr_id)->first(); 
						$tappr_name=''; isset($user) && $user->id>0 ? $tappr_name=$cur->name : $tappr_name='';
						
						$user=DB::table('users')->where('id',$item->rcheck_id)->first(); 
						$rcheck_name=''; isset($user) && $user->id>0 ? $rcheck_name=$user->name : $rcheck_name='';
						
						$user=DB::table('users')->where('id',$item->rappr_id)->first(); 
						$rappr_name=''; isset($user) && $user->id>0 ? $rappr_name=$user->name : $rappr_name='';
					?>
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/option', $item->id) }}">{{ $bstype[$item->bstype] }}</a></td>
                        <td>{{ $cur_name }}</td>
                        <td>{{ $active[$item->export] }}</td>
                        <td>{{ $active[$item->import] }}</td>
                        <td>{{ $active[$item->budget] }}</td>
<!--                        <td>{{ $active[$item->audit] }}</td>
-->                        <td>{{ $active[$item->project] }}</td>
<!--                    <td>{{ $active[$item->scenter] }}</td>
                        <td>{{ $active[$item->inventory] }}</td>
-->                     <td>{{ $tcheck_name }}</td>
                        <td>{{ $tappr_name }}</td>
                        <td>{{ $rcheck_name }}</td>
                        <td>{{ $rcheck_name }}</td>
<!--                        <td>{{ $active[$item->frcheck_id] }}</td>
                        <td>{{ $active[$item->frappr_id] }}</td>-->
                        @if (Entrust::can('update_option'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('option.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_option'))
                        <td width="80">{!! Form::open(['route' => ['option.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#option-table").dataTable({
    		"aoColumns": [ null, null, null<?php if (Entrust::can("update_option")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_option")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
