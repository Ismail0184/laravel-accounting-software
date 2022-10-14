@extends('app')

@section('htmlheader_title', 'Project')

@section('contentheader_title', 'Project')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $project->id }}</td>
                <td>{{ $project->name }}</td>
            </tr>
        </table>
    </div>

@endsection
