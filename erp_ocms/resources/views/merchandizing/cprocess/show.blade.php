@extends('app')

@section('htmlheader_title', 'Cprocess')

@section('contentheader_title', 'Cprocess')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $cprocess->id }}</td>
                <td>{{ $cprocess->name }}</td>
            </tr>
        </table>
    </div>

@endsection
