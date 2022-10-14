@extends('app')

@section('htmlheader_title', 'Trandetail')

@section('contentheader_title', 'Trandetail')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $trandetail->id }}</td>
                <td>{{ $trandetail->name }}</td>
            </tr>
        </table>
    </div>

@endsection
