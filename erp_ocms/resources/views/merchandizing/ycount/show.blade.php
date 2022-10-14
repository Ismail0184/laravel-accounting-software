@extends('app')

@section('htmlheader_title', 'Ycount')

@section('contentheader_title', 'Ycount')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $ycount->id }}</td>
                <td>{{ $ycount->name }}</td>
            </tr>
        </table>
    </div>

@endsection
