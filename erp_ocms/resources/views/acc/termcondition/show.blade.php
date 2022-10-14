@extends('app')

@section('htmlheader_title', 'Termcondition')

@section('contentheader_title', 'Termcondition')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $termcondition->id }}</td>
                <td>{{ $termcondition->name }}</td>
            </tr>
        </table>
    </div>

@endsection
