@extends('app')

@section('htmlheader_title', 'Ittype')

@section('contentheader_title', 'Ittype')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $ittype->id }}</td>
                <td>{{ $ittype->name }}</td>
            </tr>
        </table>
    </div>

@endsection
