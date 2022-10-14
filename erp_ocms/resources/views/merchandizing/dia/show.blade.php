@extends('app')

@section('htmlheader_title', 'Dium')

@section('contentheader_title', 'Dium')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $dium->id }}</td>
                <td>{{ $dium->name }}</td>
            </tr>
        </table>
    </div>

@endsection
