@extends('app')

@section('htmlheader_title', 'Diatype')

@section('contentheader_title', 'Diatype')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $diatype->id }}</td>
                <td>{{ $diatype->name }}</td>
            </tr>
        </table>
    </div>

@endsection
