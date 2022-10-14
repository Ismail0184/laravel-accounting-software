@extends('app')

@section('htmlheader_title', 'Option')

@section('contentheader_title', 'Option')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $option->id }}</td>
                <td>{{ $option->name }}</td>
            </tr>
        </table>
    </div>

@endsection
