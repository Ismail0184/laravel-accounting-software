@extends('app')

@section('htmlheader_title', 'Subhead')

@section('contentheader_title', 'Subhead')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $subhead->id }}</td>
                <td>{{ $subhead->name }}</td>
            </tr>
        </table>
    </div>

@endsection
