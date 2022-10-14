@extends('app')

@section('htmlheader_title', 'Incoterm')

@section('contentheader_title', 'Incoterm')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $incoterm->id }}</td>
                <td>{{ $incoterm->name }}</td>
            </tr>
        </table>
    </div>

@endsection
