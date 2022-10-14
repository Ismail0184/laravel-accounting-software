@extends('app')

@section('htmlheader_title', 'Mteam')

@section('contentheader_title', 'Mteam')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $mteam->id }}</td>
                <td>{{ $mteam->name }}</td>
            </tr>
        </table>
    </div>

@endsection
