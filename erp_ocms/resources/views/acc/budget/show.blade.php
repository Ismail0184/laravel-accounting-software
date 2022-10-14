@extends('app')

@section('htmlheader_title', 'Budget')

@section('contentheader_title', 'Budget')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $budget->id }}</td>
                <td>{{ $budget->name }}</td>
            </tr>
        </table>
    </div>

@endsection
