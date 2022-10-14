@extends('app')

@section('htmlheader_title', 'Coadetail')

@section('contentheader_title', 'Coadetail')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $coadetail->id }}</td>
                <td>{{ $coadetail->name }}</td>
            </tr>
        </table>
    </div>

@endsection
