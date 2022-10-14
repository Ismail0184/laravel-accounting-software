@extends('app')

@section('htmlheader_title', 'Topic')

@section('contentheader_title', 'Topic')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $topic->id }}</td>
                <td>{{ $topic->name }}</td>
            </tr>
        </table>
    </div>

@endsection
