@extends('app')

@section('htmlheader_title', 'Salary')

@section('contentheader_title', 'Salary')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $salary->id }}</td>
                <td>{{ $salary->name }}</td>
            </tr>
        </table>
    </div>

@endsection
