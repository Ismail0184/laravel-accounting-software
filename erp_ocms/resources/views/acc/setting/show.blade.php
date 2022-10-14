@extends('app')

@section('htmlheader_title', 'Setting')

@section('contentheader_title', 'Setting')

@section('main-content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>{{ $langs['id'] }}</th>
                <th>{{ $langs['name'] }}</th>
            </tr>
            <tr>
                <td>{{ $setting->id }}</td>
                <td>{{ $setting->name }}</td>
            </tr>
        </table>
    </div>

@endsection
