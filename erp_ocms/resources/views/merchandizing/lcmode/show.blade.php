@extends('app')

@section('htmlheader_title', 'Lcmode')

@section('contentheader_title', 'Lcmode')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $lcmode->id }}</td>
                <td>{{ $lcmode->name }}</td>
            </tr>
        </table>
    </div>

@endsection
