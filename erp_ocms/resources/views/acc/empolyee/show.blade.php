@extends('app')

@section('htmlheader_title', 'Empolyee')

@section('contentheader_title', 'Empolyee')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $empolyee->id }}</td>
                <td>{{ $empolyee->name }}</td>
            </tr>
        </table>
    </div>

@endsection
