@extends('app')

@section('htmlheader_title', 'Gtype')

@section('contentheader_title', 'Gtype')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $gtype->id }}</td>
                <td>{{ $gtype->name }}</td>
            </tr>
        </table>
    </div>

@endsection
