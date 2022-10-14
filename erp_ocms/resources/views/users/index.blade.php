@extends('app')

@section('htmlheader_title', 'Users')

@section('contentheader_title', 'Users')

@section('main-content')
    <div class="box">
        <div class="box-header">
            @if (Entrust::can('trashed_users'))
            <a href="{{ url('users/trashed') }}" class="btn btn-danger pull-right btn-sm trash-btn"><i class="fa fa-trash "></i></a>
            @endif
            @if (Entrust::can('create_users'))
            <a href="{{ URL::route('users.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['create'] }}</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="users-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ $langs['name'] }}</th>
                    <th>{{ $langs['email'] }}</th>
                    <th>{{ $langs['roles'] }}</th>
                    @if (Entrust::can('update_users'))
                    <th></th>
                    @endif
                    @if (Entrust::can('delete_users'))
                    <th></th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                @if( !$user->hasRole('super_admin') || Entrust::hasRole('super_admin') )
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="label label-info">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        @if (Entrust::can('update_users'))
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('users.edit', $user->id) }}"><i class="fa fa-edit"></i></a></td>
                        @endif
                        @if (Entrust::can('delete_users'))
                        <td width="80">{!! Form::open(['route' => ['users.update', $user->id], 'method' => 'DELETE']) !!}
                                {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
                        @endif
                    </tr>
                @endif
                @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    {!! $users->setPath('')->render() !!}

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#users-table").dataTable({
    		"aoColumns": [ null, null, null, null<?php if (Entrust::can("update_roles")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_roles")): ?>, { "bSortable": false }<?php endif ?> ] 
    	});
    } );
</script>

@endsection