@extends('app')

@section('htmlheader_title', 'Department')

@section('contentheader_title', 'Department')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $department->id }}</td>
                <td>{{ $department->name }}</td>
            </tr>
        </table>
    </div>

@endsection
