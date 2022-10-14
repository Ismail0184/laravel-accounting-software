@extends('app')

@section('htmlheader_title', 'Coacondition')

@section('contentheader_title', 'Coacondition')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $coacondition->id }}</td>
                <td>{{ $coacondition->name }}</td>
            </tr>
        </table>
    </div>

@endsection
