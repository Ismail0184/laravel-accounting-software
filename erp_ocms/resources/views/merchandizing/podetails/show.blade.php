@extends('app')

@section('htmlheader_title', 'Podetail')

@section('contentheader_title', 'Podetail')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $podetail->id }}</td>
                <td>{{ $podetail->name }}</td>
            </tr>
        </table>
    </div>

@endsection
