@extends('app')

@section('htmlheader_title', 'Orderinfo')

@section('contentheader_title', 'Orderinfo')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $orderinfo->id }}</td>
                <td>{{ $orderinfo->name }}</td>
            </tr>
        </table>
    </div>

@endsection
