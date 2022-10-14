@extends('app')

@section('htmlheader_title', 'Ccuff')

@section('contentheader_title', 'Ccuff')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $ccuff->id }}</td>
                <td>{{ $ccuff->name }}</td>
            </tr>
        </table>
    </div>

@endsection
