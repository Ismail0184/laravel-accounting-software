@extends('app')

@section('htmlheader_title', 'Page')

@section('contentheader_title', 'Page')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $page->id }}</td>
                <td>{{ $page->name }}</td>
            </tr>
        </table>
    </div>

@endsection
