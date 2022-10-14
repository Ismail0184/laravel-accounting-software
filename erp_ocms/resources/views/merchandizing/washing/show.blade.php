@extends('app')

@section('htmlheader_title', 'Washing')

@section('contentheader_title', 'Washing')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $washing->id }}</td>
                <td>{{ $washing->name }}</td>
            </tr>
        </table>
    </div>

@endsection
