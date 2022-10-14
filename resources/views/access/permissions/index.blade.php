@extends('app')

@section('htmlheader_title', $langs['permissions'])

@section('contentheader_title', $langs['permissions'])

@section('main-content')

    <div class="box">
        <div class="box-header">
            <a href="{{ URL::route('permissions.create') }}" class="btn btn-primary pull-right btn-sm">{{ $langs['create'] }}</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="permissions-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ $langs['display_name'] }}</th>
                    <th>{{ $langs['name'] }}</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->display_name }}</td>
                        <td>{{ $permission->name }}</td>
                        <td width="80"><a class="btn btn-edit btn-block" title="{{ $langs['edit'] }}" href="{{ URL::route('permissions.edit', $permission['id']) }}"><i class="fa fa-edit"></i></a></td> 
                        <td width="80">{!! Form::open(['route' => ['permissions.update', $permission->id], 'method' => 'DELETE']) !!}
                            {!! Form::submit('&#xf1f8;', ['class' => 'btn btn-delete btn-block fa', 'title' => $langs['delete'], 'onclick' => 'return confirm("Are you sure?");']) !!}
                            {!!  Form::close() !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    {!! $permissions->setPath('')->render() !!}

@endsection

@section('custom-scripts')

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#permissions-table").dataTable({
    		"aoColumns": [ null, null, null, { "bSortable": false }, { "bSortable": false } ]
    	});
    } );
</script>

@endsection