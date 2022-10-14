@extends('app')

@section('htmlheader_title', 'Lcimport')

@section('contentheader_title', 'Lcimport')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $lcimport->id }}</td>
                <td>{{ $lcimport->name }}</td>
            </tr>
        </table>
    </div>

@endsection
