@extends('app')

@section('htmlheader_title', 'Ftype')

@section('contentheader_title', 'Ftype')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $ftype->id }}</td>
                <td>{{ $ftype->name }}</td>
            </tr>
        </table>
    </div>

@endsection
