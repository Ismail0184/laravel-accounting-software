@extends('app')

@section('htmlheader_title', 'Depthtype')

@section('contentheader_title', 'Depthtype')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $depthtype->id }}</td>
                <td>{{ $depthtype->name }}</td>
            </tr>
        </table>
    </div>

@endsection
