@extends('app')

@section('htmlheader_title', 'Uoutlet')

@section('contentheader_title', 'Uoutlet')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $uoutlet->id }}</td>
                <td>{{ $uoutlet->name }}</td>
            </tr>
        </table>
    </div>

@endsection
