@extends('app')

@section('htmlheader_title', 'Desigtn')

@section('contentheader_title', 'Desigtn')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $desigtn->id }}</td>
                <td>{{ $desigtn->name }}</td>
            </tr>
        </table>
    </div>

@endsection
