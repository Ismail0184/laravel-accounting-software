@extends('app')

@section('htmlheader_title', $langs['roles'])

@section('contentheader_title', $langs['roles'])

@section('main-content')

    <div class="box">
        <div class="box-header">
            @if (Entrust::can('create_roles'))
            <a href="{{ URL::route('roles.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['create'] }}</a>
            @endif
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="roles-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ $langs['display_name'] }}</th>
                        <th>{{ $langs['name'] }}</th>
                        <th>{{ $langs['level'] }}</th>
                        <th>{{ $langs['permissions'] }}</th>
                        @if (Entrust::can('update_roles'))
                        <th></th>
                        @endif
                        @if (Entrust::can('delete_roles'))
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    @if( $role->id != 1 || Entrust::hasRole('super_admin') )
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->display_name }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->level }}</td>
                        <td class="permissions">
                            @foreach($role->perms as $permission)
                                <span class="label label-info">{{ $permission->name }}</span>
                            @endforeach
                        </td>                        
                        @if (Entrust::can('update_roles'))
                        <td width="80">@if( $role->id != 1)<a class="btn btn-primary" href="{{ URL::route('roles.edit', $role->id) }}">{{ $langs['edit'] }}</a>@endif</td>
                        @endif
                        @if (Entrust::can('delete_roles'))
                        <td width="80">@if( $role->id != 1)
                        {!! Form::open(['route' => ['roles.update', $role->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit($langs['delete'], ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}@endif</td>
                        @endif
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {!! $roles->setPath('')->render() !!}

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#roles-table").dataTable({
    		"aoColumns": [ null, null, null, null, null<?php if (Entrust::can("update_roles")): ?>, { "bSortable": false }<?php endif; if (Entrust::can("delete_roles")): ?>, { "bSortable": false }<?php endif ?> ] 
    	});
    } );
</script>

@endsection