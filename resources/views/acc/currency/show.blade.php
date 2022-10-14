@extends('app')

@section('htmlheader_title', 'Currency')

@section('contentheader_title', 'Currency')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $currency->id }}</td>
                <td>{{ $currency->name }}</td>
            </tr>
        </table>
    </div>

@endsection
