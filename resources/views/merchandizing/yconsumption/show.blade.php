@extends('app')

@section('htmlheader_title', 'Yconsumption')

@section('contentheader_title', 'Yconsumption')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $yconsumption->id }}</td>
                <td>{{ $yconsumption->name }}</td>
            </tr>
        </table>
    </div>

@endsection
