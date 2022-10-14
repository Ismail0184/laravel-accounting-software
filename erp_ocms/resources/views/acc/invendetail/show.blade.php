@extends('app')

@section('htmlheader_title', 'Invendetail')

@section('contentheader_title', 'Invendetail')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $invendetail->id }}</td>
                <td>{{ $invendetail->name }}</td>
            </tr>
        </table>
    </div>

@endsection
