@extends('app')

@section('contentheader_title', 'COA')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $acccoa->id }}</td>
                <td>{{ $acccoa->name }}</td>
            </tr>
        </table>
    </div>

@endsection
