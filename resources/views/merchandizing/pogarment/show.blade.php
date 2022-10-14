@extends('app')

@section('htmlheader_title', 'Pogarment')

@section('contentheader_title', 'Pogarment')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $pogarment->id }}</td>
                <td>{{ $pogarment->name }}</td>
            </tr>
        </table>
    </div>

@endsection
