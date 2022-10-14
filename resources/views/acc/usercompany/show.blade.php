@extends('app')

@section('htmlheader_title', 'Usercompany')

@section('contentheader_title', 'Usercompany')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $usercompany->id }}</td>
                <td>{{ $usercompany->name }}</td>
            </tr>
        </table>
    </div>

@endsection
