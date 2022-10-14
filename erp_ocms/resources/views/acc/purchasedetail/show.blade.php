@extends('app')

@section('htmlheader_title', 'Purchasedetail')

@section('contentheader_title', 'Purchasedetail')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $purchasedetail->id }}</td>
                <td>{{ $purchasedetail->name }}</td>
            </tr>
        </table>
    </div>

@endsection
