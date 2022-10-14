@extends('app')

@section('htmlheader_title', 'Employee basic info')

@section('contentheader_title', 'Employee basic info')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $employee_basic_info->id }}</td>
                <td>{{ $employee_basic_info->fullname }}</td>
            </tr>
        </table>
    </div>

@endsection
