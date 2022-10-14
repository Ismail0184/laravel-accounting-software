@extends('app')

@section('htmlheader_title', 'Aop')

@section('contentheader_title', 'Aop')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $aop->id }}</td>
                <td>{{ $aop->name }}</td>
            </tr>
        </table>
    </div>

@endsection
