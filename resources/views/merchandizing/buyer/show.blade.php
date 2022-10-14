@extends('app')

@section('htmlheader_title', 'Buyer')

@section('contentheader_title', 'Buyer')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $buyer->id }}</td>
                <td>{{ $buyer->name }}</td>
            </tr>
        </table>
    </div>

@endsection
