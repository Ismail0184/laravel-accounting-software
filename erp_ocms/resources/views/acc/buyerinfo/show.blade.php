@extends('app')

@section('htmlheader_title', 'Buyerinfo')

@section('contentheader_title', 'Buyerinfo')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $buyerinfo->id }}</td>
                <td>{{ $buyerinfo->name }}</td>
            </tr>
        </table>
    </div>

@endsection
