@extends('app')

@section('htmlheader_title', 'Bdtype')

@section('contentheader_title', 'Bdtype')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $bdtype->id }}</td>
                <td>{{ $bdtype->name }}</td>
            </tr>
        </table>
    </div>

@endsection
