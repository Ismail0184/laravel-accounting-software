@extends('app')

@section('htmlheader_title', 'Usercompanies')

@section('contentheader_title', 'Usercompanies')

@section('main-content')
	<?php	
		Session::has('com_id') ? $com_id=Session::get('com_id') : $com_id='' ;  
		$com=DB::table('acc_companies')->where('id',$com_id)->first(); 
		$com_name=''; isset($com) && $com->id >0 ? $com_name=$com->name : $com_name='';
	?>
    <div class="box">
        <div class="box-header"><h3 class="pull-left" style="margin:0px; padding:0px">{{ $com_name }}</h3>
            @if (Entrust::can('create_usercompany'))
            <a href="{{ URL::route('usercompany.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['add_new'] }} Usercompany</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="usercompany-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ $langs['sl'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['user_id'] }}</th>
                        <th>{{ $langs['com_id'] }}</th>
                        <th>{{ $langs['setting'] }}</th>
                        @if (Entrust::can('update_usercompany'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_usercompany'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                {{-- */$x=0;/* --}}
                @foreach($usercompanies as $item)
                	<?php 
						$user=DB::table('users')->where('id', $item->users_id)->first(); 
						isset($user) && $user->id>0 ? $users=$user->name : $users=''; 
						$com=DB::table('acc_companies')->where('id', $item->com_id)->first(); 
						isset($com) && $com->id>0 ? $coms=$com->name : $coms=''; 
					?>
                    {{-- */$x++;/* --}}
                    <tr>
                        <td width="50">{{ $x }}</td>
                        <td><a href="{{ url('/usercompany', $item->id) }}">{{ $item->name }}</a></td>
                        <td>{{ $users }}</td>
                        <td>{{ $coms }}</td>
                        <td>{{ $item->setting }}</td>
                        @if (Entrust::can('update_usercompany'))
                        <td width="80"><a class="btn btn-primary btn-block" href="{{ URL::route('usercompany.edit', $item->id) }}">{{ $langs['edit'] }}</a></td> 
                        @endif
                        @if (Entrust::can('delete_usercompany'))
                        <td width="80">{!! Form::open(['route' => ['usercompany.destroy', $item->id], 'method' => 'DELETE']) !!}
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
        $("#usercompany-table").dataTable({
    		"aoColumns": [ null, null<?php if (Entrust::can("update_usercompany")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_usercompany")): ?>, { "bSortable": false }<?php endif ?> ]
    	});
    } );
</script>

@endsection
