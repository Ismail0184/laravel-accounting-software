@extends('app')

@section('htmlheader_title', 'Structure')

@section('contentheader_title', 'Structure')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $structure->id }}</td>
                <td>{{ $structure->name }}</td>
            </tr>
        </table>
    </div>

@endsection
