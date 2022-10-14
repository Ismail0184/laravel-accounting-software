@extends('app')

@section('htmlheader_title', 'Pplanning')

@section('contentheader_title', 'Pplanning')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $pplanning->id }}</td>
                <td>{{ $pplanning->name }}</td>
            </tr>
        </table>
    </div>

@endsection
