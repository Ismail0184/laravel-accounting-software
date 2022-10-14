@extends('app')

@section('htmlheader_title', 'Fabricdetail')

@section('contentheader_title', 'Fabricdetail')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $fabricdetail->id }}</td>
                <td>{{ $fabricdetail->name }}</td>
            </tr>
        </table>
    </div>

@endsection
