@extends('app')

@section('htmlheader_title', 'Lycraratio')

@section('contentheader_title', 'Lycraratio')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $lycraratio->id }}</td>
                <td>{{ $lycraratio->name }}</td>
            </tr>
        </table>
    </div>

@endsection
