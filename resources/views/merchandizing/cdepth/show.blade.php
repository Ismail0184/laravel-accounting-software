@extends('app')

@section('htmlheader_title', 'Cdepth')

@section('contentheader_title', 'Cdepth')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $cdepth->id }}</td>
                <td>{{ $cdepth->name }}</td>
            </tr>
        </table>
    </div>

@endsection
