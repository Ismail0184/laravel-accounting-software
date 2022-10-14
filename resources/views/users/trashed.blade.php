@extends('app')

@section('htmlheader_title', 'Trashed Users')

@section('contentheader_title', 'Trashed Users')

@section('main-content')

    <div class="box">
        <div class="box-header">
            <a href="{{ URL::route('users.index') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['back_to'] }} User</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="users-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['email'] }}</th>
                        <th>{{ $langs['department'] }}</th>
                        <th>{{ $langs['roles'] }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                @if( !$user->hasRole('super_admin') || Entrust::hasRole('super_admin') )
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->department->name }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="label label-info">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td width="80">{!! Form::open(array('action' => array('UsersController@restore', $user->id))) !!}
                            {!! Form::submit($langs['restore'], ['class' => 'btn btn-warning btn-block', 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
                    </tr>
                @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#users-table").dataTable({
    		"aoColumns": [ null, null, null, null, null, { "bSortable": false } ] 
    	});
    } );
</script>

@endsection
