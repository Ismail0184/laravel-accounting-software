@extends('app')

@section('htmlheader_title', 'Port')

@section('contentheader_title', 'Port')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $port->id }}</td>
                <td>{{ $port->name }}</td>
            </tr>
        </table>
    </div>

@endsection
