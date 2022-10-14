@extends('app')

@section('htmlheader_title', 'Condition')

@section('contentheader_title', 'Condition')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $condition->id }}</td>
                <td>{{ $condition->name }}</td>
            </tr>
        </table>
    </div>

@endsection
