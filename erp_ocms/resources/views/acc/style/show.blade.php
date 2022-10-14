@extends('app')

@section('htmlheader_title', 'Style')

@section('contentheader_title', 'Style')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $style->id }}</td>
                <td>{{ $style->name }}</td>
            </tr>
        </table>
    </div>

@endsection
