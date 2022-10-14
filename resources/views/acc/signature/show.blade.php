@extends('app')

@section('htmlheader_title', 'Signature')

@section('contentheader_title', 'Signature')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $signature->id }}</td>
                <td>{{ $signature->name }}</td>
            </tr>
        </table>
    </div>

@endsection
