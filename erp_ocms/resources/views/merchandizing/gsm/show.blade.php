@extends('app')

@section('htmlheader_title', 'Gsm')

@section('contentheader_title', 'Gsm')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $gsm->id }}</td>
                <td>{{ $gsm->name }}</td>
            </tr>
        </table>
    </div>

@endsection
