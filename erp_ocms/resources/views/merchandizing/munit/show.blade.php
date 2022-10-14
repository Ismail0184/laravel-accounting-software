@extends('app')

@section('htmlheader_title', 'Munit')

@section('contentheader_title', 'Munit')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $munit->id }}</td>
                <td>{{ $munit->name }}</td>
            </tr>
        </table>
    </div>

@endsection
