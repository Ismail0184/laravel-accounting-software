@extends('app')

@section('htmlheader_title', 'Outlet')

@section('contentheader_title', 'Outlet')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $outlet->id }}</td>
                <td>{{ $outlet->name }}</td>
            </tr>
        </table>
    </div>

@endsection
