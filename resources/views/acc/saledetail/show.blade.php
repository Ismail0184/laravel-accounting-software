@extends('app')

@section('htmlheader_title', 'Saledetail')

@section('contentheader_title', 'Saledetail')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $saledetail->id }}</td>
                <td>{{ $saledetail->name }}</td>
            </tr>
        </table>
    </div>

@endsection
