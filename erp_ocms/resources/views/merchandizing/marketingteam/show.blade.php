@extends('app')

@section('htmlheader_title', 'Marketingteam')

@section('contentheader_title', 'Marketingteam')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $marketingteam->id }}</td>
                <td>{{ $marketingteam->name }}</td>
            </tr>
        </table>
    </div>

@endsection
