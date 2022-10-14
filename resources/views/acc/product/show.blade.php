@extends('app')

@section('htmlheader_title', 'Product')

@section('contentheader_title', 'Product')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
            </tr>
        </table>
    </div>

@endsection
