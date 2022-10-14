@extends('app')

@section('htmlheader_title', 'Importdetail')

@section('contentheader_title', 'Importdetail')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $importdetail->id }}</td>
                <td>{{ $importdetail->name }}</td>
            </tr>
        </table>
    </div>

@endsection
