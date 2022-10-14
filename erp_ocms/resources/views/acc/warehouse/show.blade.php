@extends('app')

@section('htmlheader_title', 'Warehouse')

@section('contentheader_title', 'Warehouse')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $warehouse->id }}</td>
                <td>{{ $warehouse->name }}</td>
            </tr>
        </table>
    </div>

@endsection
