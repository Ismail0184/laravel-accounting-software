@extends('app')

@section('htmlheader_title', 'Ytype')

@section('contentheader_title', 'Ytype')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $ytype->id }}</td>
                <td>{{ $ytype->name }}</td>
            </tr>
        </table>
    </div>

@endsection
