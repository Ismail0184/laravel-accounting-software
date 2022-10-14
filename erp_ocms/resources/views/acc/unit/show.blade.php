@extends('app')

@section('htmlheader_title', 'Unit')

@section('contentheader_title', 'Unit')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $unit->id }}</td>
                <td>{{ $unit->name }}</td>
            </tr>
        </table>
    </div>

@endsection
