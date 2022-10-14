@extends('app')

@section('htmlheader_title', 'Reconciliation')

@section('contentheader_title', 'Reconciliation')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $reconciliation->id }}</td>
                <td>{{ $reconciliation->name }}</td>
            </tr>
        </table>
    </div>

@endsection
