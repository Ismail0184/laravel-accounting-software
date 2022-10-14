@extends('app')

@section('htmlheader_title', 'Finishing')

@section('contentheader_title', 'Finishing')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $finishing->id }}</td>
                <td>{{ $finishing->name }}</td>
            </tr>
        </table>
    </div>

@endsection
